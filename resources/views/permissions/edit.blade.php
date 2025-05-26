@extends('layouts.adminlte')

@section('title', 'Edit Permission')

@section('content')
<div class="content-header">
  <h1>Edit Permission</h1>
</div>
<div class="content">
  <form action="{{ route('permissions.update', $permission) }}" method="POST">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}">
      @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-success">Update</button>
  </form>
</div>
@endsection
