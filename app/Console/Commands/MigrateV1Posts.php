<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Mood;
use App\Models\Religion;
use App\Models\Gender;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateV1Posts extends Command
{
    protected $signature = 'migrate:v1-posts {--start= : Starting ID} {--end= : Ending ID}';
    protected $description = 'Migrate posts from v1 to v2 with media handling';
    protected $progressFile = 'last_migrated_post.txt';

    public function handle()
    {
        $start = $this->option('start') ?: $this->getLastMigratedId() + 1;
        $end = $this->option('end') ?: DB::connection('v1')->table('posts')->max('id');

        $this->info("Migrating posts from ID $start to $end");

        $query = DB::connection('v1')->table('posts')
            ->whereBetween('id', [$start, $end])
            ->orderBy('id');

        $query->chunk(100, function ($v1Posts) {
            foreach ($v1Posts as $v1Post) {
                // Skip already migrated posts
                if (DB::table('posts')->where('id', $v1Post->id)->exists()) {
                    $this->warn("Post ID {$v1Post->id} already exists. Skipping...");
                    continue;
                }

                try {
                    DB::transaction(function () use ($v1Post) {
                        // Map relationships
                        $category = $this->getOrCreateCategory($v1Post->category);
                        $mood = $this->getOrCreateMood($v1Post->mood);
                        $religion = $this->getOrCreateReligion($v1Post->religion);
                        $gender = $this->getOrCreateGender($v1Post->gender);

                        // Create base post
                        $post = Post::create([
                            'id' => $v1Post->id,
                            'title' => $v1Post->title,
                            'slug' => Str::slug($v1Post->title) . '-' . $v1Post->id,
                            'content' => $v1Post->content,
                            'status' => $this->mapStatus($v1Post->status),
                            'user_id' => $v1Post->user_id,
                            'post_category_id' => $category->id,
                            'mood_id' => $mood->id,
                            'religion_id' => $religion->id,
                            'gender_id' => $gender->id,
                            'is_adult' => strtolower($v1Post->adult) === 'yes' ? 1 : 0,
                            'is_pinned' => $v1Post->prority > 5 ? 1 : 0, // Assuming priority maps to pinned
                            'is_featured' => 0, // Default to not featured
                            'views' => 0,
                            'reactions' => 0,
                            'shares' => 0,
                            'comments' => 0,
                            'created_at' => $v1Post->created_at,
                            'updated_at' => $v1Post->updated_at,
                        ]);

                        // Handle media migration
                        if ($v1Post->media) {
                            $this->migrateMedia($post, $v1Post->media, $v1Post->drive);
                        }

                        $this->updateProgress($v1Post->id);
                        $this->info("Migrated post ID: {$v1Post->id}");
                    });
                } catch (\Exception $e) {
                    $this->error("Failed migrating post ID {$v1Post->id}: " . $e->getMessage());
                }
            }
        });

        $this->info('Post migration completed!');
    }

    private function getLastMigratedId()
    {
        return file_exists($this->progressFile)
            ? (int) file_get_contents($this->progressFile)
            : 0;
    }

    private function updateProgress($id)
    {
        file_put_contents($this->progressFile, $id);
    }

    private function mapStatus($status)
    {
        return match (strtolower($status)) {
            'approved' => 1,
            'pending' => 0,
            'inactive' => 2,
            default => 0,
        };
    }

    private function getOrCreateCategory($name)
    {
        return PostCategory::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
    }

    private function getOrCreateMood($name)
    {
        return Mood::firstOrCreate(['name' => $name]);
    }

    private function getOrCreateReligion($name)
    {
        return Religion::firstOrCreate(['name' => $name]);
    }

    private function getOrCreateGender($name)
    {
        return Gender::firstOrCreate(['name' => $name]);
    }

    private function migrateMedia($post, $mediaPath, $drive)
    {
        try {
            $sourcePath = $this->getSourcePath($drive, $mediaPath);

            if (!Storage::disk('v1')->exists($sourcePath)) {
                throw new \Exception("Media file not found: $sourcePath");
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'media');
            file_put_contents($tempFile, Storage::disk('v1')->get($sourcePath));

            $post->addMedia($tempFile)
                ->withCustomProperties(['source' => 'v1_migration'])
                ->toMediaCollection('posts');

            unlink($tempFile);
        } catch (\Exception $e) {
            $this->error("Media migration failed for post {$post->id}: " . $e->getMessage());
        }
    }

    private function getSourcePath($drive, $path)
    {
        if ($drive === 'local') {
            return 'public/' . ltrim($path, '/');
        }

        return $path; // Adjust for other drivers if needed
    }
}
