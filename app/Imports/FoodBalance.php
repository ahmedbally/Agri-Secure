<?php

namespace App\Imports;

use App\ReportFoodBalance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FoodBalance implements ToModel,WithStartRow
{
    /**
    * @param array $row
    */
    public function model(array $row)
    {
        if ($row[0] !=null)
        return new ReportFoodBalance([
            'year'=>$row[0],
            'group'=>$row[1],
            'crop'=>$row[2],
            'production'=>$row[3]??0,
            'imports'=>$row[4]??0,
            'stock_first'=>$row[5]??0,
            'stock_end'=>$row[6]??0,
            'exports'=>$row[7]??0,
            'available_consumption'=>$row[8]??0,
            'animal_food'=>$row[9]??0,
            'seed'=>$row[10]??0,
            'industry'=>$row[11]??0,
            'wastage'=>$row[12]??0,
            'human_food'=>$row[13]??0,
            'population'=>$row[14]??0,
            'pure_food'=>$row[15]??0,
            'human_year'=>$row[16]??0,
            'human_day'=>$row[17]??0,
            'human_cal'=>$row[18]??0,
            'human_protein'=>$row[19]??0,
            'human_fat'=>$row[20]??0
        ]);
        return  null;
    }

    public function startRow(): int
    {
        return 8;
    }
}
