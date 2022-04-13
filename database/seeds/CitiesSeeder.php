<?php

use App\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $newCity = new City();
        $newCity->code = 'AL';
        $newCity->title_ar = 'الإسكندرية';
        $newCity->title_en = 'Alexandria';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'AN';
        $newCity->title_ar = 'أسوان';
        $newCity->title_en = 'Aswan';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'AT';
        $newCity->title_ar = 'أسيوط';
        $newCity->title_en = 'Asyut';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'BH';
        $newCity->title_ar = 'البحيرة';
        $newCity->title_en = 'Beheira';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'BN';
        $newCity->title_ar = 'بني سويف';
        $newCity->title_en = 'Beni Suef';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'CA';
        $newCity->title_ar = 'القاهرة';
        $newCity->title_en = 'Cairo';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'DA';
        $newCity->title_ar = 'الدقهلية';
        $newCity->title_en = 'Dakahlia';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'DM';
        $newCity->title_ar = 'دمياط';
        $newCity->title_en = 'Damietta';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'FY';
        $newCity->title_ar = 'الفيوم';
        $newCity->title_en = 'Faiyum';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'GH';
        $newCity->title_ar = 'الغربية';
        $newCity->title_en = 'Gharbia';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'GZ';
        $newCity->title_ar = 'الجيزة';
        $newCity->title_en = 'Giza';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'IS';
        $newCity->title_ar = 'الإسماعيلية';
        $newCity->title_en = 'Ismailia';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'KS';
        $newCity->title_ar = 'كفر الشيخ';
        $newCity->title_en = 'Kafr el-Sheikh';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'MT';
        $newCity->title_ar = 'مطروح';
        $newCity->title_en = 'Matruh';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'MN';
        $newCity->title_ar = 'المنيا';
        $newCity->title_en = 'Minya';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'MF';
        $newCity->title_ar = 'المنوفية';
        $newCity->title_en = 'Monufia';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'NV';
        $newCity->title_ar = 'الوادي الجديد';
        $newCity->title_en = 'New Valley';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'NS';
        $newCity->title_ar = 'شمال سيناء';
        $newCity->title_en = 'North Sinai';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'PS';
        $newCity->title_ar = 'بورسعيد';
        $newCity->title_en = 'Port Said';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'QA';
        $newCity->title_ar = 'القليوبية';
        $newCity->title_en = 'Qalyubia';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'QE';
        $newCity->title_ar = 'قنا';
        $newCity->title_en = 'Qena';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'RS';
        $newCity->title_ar = 'البحر الاحمر';
        $newCity->title_en = 'Red Sea';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'SQ';
        $newCity->title_ar = 'الشرقية';
        $newCity->title_en = 'Sharqia';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'SH';
        $newCity->title_ar = 'سوهاج';
        $newCity->title_en = 'Sohag';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'SS';
        $newCity->title_ar = 'جنوب سيناء';
        $newCity->title_en = 'South Sinai';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'SZ';
        $newCity->title_ar = 'السويس';
        $newCity->title_en = 'Suez';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'LX';
        $newCity->title_ar = 'الأقصر';
        $newCity->title_en = 'Luxor';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'HW';
        $newCity->title_ar = 'حلوان';
        $newCity->title_en = 'Helwan';
        $newCity->save();

        $newCity = new City();
        $newCity->code = 'SO';
        $newCity->title_ar = '6 أكتوبر';
        $newCity->title_en = '6th of October';
        $newCity->save();
    }
}
