<?php

namespace App\Imports;

use App\ReportInternationalPrice;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InternationalPrice implements ToModel, WithStartRow
{
    public function __construct()
    {
        ReportInternationalPrice::query()->truncate();
    }

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        if (! $row[0]) {
            return;
        }

        return new ReportInternationalPrice([
            'crop'=>$row[0],
            'unit'=>$row[1],
            'close_cent'=>$row[2],
            'close_dollar'=>$row[3],
            'close_pound'=>$row[4],
            'lower_cent'=>$row[5],
            'lower_dollar'=>$row[6],
            'lower_pound'=>$row[7],
            'higher_cent'=>$row[8],
            'higher_dollar'=>$row[9],
            'higher_pound'=>$row[10],
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}
