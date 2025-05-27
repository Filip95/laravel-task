@extends('layouts.adminlte')

@section('title', 'Data Import')

@section('content')
<div class="content-header">
    <h1>Data Import</h1>
</div>
<div class="content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('import.handle') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="type">Import Type</label>
            <select name="type" id="type" class="form-control">
                <option value="">-- Select Type --</option>
                @foreach($types as $key => $cfg)
                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                        {{ $cfg['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="type-details" class="mb-3" style="display:none;">
            <p><strong>Allowed Filename(s):</strong> <span id="allowed-files"></span></p>
            <p><strong>Required Headers:</strong> <span id="required-headers"></span></p>
        </div>

        <div class="form-group">
            <label for="file">Choose File</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Upload & Import</button>
    </form>
</div>

@push('scripts')
<script>
    const importConfigs = @json($types);

    function updateDetails() {
        const select = document.getElementById('type');
        const details = document.getElementById('type-details');
        const allowedFiles = document.getElementById('allowed-files');
        const requiredHeaders = document.getElementById('required-headers');
        const cfg = importConfigs[select.value];

        if (cfg) {
            allowedFiles.textContent = cfg.files.join(', ');
            requiredHeaders.textContent = Object.keys(cfg.headers_to_db).join(', ');
            details.style.display = '';
        } else {
            details.style.display = 'none';
        }
    }
    document.getElementById('type').addEventListener('change', updateDetails);
    window.addEventListener('DOMContentLoaded', updateDetails);
</script>
@endpush

@endsection
