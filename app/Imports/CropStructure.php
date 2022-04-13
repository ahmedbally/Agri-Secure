<?php

namespace App\Imports;

use App\ReportCropStructure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class CropStructure implements ToModel, WithEvents, WithStartRow
{
    public $sheet;

    public $time;

    public function __construct()
    {
        $this->time = now();
    }

    /**
     * @param array $row
     */
    public function model(array $row)
    {
//        $row=array_values($row);
        $year = (int) $this->sheet;
        // dd($row[0]);
        if ($row[0] != null && $row[1] != null && $row[2] != null && $row[4] != null && $row[5] != null && $row[10] != null && $row[11] != null && $row[13] != null && $row[14] != null && ! in_array(trim($row[0]), ['جملة الوجه البحري', 'جملة الوجه البحرى', 'جملة مصر الوسطي', 'جملة مصر الوسطى', 'جملة مصر العليا', 'إجمالى داخل الوادى', 'إجمالى خارج الوادى', 'الإجمالى', 'الإجمـالى'])) {
            return new ReportCropStructure([
                'gov'=>$row[0],
                'winter_old'=>$row[1] ?? 0,
                'winter_new'=>$row[2] ?? 0,
                'perennial_old'=>$row[4] ?? 0,
                'perennial_new'=>$row[5] ?? 0,
                'summer_old'=>$row[10] ?? 0,
                'summer_new'=>$row[11] ?? 0,
                'indigo_old'=>$row[13] ?? 0,
                'indigo_new'=>$row[14] ?? 0,
                'year'=>$year,
            ]);
        }

        return null;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheet = $event->getSheet()->getTitle();
            },
            AfterSheet::class => function (AfterSheet $event) {
                ReportCropStructure::where(
                    [
                        'year'=>$this->sheet,
                    ]
                )->where('created_at', '<', $this->time)->delete();
            },
        ];
    }

    public function startRow(): int
    {
        return 3;
    }
}
