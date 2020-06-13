<?php

namespace App\Imports;

use App\Novelty;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NoveltiesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Novelty([
            'code' => $row['codigo'],
            'description' => $row['descripcion'],
            'unit' => $row['unidad'],
        ]);
    }
}
