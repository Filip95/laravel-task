<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\HeadingRowImport;
use App\Jobs\ProcessImport;


class ImportController extends Controller
{
    public function showForm(){
        $types = collect(config('imports'))
            ->filter(fn($cfg) => Auth::user()->can($cfg['permission']));

            return view('import.form', compact('types'));
    }

    public function handle(Request $request) {
        $allTypes = array_keys(config('imports'));

        $data = $request->validate([
            'type' => ['required','in:'.implode(',', $allTypes)],
            'file' => ['required','file','mimes:csv,xlsx'],
        ]);

        $cfg = config("imports.{$data['type']}");
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $relativePath = $request->file('file')->store('imports');
        $fullPath = Storage::path($relativePath);

        if($extension === 'csv') {
            $fh = fopen($fullPath, 'r');
            $rawHeaders = fgetcsv($fh);
            fclose($fh);
        } else {
            //since we only allow csv and xlsx, here we handle xlsx
            $rows = (new HeadingRowImport)->toArray($fullPath);
            $rawHeaders = $rows[0][0] ?? [];
        }

        $headers = array_map(fn($h) => Str::slug($h, ''), $rawHeaders);

        $expected = array_keys($cfg['headers_to_db']);
        if($headers !== $expected) {
            return back()
                ->withErrors([
                    'file' => 'Invalid headers. Expected: '.implode(', ',$expected)
                ]);
        }

        ProcessImport::dispatch($data['type'], $relativePath, Auth::id());
        return back()->with('success', 'Import has been queued successfully!');
    }
}
