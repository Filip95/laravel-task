<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Import;

class Audit extends Model
{
        protected $fillable = [
        'import_id',
        'table_name',
        'row_id',
        'column',
        'old_value',
        'new_value',
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
