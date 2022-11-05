<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Config;
use Redirect;

class LocalizationController extends Controller
{
    public function index($lang)
    {  
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }
}
