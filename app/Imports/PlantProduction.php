<?php

namespace App\Imports;

use App\ReportPlant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class PlantProduction implements ToModel, WithEvents, WithStartRow
{
    public $sheet;

    public $group;

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
        $row = array_values($row);
        $year = (int) $this->sheet;
        if ($row[0] != null && $row[1] != null && $row[2] != null && $row[3] != null && ! in_array(trim($row[3]), ['جملة الوجه البحري', 'جملة الوجه البحرى', 'جملة مصر الوسطي', 'جملة مصر الوسطى', 'جملة مصر العليا', 'إجمالى داخل الوادى', 'إجمالى خارج الوادى', 'الإجمالى', 'الإجمـالى'])) {
            if ($row[0] != null && in_array(trim($row[0]), ['الفاكهة', 'فاكهة', 'الخضر', 'خضر', 'محاصيل', 'المحاصيل', 'طبية وعطرية', 'طبي وعطري', 'الحقلية (بصل وثوم)', 'الحقلية (أعلاف)', 'الحقلية (بقوليات)', 'الحقلية (ألياف)', 'المحاصيل الزيتية', 'النخيل', 'الحقلية (حبوب)', 'الحقلية (م. زيتية)', 'الحقلية (م. سكرية)'])) {
                if (in_array(trim($row[0]), ['المحاصيل', 'محاصيل', 'الحقلية (حبوب)'])) {
                    $group = 1;
                } elseif (in_array(trim($row[0]), ['الخضر', 'خضر'])) {
                    $group = 2;
                } elseif (in_array(trim($row[0]), ['طبية وعطرية', 'طبي وعطري'])) {
                    $group = 3;
                } elseif (in_array(trim($row[0]), ['الفاكهة', 'فاكهة'])) {
                    $group = 4;
                } elseif (in_array(trim($row[0]), ['الحقلية (بصل وثوم)'])) {
                    $group = 5;
                } elseif (in_array(trim($row[0]), ['الحقلية (أعلاف)'])) {
                    $group = 6;
                } elseif (in_array(trim($row[0]), ['الحقلية (بقوليات)'])) {
                    $group = 7;
                } elseif (in_array(trim($row[0]), ['الحقلية (ألياف)'])) {
                    $group = 8;
                } elseif (in_array(trim($row[0]), ['المحاصيل الزيتية', 'الحقلية (م. زيتية)'])) {
                    $group = 9;
                } elseif (in_array(trim($row[0]), ['النخيل'])) {
                    $group = 10;
                } elseif (in_array(trim($row[0]), ['الحقلية (م. سكرية)'])) {
                    $group = 11;
                } else {
                    null;
                }
            }
            if ($row[1] != null && in_array(trim($row[1]), ['معمرات', 'الشتوية', 'الشتوي', 'شتوي', 'شتوى', 'صيفي', 'صيفية', 'الصيفي', 'نيلي', 'نيلية', 'النيلي', 'طبية وعطرية'])) {
                if (in_array(trim($row[1]), ['معمرات'])) {
                    $season = 4;
                } elseif (in_array(trim($row[1]), ['الشتوية', 'شتوي', 'الشتوي', 'شتوى'])) {
                    $season = 1;
                } elseif (in_array(trim($row[1]), ['صيفي', 'الصيفي', 'صيفية'])) {
                    $season = 2;
                } elseif (in_array(trim($row[1]), ['نيلي', 'النيلي', 'نيلية'])) {
                    $season = 3;
                } else {
                    null;
                }
            }
            $this->group = $group;

            return new ReportPlant([
                'group'=>$group,
                'season'=>$season,
                'crop'=>$row[2],
                'gov'=>$row[3],
                'old_area'=>$row[4] ?? 0,
                'old_quantity'=>$row[6] ?? 0,
                'new_area'=>$row[7] ?? 0,
                'new_quantity'=>$row[9] ?? 0,
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
                ReportPlant::where(
                    [
                        'group'=>$this->group,
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
