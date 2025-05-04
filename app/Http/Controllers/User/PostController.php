<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\PostFileUploadRequest;
use App\Models\PostCategory;
use App\Models\Mood;
use App\Models\Religion;
use App\Models\Gender;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('auth:web');
        $this->postService = $postService;
    }

    public function create()
    {
        $data['categories'] = PostCategory::active()->orderBy('order', 'asc')->get();
        $data['moods'] = Mood::active()->orderBy('order', 'asc')->get();
        $data['religions'] = Religion::active()->get();
        $data['genders'] = Gender::active()->get();
        return view('user.post.create', $data);
    }

    /**
     * Upload media file to temporary storage
     */
    public function uploadMedia(PostFileUploadRequest $request)
    {
        try {
            $result = $this->postService->uploadTemporaryFile(
                $request->file('file'),
                auth('web')->user()->id
            );

            if (!$result['success']) {
                return response()->json($result, 400);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove temporary media file
     */
    public function removeMedia(Request $request)
    {
        try {
            $result = $this->postService->removeTemporaryFile(
                $request->temp_id,
                auth('web')->user()->id
            );

            if (!$result['success']) {
                return response()->json($result, 404);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new post
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'temp_id' => 'required|string',
            'category_id' => 'nullable|exists:post_categories,id',
            'religion_id' => 'nullable|exists:religions,id',
            'mood_id' => 'nullable|exists:moods,id',
            'gender_id' => 'nullable|exists:genders,id',
            'is_adult_content' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Create the post
            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth('web')->user()->id,
                'category_id' => $request->category_id !== 'all' ? $request->category_id : null,
                'religion_id' => $request->religion_id !== 'all' ? $request->religion_id : null,
                'mood_id' => $request->mood_id !== 'all' ? $request->mood_id : null,
                'gender_id' => $request->gender_id !== 'all' ? $request->gender_id : null,
                'is_adult_content' => $request->is_adult_content ?? false,
                'status' => 'active',
            ]);

            // Move temporary file to post
            $this->postService->moveTemporaryFileToPost(
                $request->temp_id,
                auth('web')->user()->id,
                $post
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => [
                    'post_id' => $post->id,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
