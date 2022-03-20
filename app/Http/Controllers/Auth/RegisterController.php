<?php

namespace App\Http\Controllers\Auth;

use App\Menu;
use App\Setting;
use App\User;
use App\Http\Controllers\Controller;
use App\WebmasterSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Redirect;
use Helper;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);
        $WebmasterSection = 'none';
        $CurrentCategory = 'none';
        // General for all pages
        $WebsiteSettings = Setting::find(1);
        $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
        $FooterMenuLinks_name_ar = "";
        $FooterMenuLinks_name_en = "";
        if (!empty($FooterMenuLinks_father)) {
            $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
            $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
        }
        $site_desc_var = "site_desc_" . trans('backLang.boxCode');
        $site_keywords_var = "site_keywords_" . trans('backLang.boxCode');

        $PageTitle = ""; // will show default site Title
        $PageDescription = $WebsiteSettings->$site_desc_var;
        $PageKeywords = $WebsiteSettings->$site_keywords_var;
        return view('auth.register',compact("WebsiteSettings",
            "WebmasterSettings",
            "WebmasterSection",
            "CurrentCategory",
            "FooterMenuLinks_name_ar",
            "FooterMenuLinks_name_en",
            "PageTitle",
            "PageDescription",
            "PageKeywords",
            "PageDescription",
            "PageKeywords",
        ));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'digits:11', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'status' => true,
            'permissions_id' => Helper::GeneralWebmasterSettings("permission_group"),    // Permission Group ID
        ]);
    }
}
