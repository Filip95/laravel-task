<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GenericImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $rows
     */
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
