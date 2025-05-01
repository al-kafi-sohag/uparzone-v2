@extends('admin.layout.master')

@section('title', 'Post Category List')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Post Category List</h1>
            <a href="{{ route('admin.post-category.create') }}" class="btn btn-primary">Add New Post Category</a>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post_categories as $post_category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post_category->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $post_category->status_badge }}">{{ $post_category->status_name }}</span>
                                </td>
                                <td>{{ $post_category->created_at }}</td>
                                <td>{{ $post_category->updated_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.post-category.edit', $post_category->id) }}" class="btn btn-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.post-category.delete', $post_category->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
