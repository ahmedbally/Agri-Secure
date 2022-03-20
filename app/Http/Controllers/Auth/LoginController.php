<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Setting;
use App\WebmasterSetting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,ThrottlesLogins;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
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
        return view('auth.login',compact("WebsiteSettings",
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

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
    }


}
