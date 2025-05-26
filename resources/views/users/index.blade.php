@extends('layouts.adminlte');

@section('title', 'Users')

@section('content')
<div class="content-header">
  <h1>Users</h1>
</div>
<div class="content">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create User</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Permissions</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->getPermissionNames()->join(', ') }}</td>
        <td>
          <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $users->links() }}
</div>
@endsection
