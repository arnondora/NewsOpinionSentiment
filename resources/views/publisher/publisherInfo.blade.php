@extends('template')

@section('title',"Publisher Information")

@section('content')
  <div class = "row">
    <div class = "row">
      <div class = "col-xs-1">Name : </div>
      <div class=  "col-xs-11">{{$publisher->name}}</div>
    </div>
    <div class =" row">
      <div class = "col-xs-1">URL : </div>
      <div class = "col-xs-11">{{$publisher->url}}</div>
    </div>
  </div>

  <div style = "margin-top:20px;" class = "row">
    <h3>News From RSS Feed</h3>

    @foreach ($newses as $news)
      @if($loop->iteration % 2 == 0)
        <div class = "row" style = "margin-top:20px;">
      @endif

      @if($loop->iteration == 1)
        <div class = "col-md-12">
      @else
        <div class = "col-md-6">
      @endif
        <div class = "card">
          @if ($loop->iteration-1 < count($thumbnailURLs))
            <img class = "card-img-top" src = "{{$thumbnailURLs[$loop->iteration-1]}}" alt = "{{$news->title}}">
          @endif
          <div class = "card-block">
            <h4 class = "card-title">{{$news->title}}</h4>
            <p>Publication Date : {{date('d M Y',strtotime($news->pubDate))}}</p>
            <p>{{$news->link}}</p>
            <form action = "/news/parser" method="post">
              @if (isset($thumbnailURLs[$loop->iteration-1]))
                <input type = "hidden" name = "thumbnailURL" value = "{{$thumbnailURLs[$loop->iteration-1]}}">
              @endif
              <input type = "hidden" name = "link" value = "{{$news->link}}">
              <input type = "hidden" name = "publisher" value = "{{$publisher->id}}">
              <input type = "hidden" name = "publishDateTime" value = "{{date('d M Y',strtotime($news->pubDate))}}">
              {{csrf_field()}}
              <a href = "{{$news->link}}" class = "btn btn-primary">Go to orginal site</a>
              <input type = "submit" class = "btn btn-info" value = "Parse This News">
            </form>
          </div>
        </div>
      </div>
      @if($loop->iteration % 2 == 1)
        </div>
      @endif
    @endforeach

  </div>
@endsection
