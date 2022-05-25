<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Crop;
use App\Http\Requests;
use App\WebmasterBanner;
use App\WebmasterSection;
use Auth;
use File;
use Helper;
use Illuminate\Config;
use Illuminate\Http\Request;
use Redirect;

class CropsController extends Controller
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

        $Crops = Crop::paginate(env('BACKEND_PAGINATION'));

        return view('backEnd.crops', compact('Crops', 'GeneralWebmasterSections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Permissions
        if (! @Auth::user()->permissionsGroup->add_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        return view('backEnd.crops.create', compact('GeneralWebmasterSections'));
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
            'color' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg,gif,svg|max:3000|clamav|secure-file',

        ]);

        $formFileName = 'image';
        if ($request->$formFileName != '') {
            $fileFinalName = time().rand(1111,
                    9999).'.'.$request->file($formFileName)->guessExtension();
            $path = 'uploads/crops/';
            $request->file($formFileName)->move($path, $fileFinalName);
        }
        // End of Upload Files

        $Crop = new Crop;
        $Crop->title_ar = $request->title_ar;
        $Crop->title_en = $request->title_en;
        $Crop->color = $request->color;
        $Crop->quantity = $request->quantity;
        $Crop->area = $request->area;
        $Crop->image = $fileFinalName;
        $Crop->save();

        return redirect()->action('CropsController@index')->with('doneMessage', trans('backLang.addDone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Permissions
        if (! @Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $Crop = Crop::find($id);
        if (! empty($Crop)) {
            //Banner Sections Details

            return view('backEnd.crops.edit', compact('Crop', 'GeneralWebmasterSections'));
        } else {
            return redirect()->action('CropsController@index');
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
        if (! @Auth::user()->permissionsGroup->edit_status) {
            return Redirect::to(route('NoPermission'))->send();
        }
        //
        $Crop = Crop::find($id);
        if (! empty($Crop)) {
            $this->validate($request, [
                'title_ar' => 'sometimes|required',
                'title_en' => 'sometimes|required',
                'color' => 'required',
                'image' => 'mimes:png,jpeg,jpg,gif,svg|max:3000|clamav|secure-file',

            ]);

            $formFileName = 'image';
            if ($request->$formFileName != '') {
                $fileFinalName = time().rand(1111,
                        9999).'.'.$request->file($formFileName)->guessExtension();
                $path = 'uploads/crops/';
                $request->file($formFileName)->move($path, $fileFinalName);
            }
            $Crop->title_ar = $request->title_ar;
            $Crop->title_en = $request->title_en;
            $Crop->color = $request->color;
            $Crop->quantity = $request->quantity;
            $Crop->area = $request->area;
            if (isset($fileFinalName)) {
                $Crop->image = $fileFinalName;
            }

            $Crop->save();

            return redirect()->action('CropsController@edit', $id)->with('doneMessage', trans('backLang.saveDone'));
        } else {
            return redirect()->action('CropsController@index');
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
        $Crop = Crop::find($id);
        if (! empty($Crop)) {
            $Crop->delete();

            return redirect()->action('CropsController@index')->with('doneMessage', trans('backLang.deleteDone'));
        } else {
            return redirect()->action('CropsController@index');
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

                Crop::wherein('id', $request->ids)
                        ->delete();
            }
        }

        return redirect()->action('CropsController@index')->with('doneMessage', trans('backLang.saveDone'));
    }
}
