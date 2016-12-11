@extends('template')

@section('title',$data['title'])

@section('content')
  <div class = "row"><h5 class = "text-muted">From : {{$data['publisher']->name}}</h5></div>
  <div class = "row"><h5 class = "text-muted">Updated : {{$data['publishDateTime']}}</h5></div>

  @if(isset($data['thumbnail']))
    <div class = "row" style = "margin-top:20px;">
      <center><img src="{{$data['thumbnail']}}" style = "width:50%; height:auto;" class = "img-responsive" alt="{{$data['title']}}"></center>
    </div>
  @endif

  <div class = "row" style = "margin-top:20px" for = "content">
    <p>
      @foreach ($data['content'] as $content)
        {{$content}}
      @endforeach
    </p>
  </div>

  <div class = "row pull-right" for = "source">
    <small class = "text-muted">Source : {{$data['publisher']->name}}</small>
  </div>

  <div class = "row" style = "margin-top:20px;">
    <div class = "col-md-6">
      <h3>Hashtag Analysis</h3>
      <ul>
        @foreach ($data['hashtags'] as $hashtag)
          <li><a href = "https://www.twitter.com/#">{{$hashtag}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>

@endsection
