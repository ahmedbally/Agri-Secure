<?php

namespace App\Http\Controllers;

use App\Permissions;
use App\WebmasterSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Password;
use Vanthao03596\LaravelPasswordHistory\Rules\NotInPasswordHistory;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $Permissions = Permissions::orderby('id', 'asc')->get();

        $Users = @Auth::user();
        return view("backEnd.users.edit", compact("Users", "Permissions", "GeneralWebmasterSections"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $User = Auth::user();

        $this->validate($request, [
            'photo' => 'mimes:png,jpeg,jpg,gif|max:3000',
            'name' => 'required',
        ]);

        if ($request->email != $User->email) {
            $this->validate($request, [
                'email' => 'required|email|unique:users,email_address,' . $User->id,
            ]);
        }
        if ($request->mobile != $User->mobile) {
            $this->validate($request, [
                'mobile' => 'required|numeric|unique:users,mobile,' . $User->id,
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

        $User->name = $request->name;
        $User->email = $request->email;
        $User->mobile = $request->mobile;
        if ($request->password != "") {
            $this->validate($request, [
                'password' => Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()->rules(['required',new NotInPasswordHistory($User)]),
            ]);
            $User->password = bcrypt($request->password);
        }
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
        $User->save();
        return redirect()->action('UserController@edit')->with('doneMessage', trans('backLang.saveDone'));
    }
}
