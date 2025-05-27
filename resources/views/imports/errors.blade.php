@extends('layouts.adminlte')

@section('title', 'Import Errors')

@section('content')
    <div class="content-header">
        <h1>Errors for Import #{{ $import->id }}</h1>
    </div>
    <div class="content">
        <a href="{{ route('imports.log') }}" class="btn btn-secondary mb-3">Back to Log</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Row</th>
                <th>Column</th>
                <th>Value</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
            @foreach($errors as $error)
                <tr>
                    <td>{{ $error->row_number }}</td>
                    <td>{{ $error->column }}</td>
                    <td>{{ $error->value }}</td>
                    <td>{{ $error->message }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $errors->links() }}
    </div>
@endsection
