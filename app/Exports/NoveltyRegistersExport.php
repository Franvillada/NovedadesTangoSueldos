<?php

namespace App\Exports;

use App\NoveltyRegister;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class NoveltyRegistersExport implements FromQuery, WithHeadings, WithColumnFormatting, WithMapping, ShouldAutoSize,WithEvents
{
    
    use Exportable;

    public function __construct(int $year, int $month, int $client_id)
    {
        $this->year = $year;
        $this->month = $month;
        $this->client_id = $client_id;
    }

    public function headings(): array{
        return[
            'Legajo',
            'Novedad',
            'Fecha',
            'Cantidad',
            'Valor'
        ];
    }

    public function map($registro):array
    {
        return[
            $registro->employee_number,
            $registro->code,
            Date::dateTimeToExcel($registro->date),
            $registro->quantity,
        ];
    }

    public function columnFormats():array
    {
        return[
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function registerEvents(): array{
        return[
            AfterSheet::class => function(AfterSheet $event){
                $index = (int)$event->sheet->getHighestRow() -1;
                for ($i=0; $i < $index; $i++) { 
                    $event->sheet->setCellValue('E'. ($i+2),0);   
                }
            }
        ];
    }

    public function query()
    {
        return NoveltyRegister::query() ->join('employees','novelty_registers.employee_id','=','employees.id')
                                        ->join('novelties','novelty_registers.novelty_id','=','novelties.id')
                                        ->where('employees.client_id','=',$this->client_id)
                                        ->whereYear('date',$this->year)
                                        ->whereMonth('date',$this->month)
                                        ->select('employees.employee_number','novelties.code','novelty_registers.date','novelty_registers.quantity');
    }
}
