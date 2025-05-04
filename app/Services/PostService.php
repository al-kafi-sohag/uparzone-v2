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
    /**
     * Upload a file to temporary storage using Spatie Media Library
     *
     * @param UploadedFile $file
     * @param int $userId
     * @return array
     * @throws \Exception
     */
    public function uploadTemporaryFile(UploadedFile $file, int $userId): array
    {
        try {
            DB::beginTransaction();

            // Create temporary media record
            $tempMedia = TemporaryMedia::create([
                'user_id' => $userId,
            ]);

            // Add media to the temporary record
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

    /**
     * Remove a temporary file
     *
     * @param string $tempId
     * @param int $userId
     * @return array
     */
    public function removeTemporaryFile(string $tempId, int $userId): array
    {
        try {
            $tempMedia = TemporaryMedia::where('temp_id', $tempId)
                ->where('user_id', $userId)
                ->first();

            if (!$tempMedia) {
                return [
                    'success' => false,
                    'message' => 'Temporary media not found'
                ];
            }

            // Delete the media files
            $tempMedia->clearMediaCollection('temp_media');

            // Delete the record
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

    /**
     * Move a temporary file to a post
     *
     * @param string $tempId
     * @param int $userId
     * @param Post $post
     * @return bool
     * @throws \Exception
     */
    public function moveTemporaryFileToPost(string $tempId, int $userId, Post $post): bool
    {
        $tempMedia = TemporaryMedia::where('temp_id', $tempId)
            ->where('user_id', $userId)
            ->first();

        if (!$tempMedia || !$tempMedia->hasMedia('temp_media')) {
            throw new \Exception('No media found for this post');
        }

        // Move media from temporary to post
        $tempMedia->getFirstMedia('temp_media')
            ->move($post, 'post_media');

        // Delete the temporary media record
        $tempMedia->delete();

        return true;
    }
}
