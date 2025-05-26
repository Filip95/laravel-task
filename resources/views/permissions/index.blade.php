@extends('layouts.adminlte')

@section('title', 'Permissions')

@section('content')
<div class="content-header">
  <h1>Permissions</h1>
</div>
<div class="content">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">Create Permission</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($permissions as $permission)
      <tr>
        <td>{{ $permission->name }}</td>
        <td>
          <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this permission?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $permissions->links() }}
</div>
@endsection
