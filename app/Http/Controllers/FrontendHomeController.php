<?php

namespace App\Http\Controllers;

use App;
use App\Banner;
use App\Comment;
use App\Contact;
use App\Http\Requests;
use App\Menu;
use App\Poll;
use App\Section;
use App\Setting;
use App\Topic;
use App\TopicCategory;
use App\User;
use App\Webmail;
use App\WebmasterSection;
use App\WebmasterSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mail;

class FrontendHomeController extends Controller
{
    public function __construct()
    {
        // Set Language depending on Dashboard Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        if (! $WebmasterSettings->languages_ar_status && $WebmasterSettings->languages_en_status) {
            // Set As English if arabic is disabled
            App::setLocale('en');
        }
        if (! $WebmasterSettings->languages_en_status && $WebmasterSettings->languages_ar_status) {
            // Set As Arabic if English is disabled
            App::setLocale('ar');
        }

        // Check the website Status
        $WebsiteSettings = Setting::find(1);

        $lang = trans('backLang.boxCode');
        $site_status = $WebsiteSettings->site_status;
        $site_msg = $WebsiteSettings->close_msg;
        if ($site_status == 0) {
            // close the website
            if ($lang == 'ar') {
                $site_title = $WebsiteSettings->site_title_ar;
                $site_desc = $WebsiteSettings->site_desc_ar;
                $site_keywords = $WebsiteSettings->site_keywords_ar;
            } else {
                $site_title = $WebsiteSettings->site_title_en;
                $site_desc = $WebsiteSettings->site_desc_en;
                $site_keywords = $WebsiteSettings->site_keywords_en;
            }
            echo "<!DOCTYPE html>
            <html lang=\"en\">
            <head>
            <meta charset=\"utf-8\">
            <title>$site_title</title>
            <meta name=\"description\" content=\"$site_desc\"/>
            <meta name=\"keywords\" content=\"$site_keywords\"/>
            <body>
            <br>
            <div style='text-align: center;'>
            <p>$site_msg</p>
            </div>
            </body>
            </html>
            ";
            exit();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int /string $seo_url_slug
     * @return \Illuminate\Http\Response
     */
    public function SEO($seo_url_slug = 0)
    {
        return $this->SEOByLang('', $seo_url_slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int /string $seo_url_slug
     * @return \Illuminate\Http\Response
     */
    public function SEOByLang($lang = '', $seo_url_slug = 0)
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
        $seo_url_slug = str_slug($seo_url_slug, '-');

        switch ($seo_url_slug) {
            case 'home':
                return $this->HomePage();
                break;
            case 'about':
                $id = 1;
                $section = 1;

                return $this->topic($section, $id);
                break;
            case 'privacy':
                $id = 3;
                $section = 1;

                return $this->topic($section, $id);
                break;
            case 'terms':
                $id = 4;
                $section = 1;

                return $this->topic($section, $id);
                break;
            case 'databases':
                return $this->topics($seo_url_slug);
                break;
        }
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);
        $URL_Title = 'seo_url_slug_'.trans('backLang.boxCode');

        $WebmasterSection1 = WebmasterSection::where('seo_url_slug_ar', $seo_url_slug)->orwhere('seo_url_slug_en', $seo_url_slug)->first();
        if (! empty($WebmasterSection1)) {
            // MAIN SITE SECTION
            $section = $WebmasterSection1->id;

            return $this->topics($section, 0);
        } else {
            $WebmasterSection2 = WebmasterSection::where('name', $seo_url_slug)->first();
            if (! empty($WebmasterSection2)) {
                // MAIN SITE SECTION
                $section = $WebmasterSection2->id;

                return $this->topics($section, 0);
            } else {
                $Section = Section::where('status', 1)->where('seo_url_slug_ar', $seo_url_slug)->orwhere('seo_url_slug_en', $seo_url_slug)->first();
                if (! empty($Section)) {
                    // SITE Category
                    $section = $Section->webmaster_id;
                    $cat = $Section->id;

                    return $this->topics($section, $cat);
                } else {
                    $Topic = Topic::where('status', 1)->where('seo_url_slug_ar', $seo_url_slug)->orwhere('seo_url_slug_en', $seo_url_slug)->first();
                    if (! empty($Topic)) {
                        // SITE Topic
                        $section_id = $Topic->webmaster_id;
                        $WebmasterSection = WebmasterSection::find($section_id);
                        $section = $WebmasterSection->name;
                        $id = $Topic->id;

                        return $this->topic($section, $id);
                    } else {
                        // Not found
                        return redirect()->route('HomePage');
                    }
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function HomePage()
    {
        return $this->HomePageByLang('');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function HomePageByLang($lang = '')
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        // General for all pages
        $WebsiteSettings = Setting::find(1);
        $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
        $FooterMenuLinks_name_ar = '';
        $FooterMenuLinks_name_en = '';
        if (! empty($FooterMenuLinks_father)) {
            $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
            $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
        }
        // Get Latest Video
        $LatestVideo = Topic::where([['status', 1], ['webmaster_id', 5]])->orderby('created_by', 'desc')->first();
        $LatestEvent = Topic::where([['status', 1], ['webmaster_id', 11]])->orderby('created_by', 'desc')->first();

        // print_r($LatestVideo['video_type']);die();
        // Home topics
        //$HomeTopics = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->home_content1_section_id], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->home_content1_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(3)->get();
        $bossSpeach = Topic::find(50);
        // print_r($HomeTopics);die();
        // Home photos
        // $HomePhotos = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->home_content2_section_id], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->home_content2_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(6)->get();
        // Home Partners
        // $HomePartners = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->home_content3_section_id], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->home_content3_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->get();

        // Get Latest News
        $LatestNews = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(6)->get();

        // Get Latest Projects
        $LatestProjects = Topic::where([['status', 1], ['webmaster_id', 10], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', 10], ['expire_date', null]])->orderby('row_no', 'asc')->limit(5)->get();

        // Get Latest Projects
        $sites = Topic::where([['status', 1], ['webmaster_id', 13]])->orderby('row_no', 'asc')->limit(5)->get();
        // print_r($sites); die();
        // Get Latest Library
        $LatestLibrary = Section::where([['status', 1], ['webmaster_id', 12], ['father_id', 0]])->orderby('row_no', 'asc')->limit(5)->get();

        // $Library['Brochures'] = Section::find(23)->topics()->where([['status', 1], ['webmaster_id', 12], ['expire_date', '>=', date("Y-m-d")], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', 12], ['expire_date', null]])->orderby('row_no', 'asc')->limit(2)->get();

        // print_r($LatestLibrary); die();
        // Get Home page slider banners
        $SliderBanners = Banner::where('section_id', $WebmasterSettings->home_banners_section_id)->where('status',
            1)->orderby('row_no', 'asc')->get();

        // Get Home page Test banners
        $TextBanners = Banner::where('section_id', $WebmasterSettings->home_text_banners_section_id)->where('status',
            1)->orderby('row_no', 'asc')->get();
        $Sections = Section::where('webmaster_id', '=', 14)->where('father_id', '=',
            '0')->orderby('row_no',
            'asc')->get();

        $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
        $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

        $PageTitle = ''; // will show default site Title
        $PageDescription = $WebsiteSettings->$site_desc_var;
        $PageKeywords = $WebsiteSettings->$site_keywords_var;

        \Helper::CustomVisits('home');

        return view('frontEnd.home',
            compact('WebsiteSettings',
                'WebmasterSettings',
                'SliderBanners',
                'TextBanners',
                'FooterMenuLinks_name_ar',
                'FooterMenuLinks_name_en',
                'PageTitle',
                'PageDescription',
                'PageKeywords',
                'PageTitle',
                'PageDescription',
                'PageKeywords',
                'bossSpeach',
                'LatestProjects',
                'sites',
                'LatestEvent',
                'LatestVideo',
                'LatestLibrary',
                'Sections',
                'LatestNews'));
    }

    public function polls($lang = '')
    {
        // print_r('expression');die();
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
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
        $polls = Poll::all();

        $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
        $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

        $PageTitle = ''; // will show default site Title
        $PageDescription = $WebsiteSettings->$site_desc_var;
        $PageKeywords = $WebsiteSettings->$site_keywords_var;

        return view('frontEnd.poll.index',
            compact('WebsiteSettings',
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
                'polls'
            )
        );
    }

    public function poll($id, $lang = '')
    {
        // print_r('expression');die();
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
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
        $polls = Poll::find($id);

        $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
        $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

        $PageTitle = ''; // will show default site Title
        $PageDescription = $WebsiteSettings->$site_desc_var;
        $PageKeywords = $WebsiteSettings->$site_keywords_var;

        return view('frontEnd.poll.poll',
            compact('WebsiteSettings',
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
                'polls'
            )
        );
    }

    public function organize($lang = '')
    {
        // print_r('expression');die();
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);
        $WebmasterSection = WebmasterSection::find(14);
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
        $Sections = Section::where('webmaster_id', '=', 14)->where('father_id', '=',
            '0')->orderby('row_no',
            'asc')->get();

        $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
        $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

        $PageTitle = ''; // will show default site Title
        $PageDescription = $WebsiteSettings->$site_desc_var;
        $PageKeywords = $WebsiteSettings->$site_keywords_var;

        return view('frontEnd.organize',
            compact('WebsiteSettings',
                'WebmasterSection',
                'CurrentCategory',
                'WebmasterSettings',
                'FooterMenuLinks_name_ar',
                'FooterMenuLinks_name_en',
                'PageTitle',
                'PageDescription',
                'PageKeywords',
                'PageDescription',
                'PageKeywords',
                'Sections'
            )
        );
    }

    public function organizeByLang($id = 0, $lang = '')
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);
        $CurrentCategory = 'none';
        // check for pages called by name not id

        // get Webmaster section settings by name
        $WebmasterSection = WebmasterSection::find(14);
        if (! empty($WebmasterSection)) {
            // count topics by Category
            $category_and_topics_count = [];
            $Childs = Section::where('webmaster_id', '=', 14)->where('father_id', $id)->where('status', 1)->orderby('row_no', 'asc')->get();
            $Topic = Section::find($id);
            // print_r($Topic);die();

            if (! empty($Topic)) {
                $CurrentCategory = $Topic;

                // update visits
                $Topic->visits = $Topic->visits + 1;
                $Topic->save();

                // General for all pages

                $WebsiteSettings = Setting::find(1);
                $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
                $FooterMenuLinks_name_ar = '';
                $FooterMenuLinks_name_en = '';
                if (! empty($FooterMenuLinks_father)) {
                    $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                    $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
                }

                // Page Title, Description, Keywords
                $seo_title_var = 'seo_title_'.trans('backLang.boxCode');
                $seo_description_var = 'seo_description_'.trans('backLang.boxCode');
                $seo_keywords_var = 'seo_keywords_'.trans('backLang.boxCode');
                $tpc_title_var = 'title_'.trans('backLang.boxCode');
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');
                if ($Topic->$seo_title_var != '') {
                    $PageTitle = $Topic->$seo_title_var;
                } else {
                    $PageTitle = $Topic->$tpc_title_var;
                }
                if ($Topic->$seo_description_var != '') {
                    $PageDescription = $Topic->$seo_description_var;
                } else {
                    $PageDescription = $WebsiteSettings->$site_desc_var;
                }
                if ($Topic->$seo_keywords_var != '') {
                    $PageKeywords = $Topic->$seo_keywords_var;
                } else {
                    $PageKeywords = $WebsiteSettings->$site_keywords_var;
                }
                // .. end of .. Page Title, Description, Keywords
                return view('frontEnd.inner.organizesecond',
                    compact('WebsiteSettings',
                        'WebmasterSettings',
                        'FooterMenuLinks_name_ar',
                        'FooterMenuLinks_name_en',
                        'Topic',
                        'Childs',
                        'CurrentCategory',
                        'WebmasterSection',
                        'PageTitle',
                        'PageDescription',
                        'PageKeywords',
                        'category_and_topics_count'));
            } else {
                return redirect()->action('FrontendHomeController@HomePage');
            }
        } else {
            return redirect()->action('FrontendHomeController@HomePage');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $section
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function topic($section = 0, $id = 0)
    {
        return $this->topicByLang('', $section, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $section
     * @param  int $cat
     * @return \Illuminate\Http\Response
     */
    public function topicsByLang($lang = '', $section = 0, $cat = 0)
    {
        if ($section == 'databases') {
            return $this->databases($cat);
        }
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        // get Webmaster section settings by name
        $WebmasterSection = WebmasterSection::where('name', $section)->first();
        if (empty($WebmasterSection)) {
            // get Webmaster section settings by ID
            $WebmasterSection = WebmasterSection::find($section);
        }
        if (! empty($WebmasterSection)) {

            // count topics by Category
            $category_and_topics_count = [];
            $AllSections = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('status', 1)->orderby('row_no', 'asc')->get();
            if (count($AllSections) > 0) {
                foreach ($AllSections as $AllSection) {
                    $category_topics = [];
                    $TopicCategories = TopicCategory::where('section_id', $AllSection->id)->get();
                    foreach ($TopicCategories as $category) {
                        $category_topics[] = $category->topic_id;
                    }

                    $Topics = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->get();
                    $category_and_topics_count[$AllSection->id] = count($Topics);
                }
            }

            // Get current Category Section details
            $CurrentCategory = Section::find($cat);
            // Get a list of all Category ( for side bar )
            $Categories = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('father_id', '=',
                '0')->where('status', 1)->orderby('row_no', 'asc')->get();

            if (! empty($CurrentCategory)) {
                $category_topics = [];
                $TopicCategories = TopicCategory::where('section_id', $cat)->get();
                foreach ($TopicCategories as $category) {
                    $category_topics[] = $category->topic_id;
                }
                // update visits
                $CurrentCategory->visits = $CurrentCategory->visits + 1;
                $CurrentCategory->save();
                // Topics by Cat_ID
                $Topics = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->paginate(env('FRONTEND_PAGINATION'));
                // Get Most Viewed Topics fot this Category
                $TopicsMostViewed = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('visits', 'desc')->limit(3)->get();
            } else {
                // Topics if NO Cat_ID
                $Topics = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status',
                    1, ], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->orderby('row_no', 'asc')->paginate(env('FRONTEND_PAGINATION'));
                // Get Most Viewed
                $TopicsMostViewed = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status',
                    1, ], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->orderby('visits', 'desc')->limit(3)->get();
            }

            // General for all pages

            $WebsiteSettings = Setting::find(1);
            $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
            $FooterMenuLinks_name_ar = '';
            $FooterMenuLinks_name_en = '';
            if (! empty($FooterMenuLinks_father)) {
                $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
            }
            $SideBanners = Banner::where('section_id', $WebmasterSettings->side_banners_section_id)->where('status',
                1)->orderby('row_no', 'asc')->get();

            // Get Latest News
            $LatestNews = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(3)->get();

            // Page Title, Description, Keywords
            if (! empty($CurrentCategory)) {
                $seo_title_var = 'seo_title_'.trans('backLang.boxCode');
                $seo_description_var = 'seo_description_'.trans('backLang.boxCode');
                $seo_keywords_var = 'seo_keywords_'.trans('backLang.boxCode');
                $tpc_title_var = 'title_'.trans('backLang.boxCode');
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');
                if ($CurrentCategory->$seo_title_var != '') {
                    $PageTitle = $CurrentCategory->$seo_title_var;
                } else {
                    $PageTitle = $CurrentCategory->$tpc_title_var;
                }
                if ($CurrentCategory->$seo_description_var != '') {
                    $PageDescription = $CurrentCategory->$seo_description_var;
                } else {
                    $PageDescription = $WebsiteSettings->$site_desc_var;
                }
                if ($CurrentCategory->$seo_keywords_var != '') {
                    $PageKeywords = $CurrentCategory->$seo_keywords_var;
                } else {
                    $PageKeywords = $WebsiteSettings->$site_keywords_var;
                }
            } else {
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

                $PageTitle = trans('backLang.'.$WebmasterSection->name);
                $PageDescription = $WebsiteSettings->$site_desc_var;
                $PageKeywords = $WebsiteSettings->$site_keywords_var;
            }
            // .. end of .. Page Title, Description, Keywords
            $blade = 'topics';
            switch ($section) {
                case 'sites':
                    $blade = 'sites';
                    break;
                case 'news':
                    $blade = 'news';
                    break;
                case 'photos':
                    $blade = 'photos';
                    break;
                case 'videos':
                    $blade = 'videos';
                    break;
                case 'events':
                    $blade = 'events';
                    break;
                case 'library':
                    $blade = 'library';
                    break;
                case 'agri-counter':
                    $blade = 'library';
                    break;
            }
            // Send all to the view
            return view('frontEnd.'.$blade,
                compact('WebsiteSettings',
                    'section',
                    'WebmasterSettings',
                    'FooterMenuLinks_name_ar',
                    'FooterMenuLinks_name_en',
                    'LatestNews',
                    'SideBanners',
                    'WebmasterSection',
                    'Categories',
                    'Topics',
                    'CurrentCategory',
                    'PageTitle',
                    'PageDescription',
                    'PageKeywords',
                    'TopicsMostViewed',
                    'category_and_topics_count'));
        } else {
            return $this->SEOByLang($lang, $section);
        }
    }

    public function databases($cat = 0)
    {
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);
        // get Webmaster section settings by name
        $WebmasterSection = WebmasterSection::where('name', 'databases')->first();
        if (! empty($WebmasterSection) && in_array($cat, [42, 43, 44, 45, 46, 47, 48, 80, 81, 82, 83, 84, 85])) {
            // Get current Category Section details
            $CurrentCategory = Section::find($cat);
            $extraData = []; //  Optional
            $select1 = []; //  Trade Type
            $select2 = [];
            $select3 = [];
            $select4 = [];
            $ListArr = [];
            $item2 = '';
            $item3 = '';
            $details = false;
            $seasons = Config::get('constants.season');
            $groups = Config::get('constants.group');
            $lands = Config::get('constants.lands');
            $type = (! empty(\request()->input('type'))) ? \request()->input('type') : null; // Trade Type // 44
            $type_group = (! empty(\request()->input('type_group'))) ? \request()->input('type_group') : null;
            $item = (! empty(\request()->input('item'))) ? \request()->input('item') : null;
            if (! empty($CurrentCategory)) {
                if ($cat == 80) { //repo1
                    App\ReportCropStructure::all();
                    $type = \request()->input('type');
                    $item = $start = \request()->input('item');
                    $item2 = $end = \request()->input('item2');
                    $select4 = App\ReportCropStructure::query()->groupBy('year')->select('year')->get();
                    if ($year = \request()->input('year')) {
                        $ListArr = App\ReportCropStructure::query()->where('year', $year)->get();
                        $details = true;
                    } else {
                        $ListArr = App\ReportCropStructure::query()->whereBetween('year', [
                            $start, $end,
                        ])->select(['year', DB::raw('sum(winter_old) as winter_old'), DB::raw('sum(winter_new) as winter_new'), DB::raw('sum(perennial_old) as perennial_old'), DB::raw('sum(perennial_new) as perennial_new'), DB::raw('sum(summer_old) as summer_old'), DB::raw('sum(summer_new) as summer_new'), DB::raw('sum(indigo_old) as indigo_old'), DB::raw('sum(indigo_new) as indigo_new')])->groupBy(['year'])->get();
                    }
                } elseif ($cat == 42) { //repo1
                    $season = \request()->input('type');
                    $group = \request()->input('type_group');
                    $item3 = $crop = \request()->input('crop_name');
                    $item = $start = \request()->input('item');
                    $item2 = $end = \request()->input('item2');
                    $select1 = App\ReportPlant::query()->groupBy('group')->select('group')->get();
                    $select2 = App\ReportPlant::query()->groupBy('season')->select('season')->get();
                    $select3 = App\ReportPlant::query()->where(['season'=>$season, 'group'=>$group])->groupBy('crop')->select('crop')->get();
                    $select4 = App\ReportPlant::query()->groupBy('year')->select('year')->get();
                    if ($year = \request()->input('year')) {
                        $ListArr = App\ReportPlant::query()->where([
                            'season'=>$season,
                            'group'=>$group,
                            'crop'=>$crop,
                        ])->where('year', $year)->get();
                        $details = true;
                    } else {
                        $ListArr = App\ReportPlant::query()->where([
                            'season'=>$season,
                            'group'=>$group,
                            'crop'=>$crop,
                        ])->whereBetween('year', [
                            $start, $end,
                        ])->select(['year', DB::raw('sum(old_area) as old_area'), DB::raw('sum(old_quantity) as old_quantity'), DB::raw('sum(new_area) as new_area'), DB::raw('sum(new_quantity) as new_quantity')])->groupBy(['year'])->get();
                    }
                } elseif ($cat == 47) { //repo2
                    $select1 = App\ReportFoodBalance::query()->groupBy('group')->select('group')->get();
                    $select3 = App\ReportFoodBalance::query()->groupBy('crop')->select('crop')->get();
                    $select4 = App\ReportPlant::query()->groupBy('year')->select('year')->get();
                    $start = $item;
                    $end = $item2 = (! empty($_GET['item2'])) ? $_GET['item2'] : $item;
                    $item_name = (! empty($_GET['item_name'])) ? $_GET['item_name'] : $item3;
                    $crop = $item3 = $item_name;
                    $group = $type_group;

                    if (! empty($type_group) && ! empty($item)) {
                        if ($crop) {
                            $ListArr = App\ReportFoodBalance::query()->where([
                                'group'=>$group,
                                'crop'=>$crop,
                            ])->whereBetween('year', [
                                $start, $end,
                            ])->get();
                        } else {
                            $ListArr = App\ReportFoodBalance::query()
                                ->select(['year', 'population',
                                    DB::raw('sum(production) as production'),
                                    DB::raw('sum(imports) as imports'),
                                    DB::raw('sum(stock_first) as stock_first'),
                                    DB::raw('sum(stock_end) as stock_end'),
                                    DB::raw('sum(exports) as exports'),
                                    DB::raw('sum(available_consumption) as available_consumption'),
                                    DB::raw('sum(animal_food) as animal_food'),
                                    DB::raw('sum(seed) as seed'),
                                    DB::raw('sum(industry) as industry'),
                                    DB::raw('sum(human_food) as human_food'),
                                    DB::raw('sum(pure_food) as pure_food'),
                                    DB::raw('sum(human_year) as human_year'),
                                    DB::raw('sum(human_day) as human_day'),
                                    DB::raw('sum(human_cal) as human_cal'),
                                    DB::raw('sum(human_protein) as human_protein'),
                                    DB::raw('sum(human_fat) as human_fat'),
                                ])->where([
                                    'group'=>$group,
                                    //                                'crop'=>$crop,
                                ])->whereBetween('year', [
                                    $start, $end,
                                ])->groupBy(['year'])->get();
                        }
//                         print_r($ListArr);die();
                    }
                } elseif ($cat == 43) { //repo3
                    $select1 = \DB::select('SELECT distinct animal_type from rep3_1');
                    $select2 = \DB::select('SELECT distinct year from rep3_1 ORDER BY year ASC');
                    $select3 = $select2;

                    $repIndex = (! empty($_GET['repIndex'])) ? $_GET['repIndex'] : null;
                    $item2 = (! empty($_GET['item2'])) ? $_GET['item2'] : $item;
                    $animal_type = $type_group;

                    if (! empty($item) && $repIndex == 1) {
                        $query = 'SELECT * from rep3_1';
                        if (! empty($animal_type)) {
                            $query .= " WHERE animal_type = '$animal_type' and ";
                        } else {
                            $query .= ' WHERE ';
                        }

                        if ($item == $item2) {
                            $query .= ($item) ? 'year = '.$item : '';
                        } else {
                            $start = $item;
                            $end = $item2;
                            $query .= ($item) ? 'year between '.$start.' and '.$end : '';
                        }
                        // print_r($query);die();
                        $query .= ' ORDER BY year ASC';
                        $ListArr = \DB::select($query);

                        return view('frontEnd.__databases'.$cat, compact('ListArr', 'repIndex', 'cat'));
                    } elseif (! empty($item) && $repIndex == 2) {
                        $query = 'SELECT * from rep3_2 where ';
                        if ($item == $item2) {
                            $query .= ($item) ? 'year = '.$item : '';
                        } else {
                            $start = $item;
                            $end = $item2;
                            $query .= ($item) ? 'year between '.$start.' and '.$end : '';
                        }
                        $ListArr = \DB::select($query);

                        return view('frontEnd.__databases'.$cat, compact('ListArr', 'repIndex', 'cat'));
                    } elseif (isset($_GET['ajax'])) {
                        return '';
                    }
                } elseif ($cat == 44) { //repo4
                    $select1 = \DB::select('SELECT distinct type from rep4_1');
                    $select2 = \DB::select('SELECT distinct year from rep4_1 ORDER BY year ASC');
                    $select3 = $select2;

                    $repIndex = (! empty($_GET['repIndex'])) ? $_GET['repIndex'] : null;
                    $item2 = (! empty($_GET['item2'])) ? $_GET['item2'] : $item;
                    $animal_type = $type_group;

                    if (! empty($type_group) && ! empty($item) && $repIndex == 1) {
                        $query = "SELECT * from rep4_1
                        WHERE type = '$animal_type' and ";
                        if ($item == $item2) {
                            $query .= ($item) ? 'year = '.$item : '';
                        } else {
                            $start = $item;
                            $end = $item2;
                            $query .= ($item) ? 'year between '.$start.' and '.$end : '';
                        }
                        // print_r($query);die();
                        $query .= ' ORDER BY year ASC';
                        $ListArr = \DB::select($query);

                        return view('frontEnd.__databases43', compact('ListArr', 'repIndex', 'cat'));
                    } elseif (! empty($item) && $repIndex == 2) {
                        $query = 'SELECT * from rep4_2 where ';
                        if ($item == $item2) {
                            $query .= ($item) ? 'year = '.$item : '';
                        } else {
                            $start = $item;
                            $end = $item2;
                            $query .= ($item) ? 'year between '.$start.' and '.$end : '';
                        }
                        $ListArr = \DB::select($query);

                        return view('frontEnd.__databases43', compact('ListArr', 'repIndex', 'cat'));
                    } elseif (isset($_GET['ajax'])) {
                        return '';
                    }
                } elseif ($cat == 45) { //repo5
                    $select2 = \DB::select('SELECT distinct year from rep5_1 ORDER BY year ASC');
                    $select3 = $select2;

                    $repIndex = (! empty($_GET['repIndex'])) ? $_GET['repIndex'] : null;
                    $item2 = (! empty($_GET['item2'])) ? $_GET['item2'] : $item;

                    if (! empty($item) && ! empty($repIndex)) {
                        $query = 'SELECT * from rep5_'.$repIndex.' WHERE ';
                        if ($item == $item2) {
                            $query .= ($item) ? 'year = '.$item : '';
                        } else {
                            $start = $item;
                            $end = $item2;
                            $query .= ($item) ? 'year between '.$start.' and '.$end : '';
                        }
                        // print_r($query);die();
                        $query .= ' ORDER BY year ASC';
                        $ListArr = \DB::select($query);
                        if ($ListArr) {
                            return view('frontEnd.__databases45', compact('ListArr', 'repIndex', 'cat'));
                        } elseif (isset($_GET['ajax'])) {
                            return '';
                        }
                    } elseif (isset($_GET['ajax'])) {
                        return '';
                    }
                } elseif ($cat == 46) { //repo6
                    if (! empty($_GET['countries']) && in_array($_GET['countries'], ['imp', 'exp'])) {
                        $type = $_GET['countries'];
                        $item = $_GET['type_group'];
                        $year = $_GET['year'];

                        $query = "SELECT * from rep6_country
                            WHERE item = '$item' and year='$year' ORDER BY year ASC";

                        $ListArr = \DB::select($query);
                        $extraData['year'] = $year;
                    // return view("frontEnd.databases46", compact('ListArr','cat','type'));
                    } else {
                        $select1 = \DB::select('SELECT distinct item from rep6');
                        $select2 = \DB::select('SELECT distinct year from rep6 ORDER BY year ASC');
                        $select3 = $select2;

                        $item2 = (! empty($_GET['item2'])) ? $_GET['item2'] : $item;
                        if (! empty($type_group) && ! empty($item)) {
                            $query = "SELECT *,(SELECT sum(imp_price+imp_quantity) from rep6_country
                            WHERE rep6_country.item = rep6.item and rep6_country.year=rep6.year) count_imp ,(SELECT sum(exp_price+exp_quantity) from rep6_country
                            WHERE rep6_country.item = rep6.item and rep6_country.year=rep6.year) count_exp from rep6
                            WHERE item = '$type_group' and ";
                            if ($item == $item2) {
                                $query .= ($item) ? 'year = '.$item : '';
                            } else {
                                $start = $item;
                                $end = $item2;
                                $query .= ($item) ? 'year between '.$start.' and '.$end : '';
                            }
                            $query .= ' ORDER BY year ASC';
                            $ListArr = \DB::select($query);
                        //  return view("frontEnd.__databases43", compact('ListArr','cat'));
                        } elseif (isset($_GET['ajax'])) {
                            return '';
                        }
                    }
                } elseif ($cat == 48) {
                    $ListArr = Section::where([['status', 1], ['webmaster_id', 16]])->where('father_id', '=', $cat)->orderby('row_no', 'asc')->get();
                } elseif ($cat == 81) {
                    $season = \request()->input('type');
                    $item3 = $crop = \request()->input('crop_name');
                    $item = $start = \request()->input('item');
                    $item2 = $end = \request()->input('item2');
                    $select2 = App\ReportHistoricalPrice::query()->groupBy('season')->select('season')->get();
                    $select3 = App\ReportHistoricalPrice::query()->groupBy('crop')->select('crop')->get();
                    $select4 = App\ReportHistoricalPrice::query()->groupBy('year')->select('year')->get();
                    if ($year = \request()->input('year')) {
                        $ListArr = App\ReportHistoricalPrice::query()->where([
                            'season'=>$season,
                            'crop'=>$crop,
                        ])->where('year', $year)->get();
                        $details = true;
                    } else {
                        $ListArr = App\ReportHistoricalPrice::query()->where([
                            'season'=>$season,
                            'crop'=>$crop,
                        ])->whereBetween('year', [
                            $start, $end,
                        ])->select(['year', DB::raw('sum(farm_price) as farm_price'), DB::raw('sum(trading_price) as trading_price'), DB::raw('sum(total_price) as total_price')])->groupBy(['year'])->get();
                    }
                } elseif ($cat == 82) {
                    $ListArr = App\ReportInternationalPrice::all();
                } elseif ($cat == 83) {
                    $item3 = $crop = \request()->input('crop_name');
                    \Carbon\Carbon::setLocale('ar');
                    $item = \Carbon\Carbon::createFromTimestamp($start = \request()->input('item'));
                    $item2 = $end = \Carbon\Carbon::createFromTimestamp(\request()->input('item2'));
                    $select1 = App\ReportDailyPrice::query()->groupBy('group')->select('group')->get();
                    $select2 = App\ReportDailyPrice::query()->groupBy('crop')->select('crop')->get();
                    $select3 = App\ReportDailyPrice::query()->groupBy('date')->select('date')->get();
                    $ListArr = App\ReportDailyPrice::query()->where([
                        'group'=>$type_group,
                        'crop'=>$item3,
                    ])->whereBetween('date', [$item->toDateString(), $item2->toDateString()])->get();
                }
                // Old MS Access
                /*if($cat == 42 || $cat == 43){
                    $select1 = \DB::connection('databases')->select('SELECT  cod,name from mast_national_cod order by cod');
                    $select2 = \DB::connection('databases')->select('SELECT mmcod ,name FROM mast_imp_exp_crop_sub1 order by mmcod');
                }

                if($cat == 42){
                    if($type_group){
                        $query = "SELECT sub2 ,name FROM mast_imp_exp_crop_sub2 where sub1=".$type_group." order by sub2";
                        // print_r($query) ; die();
                        $select3 = \DB::connection('databases')->select($query);
                    }
                    if (!empty($type_group) && !empty($item)) {
                        $query = "SELECT round(sum( new_national_imp_exp.pound),0) as pound, round(sum( new_national_imp_exp.dollar),0) as dollar, round(sum( new_national_imp_exp.qun),0) as qty, new_national_imp_exp.year as n_year, count(new_national_imp_exp.numb) as n_count FROM mast_imp_exp_country ,mast_imp_exp_crop , mast_imp_exp_crop_sub2 , mast_imp_exp_crop_sub3 , mast_imp_exp_crop_sub1 , new_national_imp_exp , mast_national_cod WHERE ( mast_imp_exp_crop.sub1 = mast_imp_exp_crop_sub1.mmcod )
                        and ( mast_imp_exp_crop_sub2.sub1 = mast_imp_exp_crop.sub1 )
                        and ( mast_imp_exp_crop.sub2 = mast_imp_exp_crop_sub2.sub2 )
                        and ( mast_imp_exp_crop.sub3 = mast_imp_exp_crop_sub3.cod )
                        and ( mast_imp_exp_country.cod = new_national_imp_exp.country )
                        and ( mast_imp_exp_crop.cod = new_national_imp_exp.crop )
                        and ( mast_national_cod.cod = new_national_imp_exp.nation_cod )";

                        $query.= ($type_group)? "and ( mast_imp_exp_crop_sub2.sub1 = ".$type_group." )" : "";
                        $query.= ($item)? "and ( mast_imp_exp_crop_sub2.sub2 = ".$item." )" : "";
                        $query.= ($type)? "and ( new_national_imp_exp.nation_cod = " .$type. " )" : "";
                        $query.= "group by new_national_imp_exp.year order by new_national_imp_exp.year";
                        $ListArr = \DB::connection('databases')->select($query);
                    }
                }elseif($cat == 43){
                    $item2 = (!empty($_GET['item2'])) ? $_GET['item2'] : $item ;

                    $select3 = \DB::connection('databases')->select("SELECT  code ,year FROM year_99_tread order by code");
                    if (!empty($type_group) && !empty($item) && !empty($type)) {
                        $query = "SELECT mast_imp_exp_tka.name as t_name, mast_imp_exp_crop_sub2.name as crop_name,
                        mast_imp_exp_country.name as country_name, round(sum(new_national_imp_exp.qun),0) as qty ,
                        count(new_national_imp_exp.numb) as n_count , round(sum(new_national_imp_exp.pound),0) as pound ,
                        round(sum(new_national_imp_exp.dollar),0) as dollar FROM mast_imp_exp_country ,
                        mast_imp_exp_crop , mast_imp_exp_crop_sub2 , mast_imp_exp_crop_sub1 , new_national_imp_exp ,
                        mast_national_cod , mast_imp_exp_tka , mast_imp_exp_contry_tkatol
                        WHERE ( mast_imp_exp_crop.sub1 = mast_imp_exp_crop_sub1.mmcod )
                        and ( mast_imp_exp_crop_sub2.sub1 = mast_imp_exp_crop.sub1 )
                        and ( mast_imp_exp_crop.sub2 = mast_imp_exp_crop_sub2.sub2 )
                        and ( mast_imp_exp_country.cod = new_national_imp_exp.country )
                        and ( mast_imp_exp_crop.cod = new_national_imp_exp.crop )
                        and ( mast_national_cod.cod = new_national_imp_exp.nation_cod )
                        and ( mast_imp_exp_tka.cod = mast_imp_exp_contry_tkatol.tk_cod )
                        and ( mast_imp_exp_country.cod = mast_imp_exp_contry_tkatol.country_cod ) and (";
                        if ($item == $item2) {
                            $query .= ($item)? "( new_national_imp_exp.year = ".$item." ) and" : "";
                        }else{
                            $start = $item-1;
                            $end =$item2+1;
                            $query .= ($item)? "( new_national_imp_exp.year between ".$start." and ".$end." ) and" : "";
                        }
                        $query .= ($type_group)? " ( mast_imp_exp_crop_sub1.mmcod = ".$type_group." ) and" : "";
                        $query .= ($type)? " ( mast_national_cod.cod = ".$type." )" : "";

                        $query .= ") group by mast_imp_exp_tka.cod,mast_imp_exp_tka.name,mast_imp_exp_crop_sub2.sub2,mast_imp_exp_crop_sub2.name,mast_imp_exp_country.cod,mast_imp_exp_country.name
                        order by mast_imp_exp_tka.cod,mast_imp_exp_crop_sub2.sub2,mast_imp_exp_country.cod ";
                        $ListArr = \DB::connection('databases')->select($query);
                        // print_r($ListArr); die();
                    }
                }*/
            }

            // General for all pages
            $WebsiteSettings = Setting::find(1);
            $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
            $FooterMenuLinks_name_ar = '';
            $FooterMenuLinks_name_en = '';
            if (! empty($FooterMenuLinks_father)) {
                $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
            }

            // Page Title, Description, Keywords
            if (! empty($CurrentCategory)) {
                $seo_title_var = 'seo_title_'.trans('backLang.boxCode');
                $seo_description_var = 'seo_description_'.trans('backLang.boxCode');
                $seo_keywords_var = 'seo_keywords_'.trans('backLang.boxCode');
                $tpc_title_var = 'title_'.trans('backLang.boxCode');
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');
                if ($CurrentCategory->$seo_title_var != '') {
                    $PageTitle = $CurrentCategory->$seo_title_var;
                } else {
                    $PageTitle = $CurrentCategory->$tpc_title_var;
                }
                if ($CurrentCategory->$seo_description_var != '') {
                    $PageDescription = $CurrentCategory->$seo_description_var;
                } else {
                    $PageDescription = $WebsiteSettings->$site_desc_var;
                }
                if ($CurrentCategory->$seo_keywords_var != '') {
                    $PageKeywords = $CurrentCategory->$seo_keywords_var;
                } else {
                    $PageKeywords = $WebsiteSettings->$site_keywords_var;
                }
            } else {
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

                $PageTitle = trans('backLang.'.$WebmasterSection->name);
                $PageDescription = $WebsiteSettings->$site_desc_var;
                $PageKeywords = $WebsiteSettings->$site_keywords_var;
            }
            // .. end of .. Page Title, Description, Keywords
            // print_r($type);die();
            // Send all to the view
            return view('frontEnd.databases'.$cat,
                compact('WebsiteSettings',
                    'WebmasterSettings',
                    'FooterMenuLinks_name_ar',
                    'FooterMenuLinks_name_en',
                    'WebmasterSection',
                    'CurrentCategory',
                    'PageTitle',
                    'PageDescription',
                    'PageKeywords',
                    'select1',
                    'select2',
                    'select3',
                    'select4',
                    'type',
                    'type_group',
                    'item',
                    'item2',
                    'item3',
                    'ListArr',
                    'extraData',
                    'seasons',
                    'groups',
                    'lands',
                    'details'
                ));
        } else {
            return $this->SEOByLang('ar', 'databases');
        }
    }

    public function getNextSelect(Request $request)
    {
        $cat_id = $request->cat_id;
        if ($cat_id == 42) {
            if ($request->input('type') != '' && $request->input('type_group') != '') {
                $query = 'SELECT distinct crop from report_plants where season='.$request->type_group.' and `group`='.$request->type.' order by crop';
                $options = \DB::select($query);
                $response = [
                    'code' => '1',
                    'options' => $options,
                ];
            } elseif ($request->input('type') != '') {
                $query = 'SELECT distinct season from report_plants where `group`='.$request->type.' order by season';
                $options = \DB::select($query);
                $response = [
                    'code' => '1',
                    'options' => $options,
                ];
            }
        } elseif ($cat_id == 47) {
            $select3 = App\ReportFoodBalance::query()->where('group', $request->type_group)->groupBy(['crop'])->select('crop')->get();
            $response = [
                'code' => '1',
                'options' => $select3,
            ];
        } elseif ($cat_id == 83) {
            $select3 = App\ReportDailyPrice::query()->where('group', trim($request->type))->groupBy(['crop'])->select('crop')->get();
            $response = [
                'code' => '1',
                'options' => $select3,
            ];
        } else {
            $response = [
                'code' => '-1',
                'options' => [],
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $section
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function topicByLang($lang = '', $section = 0, $id = 0)
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        // check for pages called by name not id
        switch ($section) {
            case 'about':
                $id = 1;
                $section = 1;
                break;
            case 'privacy':
                $id = 3;
                $section = 1;
                break;
            case 'terms':
                $id = 4;
                $section = 1;
                break;
        }

        // get Webmaster section settings by name
        $WebmasterSection = WebmasterSection::where('name', $section)->first();
        if (empty($WebmasterSection)) {
            // get Webmaster section settings by ID
            $WebmasterSection = WebmasterSection::find($section);
        }
        if (! empty($WebmasterSection)) {

            // count topics by Category
            $category_and_topics_count = [];
            $AllSections = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('status', 1)->orderby('row_no', 'asc')->get();
            if (count($AllSections) > 0) {
                foreach ($AllSections as $AllSection) {
                    $category_topics = [];
                    $TopicCategories = TopicCategory::where('section_id', $AllSection->id)->get();
                    foreach ($TopicCategories as $category) {
                        $category_topics[] = $category->topic_id;
                    }

                    $Topics = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->get();
                    $category_and_topics_count[$AllSection->id] = count($Topics);
                }
            }

            $Topic = Topic::where('status', 1)->find($id);

            if (! empty($Topic) && ($Topic->expire_date == '' || ($Topic->expire_date != '' && $Topic->expire_date >= date('Y-m-d')))) {
                // update visits
                $Topic->visits = $Topic->visits + 1;
                $Topic->save();

                // Get current Category Section details
                $CurrentCategory = [];
                $TopicCategory = TopicCategory::where('topic_id', $Topic->id)->first();
                if (! empty($TopicCategory)) {
                    $CurrentCategory = Section::find($TopicCategory->section_id);
                }
                // Get a list of all Category ( for side bar )
                $Categories = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('status',
                    1)->where('father_id', '=', '0')->orderby('row_no', 'asc')->get();

                // Get Most Viewed
                $TopicsMostViewed = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->orderby('visits', 'desc')->limit(3)->get();

                // General for all pages

                $WebsiteSettings = Setting::find(1);
                $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
                $FooterMenuLinks_name_ar = '';
                $FooterMenuLinks_name_en = '';
                if (! empty($FooterMenuLinks_father)) {
                    $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                    $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
                }
                $SideBanners = Banner::where('section_id', $WebmasterSettings->side_banners_section_id)->where('status',
                    1)->orderby('row_no', 'asc')->get();

                // Get Latest News
                $LatestNews = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(3)->get();

                // Page Title, Description, Keywords
                $seo_title_var = 'seo_title_'.trans('backLang.boxCode');
                $seo_description_var = 'seo_description_'.trans('backLang.boxCode');
                $seo_keywords_var = 'seo_keywords_'.trans('backLang.boxCode');
                $tpc_title_var = 'title_'.trans('backLang.boxCode');
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');
                if ($Topic->$seo_title_var != '') {
                    $PageTitle = $Topic->$seo_title_var;
                } else {
                    $PageTitle = $Topic->$tpc_title_var;
                }
                if ($Topic->$seo_description_var != '') {
                    $PageDescription = $Topic->$seo_description_var;
                } else {
                    $PageDescription = $WebsiteSettings->$site_desc_var;
                }
                if ($Topic->$seo_keywords_var != '') {
                    $PageKeywords = $Topic->$seo_keywords_var;
                } else {
                    $PageKeywords = $WebsiteSettings->$site_keywords_var;
                }
                // .. end of .. Page Title, Description, Keywords

                $blade = 'topic';
                switch ($section) {
                    case 'news':
                        $blade = 'inner.newsItem';
                        break;
                    case 'photos':
                        $blade = 'inner.photosItem';
                        break;
                    case 'events':
                        $blade = 'inner.eventsItem';
                        break;
                }

                return view('frontEnd.'.$blade,
                    compact('WebsiteSettings',
                        'WebmasterSettings',
                        'FooterMenuLinks_name_ar',
                        'FooterMenuLinks_name_en',
                        'LatestNews',
                        'Topic',
                        'SideBanners',
                        'WebmasterSection',
                        'Categories',
                        'CurrentCategory',
                        'PageTitle',
                        'PageDescription',
                        'PageKeywords',
                        'TopicsMostViewed',
                        'category_and_topics_count'));
            } else {
                return redirect()->action('FrontendHomeController@HomePage');
            }
        } else {
            return redirect()->action('FrontendHomeController@HomePage');
        }
    }

    public function subCatQuery(Request $request)
    {
        $html = '';
        $father_id = $request->input('father_id');
        if ($father_id) {
            $curTitle = 'title_'.trans('backLang.boxCode');
            $subCats = Section::where('father_id', $father_id)->pluck($curTitle, 'id');
            //print_r($subCats); die();
            if (count($subCats) > 0) {
                $html .= '<select name="father_id_second" class="form-control c-select">
                        <option value="">'.trans('backLang.secondLevel').'</option>';
                foreach ($subCats as $key=>$value) {
                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                }
                $html .= '</select>';
            }
        }

        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $section
     * @param  int $cat
     * @return \Illuminate\Http\Response
     */
    public function topics($section = 0, $cat = 0, $lang = '')
    {
        if (($section == 'library' || $section == 'databases' || $section == 'agri-counter' || $section == 'media') && $cat == 0) {
            switch ($section) {
                case 'library':
                    $webmaster_id = 12;
                    break;
                case 'agri-counter':
                    $webmaster_id = 15;
                    break;

                default:
                    $webmaster_id = 16;
                    break;
            }
            if ($lang != '') {
                // Set Language
                App::setLocale($lang);
                \Session::put('locale', $lang);
            }
            // General Webmaster Settings
            $WebmasterSettings = WebmasterSetting::find(1);
            if ($section != 'media') {
                $WebmasterSection = WebmasterSection::find($webmaster_id);
                $Sections = Section::where([['status', 1], ['webmaster_id', $webmaster_id]])->where('father_id', '=', '0')->orderby('row_no', 'asc')->get();
                $view = 'categories';
            } else {
                $WebmasterSection = '';
                $Sections = '';
                $view = 'mediaHome';
            }
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
            // print_r('expression');die();
            return view('frontEnd.'.$view,
                compact('WebsiteSettings',
                    'WebmasterSection',
                    'CurrentCategory',
                    'WebmasterSettings',
                    'FooterMenuLinks_name_ar',
                    'FooterMenuLinks_name_en',
                    'PageTitle',
                    'PageDescription',
                    'PageKeywords',
                    'PageDescription',
                    'PageKeywords',
                    'Sections'
                )
            );
        }

        return $this->topicsByLang('', $section, $cat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function userTopics($id)
    {
        return $this->userTopicsByLang('', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $lang
     * @param int|null $id
     * @return \Illuminate\Http\Response
     */
    public function userTopicsByLang(string $lang = '', ?int $id = null)
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        // get User Details
        $User = User::find($id);
        if (! empty($User)) {

            // count topics by Category
            $category_and_topics_count = [];
            $AllSections = Section::where('status', 1)->orderby('row_no', 'asc')->get();
            if (! empty($AllSections)) {
                foreach ($AllSections as $AllSection) {
                    $category_topics = [];
                    $TopicCategories = TopicCategory::where('section_id', $AllSection->id)->get();
                    foreach ($TopicCategories as $category) {
                        $category_topics[] = $category->topic_id;
                    }

                    $Topics = Topic::where([['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->get();
                    $category_and_topics_count[$AllSection->id] = count($Topics);
                }
            }

            // Get current Category Section details
            $CurrentCategory = 'none';
            $WebmasterSection = 'none';
            // Get a list of all Category ( for side bar )
            $Categories = Section::where('father_id', '=',
                '0')->where('status', 1)->orderby('row_no', 'asc')->get();

            // Topics if NO Cat_ID
            $Topics = Topic::where([['created_by', $User->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['created_by', $User->id], ['status', 1], ['expire_date', null]])->orderby('row_no', 'asc')->paginate(env('FRONTEND_PAGINATION'));
            // Get Most Viewed
            $TopicsMostViewed = Topic::where([['created_by', $User->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['created_by', $User->id], ['status', 1], ['expire_date', null]])->orderby('visits', 'desc')->limit(3)->get();

            // General for all pages

            $WebsiteSettings = Setting::find(1);
            $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
            $FooterMenuLinks_name_ar = '';
            $FooterMenuLinks_name_en = '';
            if (! empty($FooterMenuLinks_father)) {
                $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
            }
            $SideBanners = Banner::where('section_id', $WebmasterSettings->side_banners_section_id)->where('status',
                1)->orderby('row_no', 'asc')->get();

            // Get Latest News
            $LatestNews = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(3)->get();

            // Page Title, Description, Keywords
            $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
            $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

            $PageTitle = $User->name;
            $PageDescription = $WebsiteSettings->$site_desc_var;
            $PageKeywords = $WebsiteSettings->$site_keywords_var;

            // .. end of .. Page Title, Description, Keywords

            // Send all to the view
            return view('frontEnd.topics',
                compact('WebsiteSettings',
                    'WebmasterSettings',
                    'FooterMenuLinks_name_ar',
                    'FooterMenuLinks_name_en',
                    'LatestNews',
                    'User',
                    'SideBanners',
                    'WebmasterSection',
                    'Categories',
                    'Topics',
                    'CurrentCategory',
                    'PageTitle',
                    'PageDescription',
                    'PageKeywords',
                    'TopicsMostViewed',
                    'category_and_topics_count'));
        } else {
            // If no section name/ID go back to home
            return redirect()->action('FrontendHomeController@HomePage');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchTopics(Request $request)
    {

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        $search_word = $request->search_word;

        if ($search_word != '') {

            // count topics by Category
            $category_and_topics_count = [];
            $AllSections = Section::where('status', 1)->orderby('row_no', 'asc')->get();
            if (! empty($AllSections)) {
                foreach ($AllSections as $AllSection) {
                    $category_topics = [];
                    $TopicCategories = TopicCategory::where('section_id', $AllSection->id)->get();
                    foreach ($TopicCategories as $category) {
                        $category_topics[] = $category->topic_id;
                    }

                    $Topics = Topic::where([['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orWhere([['status', 1], ['expire_date', null]])->whereIn('id', $category_topics)->orderby('row_no', 'asc')->get();
                    $category_and_topics_count[$AllSection->id] = count($Topics);
                }
            }

            // Get current Category Section details
            $CurrentCategory = 'none';
            $WebmasterSection = 'none';
            // Get a list of all Category ( for side bar )
            $Categories = Section::where('father_id', '=',
                '0')->where('status', 1)->orderby('row_no', 'asc')->get();

            // Topics if NO Cat_ID
            $Topics = Topic::where('title_ar', 'like', '%'.$search_word.'%')
                ->orwhere('title_en', 'like', '%'.$search_word.'%')
                ->orwhere('seo_title_ar', 'like', '%'.$search_word.'%')
                ->orwhere('seo_title_en', 'like', '%'.$search_word.'%')
                ->orwhere('details_ar', 'like', '%'.$search_word.'%')
                ->orwhere('details_en', 'like', '%'.$search_word.'%')
                ->orderby('id', 'desc')->paginate(env('FRONTEND_PAGINATION'));
            // Get Most Viewed
            $TopicsMostViewed = Topic::where([['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['expire_date', null]])->orderby('visits', 'desc')->limit(3)->get();

            // General for all pages

            $WebsiteSettings = Setting::find(1);
            $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
            $FooterMenuLinks_name_ar = '';
            $FooterMenuLinks_name_en = '';
            if (! empty($FooterMenuLinks_father)) {
                $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
            }
            $SideBanners = Banner::where('section_id', $WebmasterSettings->side_banners_section_id)->where('status',
                1)->orderby('row_no', 'asc')->get();

            // Get Latest News
            $LatestNews = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(3)->get();

            // Page Title, Description, Keywords
            $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
            $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');

            $PageTitle = $search_word;
            $PageDescription = $WebsiteSettings->$site_desc_var;
            $PageKeywords = $WebsiteSettings->$site_keywords_var;

            // .. end of .. Page Title, Description, Keywords

            // Send all to the view
            return view('frontEnd.topics',
                compact('WebsiteSettings',
                    'WebmasterSettings',
                    'FooterMenuLinks_name_ar',
                    'FooterMenuLinks_name_en',
                    'LatestNews',
                    'search_word',
                    'SideBanners',
                    'WebmasterSection',
                    'Categories',
                    'Topics',
                    'CurrentCategory',
                    'PageTitle',
                    'PageDescription',
                    'PageKeywords',
                    'TopicsMostViewed',
                    'category_and_topics_count'));
        } else {
            // If no section name/ID go back to home
            return redirect()->action('FrontendHomeController@HomePage');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ContactPage()
    {
        return $this->ContactPageByLang('');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ContactPageByLang($lang = '')
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        $id = $WebmasterSettings->contact_page_id;
        $Topic = Topic::where('status', 1)->find($id);

        if (! empty($Topic) && ($Topic->expire_date == '' || ($Topic->expire_date != '' && $Topic->expire_date >= date('Y-m-d')))) {

            // update visits
            $Topic->visits = $Topic->visits + 1;
            $Topic->save();

            // get Webmaster section settings by ID
            $WebmasterSection = WebmasterSection::find($Topic->webmaster_id);

            if (! empty($WebmasterSection)) {

                // Get current Category Section details
                $CurrentCategory = Section::find($Topic->section_id);
                // Get a list of all Category ( for side bar )
                $Categories = Section::where('webmaster_id', '=', $WebmasterSection->id)->where('father_id', '=',
                    '0')->where('status', 1)->orderby('row_no', 'asc')->get();

                // Get Most Viewed
                $TopicsMostViewed = Topic::where([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['webmaster_id', '=', $WebmasterSection->id], ['status', 1], ['expire_date', null]])->orderby('visits', 'desc')->limit(3)->get();

                // General for all pages

                $WebsiteSettings = Setting::find(1);
                $FooterMenuLinks_father = Menu::find($WebmasterSettings->footer_menu_id);
                $FooterMenuLinks_name_ar = '';
                $FooterMenuLinks_name_en = '';
                if (! empty($FooterMenuLinks_father)) {
                    $FooterMenuLinks_name_ar = $FooterMenuLinks_father->title_ar;
                    $FooterMenuLinks_name_en = $FooterMenuLinks_father->title_en;
                }
                $SideBanners = Banner::where('section_id', $WebmasterSettings->side_banners_section_id)->where('status',
                    1)->orderby('row_no', 'asc')->get();

                // Get Latest News
                $LatestNews = Topic::where([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', '>=', date('Y-m-d')], ['expire_date', '<>', null]])->orwhere([['status', 1], ['webmaster_id', $WebmasterSettings->latest_news_section_id], ['expire_date', null]])->orderby('row_no', 'asc')->limit(3)->get();

                // Page Title, Description, Keywords
                $seo_title_var = 'seo_title_'.trans('backLang.boxCode');
                $seo_description_var = 'seo_description_'.trans('backLang.boxCode');
                $seo_keywords_var = 'seo_keywords_'.trans('backLang.boxCode');
                $tpc_title_var = 'title_'.trans('backLang.boxCode');
                $site_desc_var = 'site_desc_'.trans('backLang.boxCode');
                $site_keywords_var = 'site_keywords_'.trans('backLang.boxCode');
                if ($Topic->$seo_title_var != '') {
                    $PageTitle = $Topic->$seo_title_var;
                } else {
                    $PageTitle = $Topic->$tpc_title_var;
                }
                if ($Topic->$seo_description_var != '') {
                    $PageDescription = $Topic->$seo_description_var;
                } else {
                    $PageDescription = $WebsiteSettings->$site_desc_var;
                }
                if ($Topic->$seo_keywords_var != '') {
                    $PageKeywords = $Topic->$seo_keywords_var;
                } else {
                    $PageKeywords = $WebsiteSettings->$site_keywords_var;
                }
                // .. end of .. Page Title, Description, Keywords

                return view('frontEnd.contact',
                    compact('WebsiteSettings',
                        'WebmasterSettings',
                        'FooterMenuLinks_name_ar',
                        'FooterMenuLinks_name_en',
                        'LatestNews',
                        'Topic',
                        'SideBanners',
                        'WebmasterSection',
                        'Categories',
                        'CurrentCategory',
                        'PageTitle',
                        'PageDescription',
                        'PageKeywords',
                        'TopicsMostViewed'));
            } else {
                return redirect()->action('FrontendHomeController@HomePage');
            }
        } else {
            return redirect()->action('FrontendHomeController@HomePage');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ContactPageSubmit(Request $request)
    {
        $rules = [
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_subject' => 'required',
            'contact_message' => 'required',
        ];
        if (env('NOCAPTCHA_STATUS', false)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->getMessageBag()->first();
        }

        // SITE SETTINGS
        $WebsiteSettings = Setting::find(1);
        $site_title_var = 'site_title_'.trans('backLang.boxCode');
        $site_email = $WebsiteSettings->site_webmails;
        // print_r($site_email);die();
        $site_url = $WebsiteSettings->site_url;
        $site_title = $WebsiteSettings->$site_title_var;

        $Webmail = new Webmail;
        $Webmail->cat_id = 0;
        $Webmail->group_id = null;
        $Webmail->title = $request->contact_subject;
        $Webmail->details = $request->contact_message;
        $Webmail->date = date('Y-m-d H:i:s');
        $Webmail->from_email = $request->contact_email;
        $Webmail->from_name = $request->contact_name;
        $Webmail->from_phone = $request->contact_phone;
        $Webmail->to_email = $WebsiteSettings->site_webmails;
        $Webmail->to_name = $site_title;
        $Webmail->status = 0;
        $Webmail->flag = 0;
        $Webmail->save();

        // SEND Notification Email
        if ($WebsiteSettings->notify_messages_status) {
            if (env('MAIL_USERNAME') != '') {
                Mail::send('backEnd.emails.webmail', [
                    'title' => 'NEW MESSAGE:'.$request->contact_subject,
                    'details' => $request->contact_message,
                    'websiteURL' => $site_url,
                    'websiteName' => $site_title,
                ], function ($message) use ($request, $site_email, $site_title) {
                    $message->from(env('NO_REPLAY_EMAIL', $request->contact_email), $request->contact_name);
                    $message->to($site_email);
                    $message->replyTo($request->contact_email, $site_title);
                    $message->subject($request->contact_subject);
                });
            }
        }

        //return redirect()->action('FrontendHomeController@ContactPageByLang')->with('doneMessage', trans('frontLang.messageRecieved'));
        return 'OK';
    }

    private function luminance($hex, $percent)
    {
        $hex = preg_replace('/[^0-9a-fA-F]/i', '', $hex);
        $new_hex = '#';

        if (strlen($hex) < 6) {
            $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
        }

        // convert to decimal and change luminosity
        for ($i = 0; $i < 3; $i++) {
            $dec = hexdec(substr($hex, $i * 2, 2));
            $dec = min(max(0, $dec + $dec * $percent), 255);
            $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
        }

        return $new_hex;
    }

    public function crops($year, $crop = 0, $value = 'quantity')
    {
        $color = [];
        $data = [];
        $name = 'title_'.trans('backLang.boxCode');
        if ($crop == 0) {
            $CityCrop = App\CityCrop::query()
                ->with(['Crop', 'City'])
                ->select('year', DB::raw('sum(quantity)'))
                ->where('year', $year)
                ->where('season', \request()->input('season'))
                ->whereHas('City', function ($q) {
                    $q->where('id', '<', 30);
                })
                ->groupBy(['city_id'])
                ->get();
            foreach (App\City::where('id', '<', 30)->get() as $City) {
                $Crops = $City->Crops()->where('year', $year)->get();
                $tooltip = '';
                foreach ($Crops as $Crop) {
                    $tooltip .= $Crop->pivot->$value.' من '.$Crop->$name.'<br>';
                }
                $data[$City->id] = [
                    'id'=> str_pad($City->id, 2, '0', STR_PAD_LEFT),
                    'value'=>'',
                    'tooltext'=>'<div style="text-align:justify;">'.$City->$name.'<br/>'.($tooltip != '' ? $tooltip : 'لايوجد محاصيل').'</div>',
                    'displayvalue'=>$City->$name,
                ];
            }
            foreach ($CityCrop->groupBy('crop_id') as $Crop) {
                $Crop = $Crop->sortByDesc($value)->first();
                $color[] = [
                    'minvalue'=>$Crop->$value - .001,
                    'maxvalue'=>$Crop->$value + .001,
                    'code'=>$Crop->Crop->color,
                    'displayValue'=>$Crop->Crop->$name,
                ];
                $data[$Crop->City->id] = [
                    'id'=> str_pad($Crop->City->id, 2, '0', STR_PAD_LEFT),
                    'value'=>$Crop->$value,
                    'tooltext'=>'<div style="text-align:justify;">'.$Crop->City->$name.'<br/>'.$Crop->$value.' من '.$Crop->Crop->$name.'</div>',
                    'displayvalue'=>$Crop->City->$name,
                ];
            }
        } else {
            $Crop = App\Crop::find($crop);
            $CityCrop = App\CityCrop::query()
                ->with(['Crop', 'City', 'Center'])
                ->select('city_id', 'center_id', 'crop_id', DB::raw('sum(quantity) as quantity'), DB::raw('sum(area) as area'), DB::raw('sum(productivity) as productivity')
                )
                ->where('year', $year)
                ->where('season', \request()->input('season'))
                ->where('crop_id', $crop)
                ->whereHas('City', function ($q) {
                    $q->where('id', '<', 30);
                })
                ->groupBy(['city_id'])
                ->get();
            foreach (App\City::where('id', '<', 30)->get() as $City) {
                $data[$City->id] = [
                    'id'=> str_pad($City->id, 2, '0', STR_PAD_LEFT),
                    'value'=>0,
                    'tooltext'=>'<div style="text-align:justify; width: 150px; font-size:16px;line-height: 1.6">لايوجد محاصيل</div>',
                    'displayvalue'=>$City->$name,
                    'color'=>'#c6c6c6',
                ];
            }
            $max = $CityCrop->max($value);
            $min = $CityCrop->min($value);
            $step = (($max - $min) / 4) ? (($max - $min) / 4) : .0001;
            $shade = .8;
            for ($i = $min; $i <= $max; $i += $step) {
//                dd($i);
                $color[] = [
                    'minvalue'=> $i,
                    'maxvalue'=> $i + $step,
                    'code'=> $this->luminance($Crop->color, ($shade = $shade - .30)),
                    'displayValue'=>'اقل من '.round(($i + $step), -(strlen(round($min + $step)) > 3 ? 3 : 1)),
                ];
            }
            foreach ($CityCrop as $Crop) {
                $data[$Crop->City->id] = [
                    'id'=> str_pad($Crop->City->id, 2, '0', STR_PAD_LEFT),
                    'value'=>$Crop->$value,
                    'tooltext'=>'<div style="text-align:justify; width: 150px; font-size:16px;line-height: 1.6">'.$Crop->City->$name.'<br/>'.$Crop->$value.' من '.$Crop->Crop->$name.'</div>',
                    'displayvalue'=>$Crop->City->$name,

                ];
            }
        }

        return response()->json(['color'=>$color, 'data'=>array_values($data)]);
    }

    public function city($city, $lang = '')
    {
        if ($lang != '') {
            // Set Language
            App::setLocale($lang);
            \Session::put('locale', $lang);
        }
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

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
        $city = App\City::where('code', $city)->first();
        //dd($city);
        $crop = App\Crop::find(\request()->input('crop'));
        $year = \request()->input('year');
        $season = \request()->input('season');
        if (! $crop || ! $year || ! $city || ! $season) {
            abort(404);
        }
        $city_crops = App\CityCrop::query()
            ->with(['Crop', 'City', 'Center'])
            ->where('year', $year)
            ->where('season', $season)
            ->where('crop_id', $crop->id)
            ->whereHas('City', function ($q) use ($city) {
                $q->where('id', '=', $city->id);
            })
            ->get();

        return view('frontEnd.city',
            compact('WebsiteSettings',
                'WebmasterSettings',
                'FooterMenuLinks_name_ar',
                'FooterMenuLinks_name_en',
                'PageTitle',
                'PageDescription',
                'PageKeywords',
                'city', 'year', 'crop', 'city_crops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function subscribeSubmit(Request $request)
    {
        $this->validate($request, [
            'subscribe_name' => 'required',
            'subscribe_email' => 'required|email',
        ]);

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        $Contacts = Contact::where('email', $request->subscribe_email)->get();
        if (count($Contacts) > 0) {
            return trans('frontLang.subscribeToOurNewsletterError');
        } else {
            $subscribe_names = explode(' ', $request->subscribe_name, 2);

            $Contact = new Contact;
            $Contact->group_id = $WebmasterSettings->newsletter_contacts_group;
            $Contact->first_name = @$subscribe_names[0];
            $Contact->last_name = @$subscribe_names[1];
            $Contact->email = $request->subscribe_email;
            $Contact->status = 1;
            $Contact->save();

            return 'OK';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function commentSubmit(Request $request)
    {
        $this->validate($request, [
            'comment_name' => 'required',
            'comment_message' => 'required',
            'topic_id' => 'required',
            'comment_email' => 'required|email',
        ]);

        if (env('NOCAPTCHA_STATUS', false)) {
            $this->validate($request, [
                'g-recaptcha-response' => 'required|captcha',
            ]);
        }

        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

        $next_nor_no = Comment::where('topic_id', '=', $request->topic_id)->max('row_no');
        if ($next_nor_no < 1) {
            $next_nor_no = 1;
        } else {
            $next_nor_no++;
        }

        $Comment = new Comment;
        $Comment->row_no = $next_nor_no;
        $Comment->name = $request->comment_name;
        $Comment->email = $request->comment_email;
        $Comment->comment = $request->comment_message;
        $Comment->topic_id = $request->topic_id;
        $Comment->date = date('Y-m-d H:i:s');
        $Comment->status = $WebmasterSettings->new_comments_status;
        $Comment->save();

        // Site Details
        $WebsiteSettings = Setting::find(1);
        $site_title_var = 'site_title_'.trans('backLang.boxCode');
        $site_email = $WebsiteSettings->site_webmails;
        $site_url = $WebsiteSettings->site_url;
        $site_title = $WebsiteSettings->$site_title_var;

        // Topic details
        $Topic = Topic::where('status', 1)->find($request->topic_id);
        if (! empty($Topic)) {
            $tpc_title_var = 'title_'.trans('backLang.boxCode');
            $tpc_title = $Topic->$tpc_title_var;

            // SEND Notification Email
            if ($WebsiteSettings->notify_comments_status) {
                if (env('MAIL_USERNAME') != '') {
                    Mail::send('backEnd.emails.webmail', [
                        'title' => 'NEW Comment on :'.$tpc_title,
                        'details' => $request->comment_message,
                        'websiteURL' => $site_url,
                        'websiteName' => $site_title,
                    ], function ($message) use ($request, $site_email, $site_title, $tpc_title) {
                        $message->from(env('NO_REPLAY_EMAIL', $request->comment_email), $request->comment_name);
                        $message->to($site_email);
                        $message->replyTo($request->comment_email, $site_title);
                        $message->subject('NEW Comment on :'.$tpc_title);
                    });
                }
            }
        }

        return 'OK';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function orderSubmit(Request $request)
    {
        $this->validate($request, [
            'order_name' => 'required',
            'order_phone' => 'required',
            'order_qty' => 'required',
            'topic_id' => 'required',
            'order_email' => 'required|email',
        ]);

        if (env('NOCAPTCHA_STATUS', false)) {
            $this->validate($request, [
                'g-recaptcha-response' => 'required|captcha',
            ]);
        }

        $WebsiteSettings = Setting::find(1);
        $site_title_var = 'site_title_'.trans('backLang.boxCode');
        $site_email = $WebsiteSettings->site_webmails;
        $site_url = $WebsiteSettings->site_url;
        $site_title = $WebsiteSettings->$site_title_var;

        $Topic = Topic::where('status', 1)->find($request->topic_id);
        if (! empty($Topic)) {
            $tpc_title_var = 'title_'.trans('backLang.boxCode');
            $tpc_title = $Topic->$tpc_title_var;

            $Webmail = new Webmail;
            $Webmail->cat_id = 0;
            $Webmail->group_id = null;
            $Webmail->contact_id = null;
            $Webmail->father_id = null;
            $Webmail->title = 'ORDER '.', Qty='.$request->order_qty.', '.$Topic->$tpc_title_var;
            $Webmail->details = $request->order_message;
            $Webmail->date = date('Y-m-d H:i:s');
            $Webmail->from_email = $request->order_email;
            $Webmail->from_name = $request->order_name;
            $Webmail->from_phone = $request->order_phone;
            $Webmail->to_email = $WebsiteSettings->site_webmails;
            $Webmail->to_name = $WebsiteSettings->$site_title_var;
            $Webmail->status = 0;
            $Webmail->flag = 0;
            $Webmail->save();

            // SEND Notification Email
            $msg_details = "$tpc_title <br> Qty = ".$request->order_qty.'<hr>'.$request->order_message;
            if ($WebsiteSettings->notify_orders_status) {
                if (env('MAIL_USERNAME') != '') {
                    Mail::send('backEnd.emails.webmail', [
                        'title' => 'NEW Order on :'.$tpc_title,
                        'details' => $msg_details,
                        'websiteURL' => $site_url,
                        'websiteName' => $site_title,
                    ], function ($message) use ($request, $site_email, $site_title, $tpc_title) {
                        $message->from(env('NO_REPLAY_EMAIL', $request->order_email), $request->order_name);
                        $message->to($site_email);
                        $message->replyTo($request->order_email, $site_title);
                        $message->subject('NEW Order on :'.$tpc_title);
                    });
                }
            }
        }

        return 'OK';
    }

    public function search()
    {
        $WebmasterSettings = WebmasterSetting::find(1);

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

        return View('frontEnd.search', compact('WebsiteSettings',
            'WebmasterSettings',
            'FooterMenuLinks_name_ar',
            'FooterMenuLinks_name_en',
            'PageTitle',
            'PageDescription',
            'PageKeywords'));
    }

    public function map()
    {
        // General Webmaster Settings
        $WebmasterSettings = WebmasterSetting::find(1);

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

        return View('frontEnd.map', compact('WebsiteSettings',
            'WebmasterSettings',
            'FooterMenuLinks_name_ar',
            'FooterMenuLinks_name_en',
            'PageTitle',
            'PageDescription',
            'PageKeywords'));
    }
}
