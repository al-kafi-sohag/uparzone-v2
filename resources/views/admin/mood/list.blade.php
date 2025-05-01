@extends('admin.layout.master')

@section('title', 'Mood List')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Mood List</h1>
            <a href="{{ route('admin.mood.create') }}" class="btn btn-primary">Add New Mood</a>
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
                        @foreach ($moods as $mood)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mood->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $mood->status_badge }}">{{ $mood->status_name }}</span>
                                </td>
                                <td>{{ $mood->created_at }}</td>
                                <td>{{ $mood->updated_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.mood.edit', $mood->id) }}" class="btn btn-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.mood.delete', $mood->id) }}" method="POST"
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
