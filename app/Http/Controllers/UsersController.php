<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Permissions;
use App\User;
use App\WebmasterSection;
use Auth;
use Cog\Laravel\Optimus\Facades\Optimus;
use File;
use Illuminate\Config;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Redirect;
use Vanthao03596\LaravelPasswordHistory\Rules\NotInPasswordHistory;

class UsersController extends Controller
{

    private $uploadPath = "uploads/users/";

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');

        if (@Auth::user()->permissions_id != 1) {
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
    public function index()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        if (@Auth::user()->permissionsGroup->view_status) {
            $Users = User::where('created_by', '=', Auth::user()->id)->orwhere('id', '=', Auth::user()->id)->orderby('id',
                'asc')->paginate(env('BACKEND_PAGINATION'));
            $Permissions = Permissions::where('created_by', '=', Auth::user()->id)->orderby('id', 'asc')->get();
        } else {
            $Users = User::orderby('id', 'asc')->paginate(env('BACKEND_PAGINATION'));
            $Permissions = Permissions::orderby('id', 'asc')->get();
        }
        return view("backEnd.users", compact("Users", "Permissions", "GeneralWebmasterSections"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $Permissions = Permissions::orderby('id', 'asc')->get();

        return view("backEnd.users.create", compact("GeneralWebmasterSections", "Permissions"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'photo' => 'mimes:png,jpeg,jpg,gif|max:3000',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|numeric|unique:users',
            'password' => Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()->rules(['required']),
            'permissions_id' => 'required'
        ]);


        // Start of Upload Files
        $formFileName = "photo";
        $fileFinalName_ar = "";
        if ($request->$formFileName != "") {
            $fileFinalName_ar = time() . rand(1111,
                    9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
            $path = $this->getUploadPath();
            $request->file($formFileName)->move($path, $fileFinalName_ar);
        }
        // End of Upload Files

        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->mobile = $request->mobile;
        $User->password = bcrypt($request->password);
        $User->permissions_id = $request->permissions_id;
        $User->photo = $fileFinalName_ar;
        $User->connect_email = $request->connect_email;
        $User->connect_password = $request->connect_password;
        $User->status = 1;
        $User->created_by = Auth::user()->id;
        $User->save();

        return redirect()->action('UsersController@index')->with('doneMessage', trans('backLang.addDone'));
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Optimus::decode($id);
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $Permissions = Permissions::orderby('id', 'asc')->get();

        $Users = User::find($id);

        if (!empty($Users)) {
            return view("backEnd.users.edit", compact("Users", "Permissions", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('UsersController@index');
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
        $id = Optimus::decode($id);

        $User = User::find($id);

        if (!empty($User)) {
            $this->validate($request, [
                'photo' => 'mimes:png,jpeg,jpg,gif|max:3000',
                'name' => 'required',
                'permissions_id' => 'required'
            ]);

            if ($request->email != $User->email) {
                $this->validate($request, [
                    'email' => 'required|email|unique:users,email_address,' . $id,
                ]);
            }
            if ($request->mobile != $User->mobile) {
                $this->validate($request, [
                    'mobile' => 'required|numeric|unique:users,mobile,' . $id,
                ]);
            }
            // Start of Upload Files
            $formFileName = "photo";
            $fileFinalName_ar = "";
            if ($request->$formFileName != "") {
                $fileFinalName_ar = time() . rand(1111,
                        9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                $path = $this->getUploadPath();
                $request->file($formFileName)->move($path, $fileFinalName_ar);
            }
            // End of Upload Files

            //if ($id != 1) {
            $User->name = $request->name;
            $User->email = $request->email;
            $User->mobile = $request->mobile;
            if ($request->password != "") {
                $this->validate($request, [
                    'password' => Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()->rules(['required',new NotInPasswordHistory($User)]),
                ]);
                $User->password = bcrypt($request->password);
            }
            $User->permissions_id = $request->permissions_id;
            //}
            if ($request->photo_delete == 1) {
                // Delete a User file
                if ($User->photo != "") {
                    File::delete($this->getUploadPath() . $User->photo);
                }

                $User->photo = "";
            }
            if ($fileFinalName_ar != "") {
                // Delete a User file
                if ($User->photo != "") {
                    File::delete($this->getUploadPath() . $User->photo);
                }

                $User->photo = $fileFinalName_ar;
            }

            $User->connect_email = $request->connect_email;
            if ($request->connect_password != "") {
                $User->connect_password = $request->connect_password;
            }

            $User->status = $request->status;
            $User->updated_by = Auth::user()->id;
            $User->save();
            return redirect()->action('UsersController@edit', Optimus::encode($id))->with('doneMessage', trans('backLang.saveDone'));
        } else {
            return redirect()->action('UsersController@index');
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
        $id = Optimus::decode($id);

        if (@Auth::user()->permissionsGroup->view_status) {
            $User = User::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $User = User::find($id);
        }
        if (!empty($User)&& $id != 1) {
            // Delete a User photo
            if ($User->photo != "") {
                File::delete($this->getUploadPath() . $User->photo);
            }

            $User->delete();
            return redirect()->action('UsersController@index')->with('doneMessage', trans('backLang.deleteDone'));
        } else {
            return redirect()->action('UsersController@index');
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
        $request->merge([
            'ids' => is_array($request->ids)? array_map(function ($id){
                return Optimus::decode($id);
            },$request->ids) : []
        ]);
        if($request->ids != "") {
            if ($request->action == "activate") {
                User::wherein('id', $request->ids)
                    ->update(['status' => 1]);

            } elseif ($request->action == "block") {
                User::wherein('id', $request->ids)->where('id', '!=', 1)
                    ->update(['status' => 0]);

            } elseif ($request->action == "delete") {
                // Delete User photo
                $Users = User::wherein('id', $request->ids)->where('id', '!=', 1)->get();
                foreach ($Users as $User) {
                    if ($User->photo != "") {
                        File::delete($this->getUploadPath() . $User->photo);
                    }
                }

                User::wherein('id', $request->ids)->where('id', "!=", 1)
                    ->delete();

            }
        }
        return redirect()->action('UsersController@index')->with('doneMessage', trans('backLang.saveDone'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions_create()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        return view("backEnd.users.permissions.create", compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function permissions_store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required'
        ]);

        $data_sections_values = "";
        if (@$request->data_sections != "") {
            foreach ($request->data_sections as $key => $val) {
                $data_sections_values = $val . "," . $data_sections_values;
            }
            $data_sections_values = substr($data_sections_values, 0, -1);
        }

        $Permissions = new Permissions;
        $Permissions->name = $request->name;
        $Permissions->view_status = ($request->view_status) ? "1" : "0";
        $Permissions->add_status = ($request->add_status) ? "1" : "0";
        $Permissions->edit_status = ($request->edit_status) ? "1" : "0";
        $Permissions->delete_status = ($request->delete_status) ? "1" : "0";
        $Permissions->analytics_status = ($request->analytics_status) ? "1" : "0";
        $Permissions->inbox_status = ($request->inbox_status) ? "1" : "0";
        $Permissions->newsletter_status = ($request->newsletter_status) ? "1" : "0";
        $Permissions->calendar_status = ($request->calendar_status) ? "1" : "0";
        $Permissions->banners_status = ($request->banners_status) ? "1" : "0";
        $Permissions->settings_status = ($request->settings_status) ? "1" : "0";
        $Permissions->webmaster_status = ($request->webmaster_status) ? "1" : "0";
        $Permissions->data_sections = $data_sections_values;
        $Permissions->status = true;
        $Permissions->save();

        return redirect()->action('UsersController@index')->with('doneMessage', trans('backLang.addDone'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissions_edit($id)
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        if (@Auth::user()->permissionsGroup->view_status) {
            $Permissions = Permissions::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $Permissions = Permissions::find($id);
        }
        if (!empty($Permissions)) {
            return view("backEnd.users.permissions.edit", compact("Permissions", "GeneralWebmasterSections"));
        } else {
            return redirect()->action('UsersController@index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissions_update(Request $request, $id)
    {
        //
        $Permissions = Permissions::find($id);
        if (!empty($Permissions)) {


            $this->validate($request, [
                'name' => 'required'
            ]);

            $data_sections_values = "";
            if (@$request->data_sections != "") {
                foreach ($request->data_sections as $key => $val) {
                    $data_sections_values = $val . "," . $data_sections_values;
                }
                $data_sections_values = substr($data_sections_values, 0, -1);
            }

            $Permissions->name = $request->name;
            $Permissions->view_status = ($request->view_status) ? "1" : "0";
            $Permissions->add_status = ($request->add_status) ? "1" : "0";
            $Permissions->edit_status = ($request->edit_status) ? "1" : "0";
            $Permissions->delete_status = ($request->delete_status) ? "1" : "0";
            $Permissions->analytics_status = ($request->analytics_status) ? "1" : "0";
            $Permissions->inbox_status = ($request->inbox_status) ? "1" : "0";
            $Permissions->newsletter_status = ($request->newsletter_status) ? "1" : "0";
            $Permissions->calendar_status = ($request->calendar_status) ? "1" : "0";
            $Permissions->banners_status = ($request->banners_status) ? "1" : "0";
            $Permissions->settings_status = ($request->settings_status) ? "1" : "0";
            $Permissions->webmaster_status = ($request->webmaster_status) ? "1" : "0";
            $Permissions->data_sections = $data_sections_values;
            $Permissions->status = $request->status;
            if ($id != 1) {
                $Permissions->save();
            }
            return redirect()->action('UsersController@permissions_edit', $id)->with('doneMessage',
                trans('backLang.saveDone'));
        } else {
            return redirect()->action('UsersController@index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissions_destroy($id)
    {
        //
        if (@Auth::user()->permissionsGroup->view_status) {
            $Permissions = Permissions::where('created_by', '=', Auth::user()->id)->find($id);
        } else {
            $Permissions = Permissions::find($id);
        }
        if (!empty($Permissions) && $id != 1) {

            $Permissions->delete();
            return redirect()->action('UsersController@index')->with('doneMessage', trans('backLang.deleteDone'));
        } else {
            return redirect()->action('UsersController@index');
        }
    }


}
