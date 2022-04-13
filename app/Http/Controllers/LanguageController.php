<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        if (! \session()->has('locale')) {
            \session()->put('locale', $request->input('locale'));
        } else {
            \session()->put('locale', $request->input('locale'));
        }

        return redirect()->back();
    }

    public function change($lang)
    {
        \session()->put('locale', $lang);

        return redirect()->route('Home');
    }
}
