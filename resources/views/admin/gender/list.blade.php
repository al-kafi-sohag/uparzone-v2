@extends('admin.layout.master')

@section('title', 'Gender List')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Gender List</h1>
            <a href="{{ route('admin.gender.create') }}" class="btn btn-primary">Add New Gender</a>
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
                        @foreach ($genders as $gender)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $gender->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $gender->status_badge }}">{{ $gender->status_name }}</span>
                                </td>
                                <td>{{ $gender->created_at }}</td>
                                <td>{{ $gender->updated_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.gender.edit', $gender->id) }}" class="btn btn-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.gender.delete', $gender->id) }}" method="POST"
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
