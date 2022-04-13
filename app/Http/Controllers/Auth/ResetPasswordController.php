<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Setting;
use App\WebmasterSetting;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);
        $WebmasterSection = 'none';
        $CurrentCategory = 'none';
        // General for all pages
        $WebsiteSettings = Setting::find(1);
        $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
        $FooterMenuLinks_name_ar = '';
        $FooterMenuLinks_name_en = '';
        if (! empty($FooterMenuLinks_father)) {
            $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
            $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
        }
        $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
        $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

        $PageTitle = ''; // will show default site Title
        $PageDescription = $WebsiteSettings->$site_desc_var;
        $PageKeywords = $WebsiteSettings->$site_keywords_var;

        $token = $request->route()->parameter('token');

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email] + compact('WebsiteSettings',
                'WebmasterSettings',
                'WebmasterSection',
                'CurrentCategory',
                'FooterMenuLinks_name_ar',
                'FooterMenuLinks_name_en',
                'PageTitle',
                'PageDescription',
                'PageKeywords',
                'PageDescription',
                'PageKeywords',
            )
        );
    }
}
