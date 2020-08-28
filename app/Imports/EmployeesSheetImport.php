<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesSheetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        return new Employee([
            'name' => $row['nombre'],
            'employee_number' => $row['legajo'],
            'entry_date' => $row['fecha_de_entrada'],
            'vacations' => $row['vacaciones_correspondientes'],
            'scoring' => $row['scoring'],
        ]);
    }
}
