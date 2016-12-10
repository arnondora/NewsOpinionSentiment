<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPHtmlParser\Dom;

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
      $thumbnailURLs = array();

      foreach ($newses as $news)
      {
        foreach ($news->children($namespaces['media']) as $element)
        {
          if (strcmp($element->getName(),"thumbnail") == 0)
          {
            array_push($thumbnailURLs,$news->children($namespaces['media'])->thumbnail->attributes()->url);
          }

          elseif (strcmp($element->getName(),"group") == 0)
          {
            $mediaGroup = $news->children($namespaces['media'])->group;
            array_push ($thumbnailURLs,$mediaGroup->children($namespaces['media'])->content->attributes()->url);
          }
          else array_push($thumbnailURLs,null);
        }
      }
      return view('publisher.publisherInfo',['publisher' => $publisher, 'newses' => $newses, 'namespaces' => $namespaces, 'thumbnailURLs' => $thumbnailURLs]);
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

    public function parserPreview (Request $request)
    {
      //init link and thumbnail url
      $url = $request->link;
      $publishDateTime = $request->publishDateTime;
      $publisher = NewsPublisher::find($request->publisher);
      if (isset($request->thumbnailURL)) $thumbnailURL = $request->thumbnailURL; else $thumbnailURL = null;

      //download webpage
      $page = new Dom();
      $page = $page->loadFromFile($url);

      //get title
      $title = $page->find('.story-body__h1')[0];

      //get content
      $contentGroup = $page->find('p');

      $contents = array();
      foreach ($contentGroup as $content)
      {
        //remove unnessary words
        if (strpos($content->text, " ") == false) continue;
        if (strcmp($content->text, "Share this with") == 0 || strcmp($content->text, "Copy this link") == 0) continue;

        array_push($contents,$content->text);
      }

      $result = array();
      $result['title'] = $title->text;
      $result['thumbnail'] = $thumbnailURL;
      $result['publisher'] = $publisher;
      $result['publishDateTime'] = $publishDateTime;
      $result['content'] = $contents;

      return view('news.parser.preview',['data' => $result]);
    }
}
