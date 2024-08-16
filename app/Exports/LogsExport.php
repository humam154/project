<?php

namespace App\Exports;

use App\Models\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LogsExport implements  FromQuery, shouldAutoSize, withMapping, withHeadings, withEvents
{
    use Exportable;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Log::query();
    }

    public function map($row): array
    {
        return [
            $row->employee_id,
            $row->full_name,
            $row->email,
            $row->phone,
            $row->salary,
            $row->grade,
            $row->number_of_complains,
            $row->incentives
        ];
    }

    public function headings(): array
    {
        return [
            'employee_id',
            'full_name',
            'email',
            'phone',
            'salary',
            'grade',
            'number_of_complains',
            'incentives'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ],
                ]);
            }
        ];
    }
}
