<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //Todo for later: validate if headers inside uploaded file match $cfg[headers_to_db] and dispatch the job
        $cfg = config("imports.{$data['type']}");
        return back()->with('success', 'Import has been queued successfully!');
    }
}
