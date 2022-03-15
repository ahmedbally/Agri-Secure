<?php

namespace App\Imports;

use App\ReportHistoricalPrice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HistoricalPrice implements ToModel,WithStartRow
{
    public function __construct()
    {
        ReportHistoricalPrice::query()->truncate();
    }

    /**
    * @param array $row
    */
    public function model(array $row)
    {
        if ($row[0] !=null && $row[1]!=null && $row[2]!=null && $row[3] !=null) {
            if ($row[1] != null && in_array(trim($row[1]), ['عروة صيفية','عروة نيلية','عروة شتوية','عروة معمرة','']))
                if (in_array(trim($row[1]), ['عروة معمرة'])) $season = 4;
                elseif (in_array(trim($row[1]), ['عروة شتوية'])) $season = 1;
                elseif (in_array(trim($row[1]), ['عروة صيفية'])) $season = 2;
                elseif (in_array(trim($row[1]), ['عروة نيلية'])) $season = 3;
                else null;
            return new ReportHistoricalPrice([
                'season'=>$season,
                'crop'=>$row[2],
                'year'=>$row[0],
                'farm_price'=>round($row[3]??0),
                'trading_price'=>$row[4]??0,
                'total_price'=>0,
            ]);
        }



        return null;
    }
    public function startRow(): int
    {
        return 2;
    }

}
