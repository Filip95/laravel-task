@extends('layouts.adminlte')

@section('title', 'Create Permission')

@section('content')
<div class="content-header">
  <h1>Create Permission</h1>
</div>
<div class="content">
  <form action="{{ route('permissions.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}">
      @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-success">Save</button>
  </form>
</div>
@endsection
