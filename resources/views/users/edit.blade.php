@extends('layouts.adminlte')

@section('title', 'Edit User')

@section('content')
<div class="content-header">
  <h1>Edit User</h1>
</div>
<div class="content">
  <form action="{{ route('users.update', $user) }}" method="POST">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
      @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
      @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
      <label>Password (leave blank to keep current)</label>
      <input type="password" name="password" class="form-control">
      @error('password') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control">
    </div>
    <div class="form-group">
      <label>Permissions</label>
      <select name="permissions[]" multiple class="form-control">
        @foreach($permissions as $perm)
          <option value="{{ $perm->name }}"
            {{ in_array($perm->name, old('permissions', $user->getPermissionNames()->toArray())) ? 'selected' : '' }}>
            {{ $perm->name }}
          </option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
  </form>
</div>
@endsection
