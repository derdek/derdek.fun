<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LocalizationController extends Controller
{
    public function setLocale($locale, Request $request){

      if (!in_array($locale, config('app.languages'))){
          return redirect()->route('main');
      }

      $request->session()->put('lang', $locale);

      return redirect()->route('main');
    }
}
