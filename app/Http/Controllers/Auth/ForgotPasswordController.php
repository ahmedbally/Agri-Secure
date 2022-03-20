<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Setting;
use App\WebmasterSetting;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
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
        return view('auth.passwords.email',compact("WebsiteSettings",
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
}
