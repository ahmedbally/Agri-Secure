<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Center;
use App\City;
use App\CityCrop;
use App\Crop;
use App\Imports\CityCropImport;
use App\WebmasterBanner;
use App\WebmasterSection;
use Auth;
use CitiesCrops;
use File;
use Helper;
use Illuminate\Config;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;

class CitiesCropsController extends Controller
{

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
        if (!in_array(16, $data_sections_arr)) {
            Redirect::to(route('NoPermission'))->send();
            exit();
        }
        if(@Auth::user()->permissions_id == 3){
            Redirect::to('/home')->send();
            exit();
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = "title_" . trans('backLang.boxCode');

        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $Crops=[''=>'اختر المحصول'];
        Crop::all()->each(function ($item) use($name,&$Crops){
            $Crops[$item->id] = $item->$name;
        });
        $Cities=[''=>'اختر المدينة'];
        City::all()->each(function ($item) use($name,&$Cities){
            $Cities[$item->id] = $item->$name;
        });
        $years=[''=>'اختر السنة'];
        CityCrop::all()->groupBy('year')->map(function ($item){
           return $item->reduce(function ($carry,$item){
              return $carry+$item->quantity;
           });
        })->sortKeysDesc()->each(function ($item,$key) use (&$years){
            $years[$key]=$key.' ('.$item.' طن)';
        });
        if ($request->input('f')) {
            $CitiesCrops = CityCrop::where(array_filter($request->input('f'))??[])->paginate(env('BACKEND_PAGINATION'));
        }else{
            $CitiesCrops = CityCrop::paginate(env('BACKEND_PAGINATION'));

        }
        return view("backEnd.cities_crops", compact("CitiesCrops","Crops","Cities","years","GeneralWebmasterSections"));
    }

    public function upload(Request $request){
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        try{
            Validator::make($request->all(), [
                'file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc|max:3000'
            ])->validate();
            Excel::import(new CityCropImport(),$request->file('file'));
        }catch (\Exception $e) {
            return redirect()->action('CitiesCropsController@index');
        }
        return redirect()->action('CitiesCropsController@import')->with('doneMessage', trans('backLang.addDone'));

    }
    /**
     * Show the form for import resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $name = "title_" . trans('backLang.boxCode');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        return view("backEnd.cities_crops.import", compact("GeneralWebmasterSections"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = "title_" . trans('backLang.boxCode');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $Crops=[''=>'اختر المحصول'];
        Crop::all()->each(function ($item) use($name,&$Crops){
            $Crops[$item->id] = $item->$name;
        });
        $Cities=[''=>'اختر المدينة'];
        City::all()->each(function ($item) use($name,&$Cities){
            $Cities[$item->id] = $item->$name;
        });

        return view("backEnd.cities_crops.create", compact("Crops","Cities","GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $this->validate($request, [
            'crop' => 'required|exists:crops,id',
            'city' => 'required|exists:cities,id',
            'center' => 'required|exists:centers,id',
            'quantity' => 'required',
            'area' => 'required',
            'productivity' => 'required',
            'season' => 'required|in:الشتوي,الصيفي,النيلي,بدون',
            'year' => 'required',
        ]);

        // End of Upload Files

        $center=Center::find($request->center);
        $Crop = new CityCrop;
        $Crop->Crop()->associate($request->crop);
        $Crop->City()->associate($center->City);
        $Crop->Center()->associate($center);
        $Crop->quantity = $request->quantity;
        $Crop->area = $request->area;
        $Crop->productivity = $request->productivity;
        $Crop->season = $request->season;
        $Crop->year = $request->year;
        try {
            $Crop->save();
        }catch (\Exception $exception){
            return redirect()->action('CitiesCropsController@index');
        }
        return redirect()->action('CitiesCropsController@index')->with('doneMessage', trans('backLang.addDone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $name = "title_" . trans('backLang.boxCode');

        // Check Permissions
        if (!@Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END


        $Crop = CityCrop::find($id);
        $Crops=[''=>'اختر المحصول'];
        Crop::all()->each(function ($item) use($name,&$Crops){
            $Crops[$item->id] = $item->$name;
        });
        $Cities=[''=>'اختر المدينة'];
        City::all()->each(function ($item) use($name,&$Cities){
            $Cities[$item->id] = $item->$name;
        });
        $Centers=[''=>'اختر المركز'];
        Center::where('city_id',$Crop->City->id)->get()->each(function ($item) use($name,&$Centers){
            $Centers[$item->id] = $item->$name;
        });
        if (!empty($Crop)) {
            //Banner Sections Details

            return view("backEnd.cities_crops.edit", compact("Crop","Crops","Cities","Centers", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('CitiesCropsController@index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $Crop = CityCrop::find($id);
        if (!empty($Crop)) {


            $this->validate($request, [
                'crop' => 'required|exists:crops,id',
                'city' => 'required|exists:cities,id',
                'center' => 'required|exists:centers,id',
                'quantity' => 'required',
                'area' => 'required',
                'productivity' => 'required',
                'season' => 'required|in:الشتوي,الصيفي,النيلي,بدون',
                'year' => 'required',
            ]);
            $center=Center::find($request->center);

            $Crop->Crop()->associate($request->crop);
            $Crop->City()->associate($center->City);
            $Crop->Center()->associate($center);
            $Crop->quantity = $request->quantity;
            $Crop->area = $request->area;
            $Crop->productivity = $request->productivity;
            $Crop->season = $request->season;
            $Crop->year = $request->year;


            $Crop->save();
            return redirect()->action('CitiesCropsController@edit', $id)->with('doneMessage', trans('backLang.saveDone'));
        } else {
            return redirect()->action('CitiesCropsController@index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check Permissions
        if (!@Auth::user()->permissionsGroup->delete_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $Crop = CityCrop::find($id);
        if (!empty($Crop)) {

            $Crop->delete();
            return redirect()->action('CitiesCropsController@index')->with('doneMessage', trans('backLang.deleteDone'));
        } else {
            return redirect()->action('CitiesCropsController@index');
        }
    }


    /**
     * Update all selected resources in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  buttonNames , array $ids[]
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        //

            if ($request->ids != "") {
                if ($request->action == "delete") {
                    // Check Permissions
                    if (!@Auth::user()->permissionsGroup->delete_status) {
                        return Redirect::to(route('NoPermission'))->send();
                    }
                    // Delete banners files

                    Crop::wherein('id', $request->ids)
                        ->delete();

                }
            }

        return redirect()->action('CitiesCropsController@index')->with('doneMessage', trans('backLang.saveDone'));
    }


}
