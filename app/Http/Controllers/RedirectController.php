<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\NewsPublisher;

class RedirectController extends Controller
{
    public function home ()
    {
      return view ('welcome');
    }

    public function publisher ()
    {
      return view ('publisher',['publishers' => NewsPublisher::all()]);
    }
}
