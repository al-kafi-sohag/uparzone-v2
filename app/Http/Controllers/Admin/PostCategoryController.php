<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PostCategoryRequest;
use App\Models\PostCategory;

class PostCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {
        $data['post_categories'] = PostCategory::orderBy('order', 'asc')->get();
        return view('admin.post-category.list', $data);
    }

    public function create()
    {
        return view('admin.post-category.create');
    }

    public function store(PostCategoryRequest $request)
    {
        PostCategory::create($request->validated());
        sweetalert()->success('Post Category created successfully');
        return redirect()->route('admin.post-category.list');
    }

    public function edit($id)
    {
        $data['post_category'] = PostCategory::findOrFail($id);
        return view('admin.post-category.edit', $data);
    }

    public function update(PostCategoryRequest $request, $id)
    {
        $post_category = PostCategory::findOrFail($id);
        $post_category->update($request->validated());
        sweetalert()->success('Post Category updated successfully');
        return redirect()->route('admin.post-category.list');
    }

    public function delete(Request $request)
    {
        $post_category = PostCategory::findOrFail($request->id);
        $post_category->delete();
        sweetalert()->success('Post Category deleted successfully');
        return redirect()->route('admin.post-category.list');
    }
}
