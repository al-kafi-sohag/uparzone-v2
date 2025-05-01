@extends('admin.layout.master')

@section('title', 'Religion List')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Religion List</h1>
            <a href="{{ route('admin.religion.create') }}" class="btn btn-primary">Add New Religion</a>
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
                        @foreach ($religions as $religion)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $religion->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $religion->status_badge }}">{{ $religion->status_name }}</span>
                                </td>
                                <td>{{ $religion->created_at }}</td>
                                <td>{{ $religion->updated_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.religion.edit', $religion->id) }}" class="btn btn-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.religion.delete', $religion->id) }}" method="POST"
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
