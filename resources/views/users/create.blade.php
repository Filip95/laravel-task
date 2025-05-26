@extends('layouts.adminlte')

@section('title', 'Create User')

@section('content')
<div class="content-header">
  <h1>Create User</h1>
</div>
<div class="content">
  <form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}">
      @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}">
      @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
      <label>Password</label>
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
          <option value="{{ $perm->name }}">{{ $perm->name }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
  </form>
</div>
@endsection

