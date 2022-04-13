<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Center;
use App\City;
use App\Crop;
use App\Http\Requests;
use App\WebmasterBanner;
use App\WebmasterSection;
use File;
use Helper;
use Illuminate\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

class CentersController extends Controller
{
    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        $data_sections_arr = explode(',', Auth::user()->permissionsGroup->data_sections);
        if (! in_array(16, $data_sections_arr)) {
            Redirect::to(route('NoPermission'))->send();
            exit();
        }
        if (@Auth::user()->permissions_id == 3) {
            Redirect::to('/home')->send();
            exit();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $Centers = Center::paginate(env('BACKEND_PAGINATION'));

        return view('backEnd.centers', compact('Centers', 'GeneralWebmasterSections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = 'title_'.trans('backLang.boxCode');

        // Check Permissions
        if (! @Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $Cities = [''=>'اختر المدينة'];
        City::all()->each(function ($item) use ($name, &$Cities) {
            $Cities[$item->id] = $item->$name;
        });

        return view('backEnd.centers.create', compact('Cities', 'GeneralWebmasterSections'));
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
        if (! @Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $this->validate($request, [
            'title_ar' => 'sometimes|required',
            'title_en' => 'sometimes|required',
            'city' => 'required|exists:cities,id',
        ]);

        // End of Upload Files

        $Center = new Center();
        $Center->title_ar = $request->title_ar;
        $Center->title_en = $request->title_en;
        $Center->City()->associate($request->city);

        $Center->save();

        return redirect()->action('CentersController@index')->with('doneMessage', trans('backLang.addDone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $name = 'title_'.trans('backLang.boxCode');

        // Check Permissions
        if (! @Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $Cities = [''=>'اختر المدينة'];
        City::all()->each(function ($item) use ($name, &$Cities) {
            $Cities[$item->id] = $item->$name;
        });
        $Center = Center::find($id);
        if (! empty($Center)) {
            //Banner Sections Details

            return view('backEnd.centers.edit', compact('Center', 'Cities', 'GeneralWebmasterSections'));
        } else {
            return redirect()->action('CentersController@index');
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
        if (! @Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $Center = Center::find($id);
        if (! empty($Center)) {
            $this->validate($request, [
                'title_ar' => 'sometimes|required',
                'title_en' => 'sometimes|required',
                'city' => 'required|exists:cities,id',
            ]);

            $Center->title_ar = $request->title_ar;
            $Center->title_en = $request->title_en;
            $Center->City()->associate($request->city);
            $Center->save();

            return redirect()->action('CentersController@edit', $id)->with('doneMessage', trans('backLang.saveDone'));
        } else {
            return redirect()->action('CentersController@index');
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
        if (! @Auth::user()->permissionsGroup->delete_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $Center = Center::find($id);
        if (! empty($Center)) {
            $Center->delete();

            return redirect()->action('CentersController@index')->with('doneMessage', trans('backLang.deleteDone'));
        } else {
            return redirect()->action('CentersController@index');
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

        if ($request->ids != '') {
            if ($request->action == 'delete') {
                // Check Permissions
                if (! @Auth::user()->permissionsGroup->delete_status) {
                    return Redirect::to(route('NoPermission'))->send();
                }
                // Delete banners files

                Center::wherein('id', $request->ids)
                    ->delete();
            }
        }

        return redirect()->action('CentersController@index')->with('doneMessage', trans('backLang.saveDone'));
    }
}
