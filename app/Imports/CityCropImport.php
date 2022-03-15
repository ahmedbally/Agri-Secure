<?php

namespace App\Imports;

use App\City;
use App\Center;
use App\CityCrop;
use App\Crop;
use Illuminate\Console\OutputStyle;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CityCropImport implements ToModel,WithStartRow
{
    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        // dd('am here');
        if ($row[1] && $row[0] && $row[3] && $row[4] && $row[5]) {
            $season = '';
            if ($row[4] == 'شتوي' || $row[4] == 'الشتوى' || $row[4] == 'الشتوي' || $row[4] == 'شتوى')
                $season = 'الشتوى';
            elseif ($row[4] == 'صيفي' || $row[4] == 'الصيفى' || $row[4] == 'الصيفي' || $row[4] == 'صيفى')
                $season = 'الصيفى';
            elseif ($row[4] == 'نيلي' || $row[4] == 'النيلى' || $row[4] == 'النيلي' || $row[4] == 'نيلى')
                $season ='النيلى';
            else
                $season=$row[4];
            \DB::enableQueryLog();
            // sheft district after gov 
            // ALTER TABLE `crops` CHANGE `image` `image` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

            $crop = Crop::firstOrCreate(["title_ar" => "$row[3]"], ["title_ar" => $row[3], "color" => $this->rand_color()]);
            // dd(\DB::getQueryLog());
            // dd($crop);
            $city = City::firstOrCreate(["title_ar" => "$row[1]"], ["title_ar" => $row[1]]);
            $center = Center::firstOrCreate(["title_ar" => "$row[2]"], ["title_ar" => $row[2],"city_id"=>$city->id]);
            $CityCrop = new CityCrop;
            $CityCrop->Crop()->associate($crop);
            $CityCrop->City()->associate($city);
            $CityCrop->Center()->associate($center);
            $CityCrop->quantity = $row[7];
            $CityCrop->area = $row[6];
            $CityCrop->productivity = $row[5];
            $CityCrop->season = $season;
            $CityCrop->year = $row[0];
            // $CityCrop->save();

            return $CityCrop;

            /*return new CityCrop([
                'city_id'=>$city->id,
                'center_id'=>$center->id,
                'crop_id'=>$crop->id,
                'quantity'=>$row[7]??0,
                'area'=>$row[6]??0,
                'productivity'=>$row[5]??0,
                'season'=>$season,
                'year'=>$row[0]??0,
            ]);*/

        }else{
        // dd('am here');
            return  null;
        }
    }

    /**
     * @inheritDoc
     */
    public function startRow(): int
    {
        return 2;
    }
}
