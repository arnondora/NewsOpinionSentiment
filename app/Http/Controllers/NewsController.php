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

    public function publisherInfo ($newsId)
    {
      $publisher = NewsPublisher::find($newsId);

      $rss = simplexml_load_file($publisher->url);
      $namespaces = $rss->getNamespaces(true);

      $newses = $rss->channel->item;

      return view('publisher.publisherInfo',['publisher' => $publisher, 'newses' => $newses, 'namespaces' => $namespaces]);
    }

    public function newNewsPublisher (Request $request)
    {
      $publisher = new NewsPublisher();
      $publisher->name = $request->name;
      $publisher->url = $request->url;

      $publisher->save();
      return back()->with('status','Add News Publisher Successfully');
    }

    public function deleteNewsPublisher (Request $request)
    {
      $publisher = NewsPublisher::find($request->newsID);
      $publisher->delete();

      return back()->with('status','Delete News Publisher Successfully');
    }
}
