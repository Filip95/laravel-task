@extends('layouts.adminlte')

@section('title', 'Imports Log')

@section('content')
    <div class="content-header">
        <h1>Imports Log</h1>
    </div>
    <div class="content">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Filename</th>
                <th>User</th>
                <th>Status</th>
                <th>Imported At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($imports as $import)
                <tr>
                    <td>{{ $import->id }}</td>
                    <td>{{ $import->type }}</td>
                    <td>{{ $import->filename }}</td>
                    <td>{{ $import->user->name }}</td>
                    <td>{{ ucfirst($import->status) }}</td>
                    <td>{{ $import->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('imports.errors', $import) }}" class="btn btn-sm btn-info">View Errors</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $imports->links() }}
    </div>
@endsection
