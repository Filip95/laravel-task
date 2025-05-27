@extends('layouts.adminlte')

@section('title', $cfg['label'])

@section('content')
    <div class="content-header">
        <h1>{{ $cfg['label'] }}</h1>
    </div>
    <div class="content">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                @foreach($cfg['headers_to_db'] as $headerKey => $column)
                    <th>{{ Str::title(str_replace($headerKey, ucfirst($column), $headerKey)) }}</th>
                @endforeach
                <th>Imported At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    @foreach($cfg['headers_to_db'] as $column)
                        <td>{{ $item->{$column} }}</td>
                    @endforeach
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $items->links() }}
    </div>
@endsection
