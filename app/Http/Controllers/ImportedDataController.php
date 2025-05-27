<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class ImportedDataController extends Controller
{
    /**
     * Show a paginated table of the imported data for a given type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                   $type
     */
    public function index(Request $request, string $type)
    {
        $configs = Config::get('imports');
        abort_unless(array_key_exists($type, $configs), 404);

        $cfg = $configs[$type];

        $map = [
            'orders'    => \App\Models\Order::class,
            'customers' => \App\Models\Customer::class,
            'invoices'  => \App\Models\Invoice::class,
        ];
        $model = $map[$type];

        $items = $model::orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->only('page'));


        return view('imported.index', [
            'items' => $items,
            'cfg'   => $cfg,
            'type'  => $type,
        ]);
    }
}
