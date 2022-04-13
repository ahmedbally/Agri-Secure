<?php

namespace App\Imports;

use App\ReportDailyPrice;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterSheet;

class DailyPrice implements ToModel, WithStartRow, WithCalculatedFormulas, WithEvents
{
    public $time;

    public function __construct()
    {
        $this->time = now();
    }

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        echo $row[3];
        if ($row[0] != null && $row[1] != null && $row[2] != null && $row[3] != null && $row[4] != null && $row[5] != null && $row[6] != null && $row[7] != null && $row[8] != null && $row[9] != null) {
            return new ReportDailyPrice([
                'group'=>$row[0],
                'crop'=>$row[1],
                'unit'=>$row[2],
                'date'=>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])->format('Y-m-d'),
                'wholesale_lower'=>$row[4],
                'wholesale_higher'=>$row[5],
                'wholesale_average'=>$row[6],
                'retail_lower'=>$row[7],
                'retail_higher'=>$row[8],
                'retail_average'=>$row[9],
            ]);
        }

        return null;
    }

    public function startRow(): int
    {
        return 3;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                ReportDailyPrice::where('created_at', '<', $this->time)->delete();
            },
        ];
    }
}
