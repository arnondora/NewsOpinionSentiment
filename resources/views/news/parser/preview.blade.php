@extends('template')

@section('title',$data['title'])

@section('content')
  <div class = "row"><h5 class = "text-muted">From : {{$data['publisher']->name}}</h5></div>
  <div class = "row"><h5 class = "text-muted">Updated : {{$data['publishDateTime']}}</h5></div>

  <div class = "row">
    <form method = "post" action = "/news/add">
      <input type = "hidden" name = "header" value = "{{$data['title']}}">
      <input type = "hidden" name = "publishDate" value = "{{$data['publishDateTime']}}">
      <input type = "hidden" name = "link" value = "{{$data['url']}}">
      <input type = "hidden" name = "publisherID" value = "{{$data['publisher']->id}}">
      <input type = "hidden" name = "thumbnailURL" value = "{{$data['thumbnail']}}">
      <input type = "hidden" name = "body" value = "
        @foreach ($data['content'] as $content)
          {{$content}}
        @endforeach
      ">
      {{csrf_field()}}
      @if ($data['isSave'] == 0) <input type = "submit" class = "btn btn-success pull-right" value = "Save This News">
      @else <input type = "submit" class = "btn btn-success pull-right" disabled="true" value = "Saved">
      @endif
    </form>
  </div>

  @if(isset($data['thumbnail']))
    <div class = "row" style = "margin-top:20px;">
      <center><img src="{{$data['thumbnail']}}" style = "width:50%; height:auto;" class = "img-responsive" alt="{{$data['title']}}"></center>
    </div>
  @endif

  <div class = "row" style = "margin-top:20px" for = "content">
    <p class = "text-justify">
      @foreach ($data['content'] as $content)
        {{$content}}
      @endforeach
    </p>
  </div>

  <div class = "row pull-right" for = "source">
    <small class = "text-muted">Source : {{$data['publisher']->name}}</small>
  </div>

  <div class = "row" style = "margin-top:20px;">
    <h3>Tags</h3>
    <ul class = 'tags'>
      @foreach ($data['hashtags'] as $hashtag)
        <a href = "https://www.twitter.com/{{$hashtag}}"><li class = "tag">{{$hashtag}}</li></a>
      @endforeach
    </ul>
  </div>

  <div class = "row" style = "margin-top:20px">
    <h3>Related Tweet</h3>

    <div class = "row" for = "tweet">
      @foreach ($data['tweets'] as $tweet)
        <div class = "row" for = "{{extractTweetText($tweet)}}">
          <div class = "col-xs-1"><img class = "img-responsive" src = "{{extractTweetProfilePictureUrl(extractTweetOwner($tweet))}}"></div>
          <div class = "col-xs-11">
            <div class = "row"><a href = "{{extractTweetProfileLink(extractTweetOwner($tweet))}}"><strong>{{extractTweetProfileScreenName(extractTweetOwner($tweet))}}</strong></a></div>
            <div class = "row" style = "color:{{$data['tweet_feeling'][$loop->index]['color']}}">
              <span class = "fa {{$data['tweet_feeling'][$loop->index]['symbolClass']}}"></span>
              {{round(getSentimentPolarityConfidence($data['tweets_sentiment'][$loop->index]) * 100, 2)}}%
            </div>
            <div class = "row"><p>{{extractTweetText($tweet)}}</p></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
