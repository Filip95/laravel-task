<?php

namespace App\Http\Controllers;

use App\Models\Import;
use Illuminate\Http\Request;

class ImportLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imports = Import::with('user')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('imports.log', compact('imports'));
    }

    /**
     * Show validation errors for a specific import.
     */
    public function errors(Import $import)
    {
        $errors = $import->errors()
            ->orderBy('row_number')
            ->paginate(20);

        return view('imports.errors', compact('import', 'errors'));
    }

}
