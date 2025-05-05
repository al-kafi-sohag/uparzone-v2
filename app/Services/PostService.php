<?php

namespace App\Services;

use App\Models\TemporaryMedia;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PostService
{
    public function uploadTemporaryFile(UploadedFile $file, int $userId): array
    {
        try {
            DB::beginTransaction();
            $tempMedia = TemporaryMedia::create([
                'user_id' => $userId,
            ]);
            $media = $tempMedia->addMedia($file)
                ->toMediaCollection('temp_media');

            DB::commit();

            return [
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => [
                    'temp_id' => $tempMedia->temp_id,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getFullUrl(),
                    'is_image' => str_contains($media->mime_type, 'image'),
                ]
            ];
        } catch (FileDoesNotExist | FileIsTooBig $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }


    public function removeTemporaryFile(string $tempId): array
    {
        try {
            $tempMedia = TemporaryMedia::where('temp_id', $tempId)
                ->first();

            if (!$tempMedia) {
                return [
                    'success' => false,
                    'message' => 'Temporary media not found'
                ];
            }

            $tempMedia->clearMediaCollection('temp_media');
            $tempMedia->delete();

            return [
                'success' => true,
                'message' => 'File removed successfully'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to remove file: ' . $e->getMessage(),
            ];
        }
    }


    public function moveTemporaryFileToPost(string $tempId, Post $post): bool
    {
        $tempMedia = TemporaryMedia::where('temp_id', $tempId)
            ->first();

        if (!$tempMedia || !$tempMedia->hasMedia('temp_media')) {
            throw new \Exception('No media found for this post');
        }

        $tempMedia->getFirstMedia('temp_media')
            ->move($post, 'post_media');

        $tempMedia->delete();

        return true;
    }
}
