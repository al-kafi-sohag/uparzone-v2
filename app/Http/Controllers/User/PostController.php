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
use App\Http\Requests\User\PostUploadRequest;
use App\Models\UserTransaction;
use Illuminate\Support\Facades\DB;
use App\Services\UserTransactionService;
use App\Services\UserBalanceService;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $postService;
    protected UserTransactionService $userTransactionService;
    protected UserBalanceService $userBalanceService;

    public function __construct(PostService $postService, UserTransactionService $userTransactionService, UserBalanceService $userBalanceService)
    {
        $this->middleware('auth:web');
        $this->postService = $postService;
        $this->userTransactionService = $userTransactionService;
        $this->userBalanceService = $userBalanceService;
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
            Log::error($e->getMessage());
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
                $request->temp_id
            );

            if (!$result['success']) {
                return response()->json($result, 404);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
    public function store(PostUploadRequest $request)
    {

        try {
            DB::beginTransaction();

            // Create the post
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->description,
                'user_id' => user()->id,
                'post_category_id' => $request->category_id !== 'all' ? $request->category_id : null,
                'religion_id' => $request->religion_id !== 'all' ? $request->religion_id : null,
                'mood_id' => $request->mood_id !== 'all' ? $request->mood_id : null,
                'gender_id' => $request->gender_id !== 'all' ? $request->gender_id : null,
                'is_adult' => $request->is_adult_content ?? false,
                'status' => 1,
            ]);

            // Move temporary file to post
            $this->postService->moveTemporaryFileToPost(
                $request->temp_id,
                $post
            );

            //reward calculation
            $count = Post::where('user_id', user()->id)->count();
            if ($count > 0) {
                $reward = 10.0 / (2 ** ($count - 1));
                $reward = max($reward, 0.03); // Cap at 0.03

                $this->userTransactionService->createTransaction(user()->id, null, $reward, 'Reward for post ' . $count, UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_CREDIT);
                $this->userBalanceService->setUser(user()->id)->addBalance($reward);
            }
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
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
