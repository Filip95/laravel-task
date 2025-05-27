<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Import;

class ImportError extends Model
{
    protected $guarded = [];
//    protected $fillable = [
//        'import_id',
//        'row_number',
//        'column',
//        'value',
//        'message',
//    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
