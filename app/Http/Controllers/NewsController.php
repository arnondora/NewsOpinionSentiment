<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPHtmlParser\Dom;

use App\NewsPublisher;

use App\News;

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

    public function newSamplePublisher ()
    {

      $publishers = [
        ["name" => "BBC News - News Front Page", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/front_page/rss.xml"],
        ["name" => "BBC News - World", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/world/rss.xml"],
        ["name" => "BBC News - UK", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/uk/rss.xml"],
        ["name" => "BBC News - England", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/england/rss.xml"],
        ["name" => "BBC News - Northern Ireland", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/northern_ireland/rss.xml"],
        ["name" => "BBC News - Scotland", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/scotland/rss.xml"],
        ["name" => "BBC News - Wales", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/wales/rss.xml"],
        ["name" => "BBC News - Business", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/business/rss.xml"],
        ["name" => "BBC News - Politics", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/uk_politics/rss.xml"],
        ["name" => "BBC News - Health", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/health/rss.xml"],
        ["name" => "BBC News - Education", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/education/rss.xml"],
        ["name" => "BBC News - Science/Nature", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/sci/tech/rss.xml"],
        ["name" => "BBC News - Technology", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/technology/rss.xml"],
        ["name" => "BBC News - Entertainment", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/entertainment/rss.xml"],
        ["name" => "BBC News - Magazine", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/magazine/rss.xml"],
        ["name" => "BBC News - Have Your Say", "link" => "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/talking_point/rss.xml"],
        ["name" => "BBC News - Latest Published Stories", "link" => "http://feeds.bbci.co.uk/news/system/latest_published_content/rss.xml"],

      ];

      foreach ($publishers as $publisher)
      {
        $publisherObj = new NewsPublisher();
        $publisherObj->name = $publisher['name'];
        $publisherObj->url = $publisher['link'];

        $publisherObj->save();
      }

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

      //hashtag analysis
      $hashtags = getHashtags($url);

      //retriving tweet
      $tweets = extractTweetStatuses(searchTweet($hashtags->hashtags[0]));

      //sentiment for each text
      $sentimentObjects = array();

      foreach ($tweets as $tweet)
      {
        array_push($sentimentObjects,getSentimentResult(extractTweetText($tweet)));
      }

      //sentiment value
      $sentimentFeelings = array();
      foreach ($sentimentObjects as $sentimentObject)
      {
        if (strcmp(getSentimentPolarity($sentimentObject), "positive") == 0)
        {
          $feeling['color'] = "#4CAF50";
          $feeling['symbolClass'] = "fa-thumbs-up";
        }
        elseif (strcmp(getSentimentPolarity($sentimentObject), "negative") == 0)
        {
          $feeling['color'] = "#FBC02D";
          $feeling['symbolClass'] = "fa-meh-o";
        }
        else {
          $feeling['color'] = "#F44336";
          $feeling['symbolClass'] = "fa-thumbs-down";
        }

        array_push($sentimentFeelings,$feeling);
      }

      $result = array();
      $result['title'] = $title->text;
      $result['url'] = $url;
      $result['thumbnail'] = $thumbnailURL;
      $result['publisher'] = $publisher;
      $result['publishDateTime'] = $publishDateTime;
      $result['hashtags'] = $hashtags->hashtags;
      $result['tweets'] = $tweets;
      $result['tweets_sentiment'] = $sentimentObjects;
      $result['tweet_feeling'] = $sentimentFeelings;
      $result['content'] = $contents;

      return view('news.parser.preview',['data' => $result]);
    }

    public function addNews (Request $request)
    {
      $title = $request->header;
      $body = $request->body;
      $publishDate = $request->publishDate;
      $link = $request->link;
      $publisher = NewsPublisher::find($request->publisherID);
      $thumbnail = $request->thumbnailURL;

      //create new News
      $news = new News();

      //assign value to news
      $news->NewsHeader = $title;
      $news->NewsBody = $body;
      $news->PublishcationDate = $publishDate;
      $news->NewsLink = $link;
      $news->NewsThumbnailLink = $thumbnail;
      $news->PublisherID = $request->publisherID;

      $news->save();

      return redirect('/publisher')->with(["success" => "Add new news success"]);
    }

    public function showSavedNews ()
    {
        return view('news.savedNews.list',["newses" => News::all()]);
    }
}
