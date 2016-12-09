<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\NewsPublisher;

class NewsController extends Controller
{
    public function showFeatureNews ()
    {
      return (String) view('news.feature');
    }

    public function newNewsPublisher (Request $request)
    {
      $publisher = new NewsPublisher();
      $publisher->name = $request->name;
      $publisher->url = $request->url;

      $publisher->save();
      return back()->with('status','Add News Publisher Successfully');
    }
}
