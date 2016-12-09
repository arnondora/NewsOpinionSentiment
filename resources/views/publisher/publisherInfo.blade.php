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
          <img class = "card-img-top" src = "{{$news->children($namespaces['media'])->thumbnail->attributes()->url}}" alt = "{{$news->title}}">
          <div class = "card-block">
            <h4 class = "card-title">{{$news->title}}</h4>
            <p>Publication Date : {{date('d M Y',strtotime($news->pubDate))}}</p>
            <p>{{$news->link}}</p>
            <a href = "{{$news->link}}" class = "btn btn-primary">Go to orginal site</a>
            <a href = "#" class = "btn btn-info">Parse This News</a>
          </div>
        </div>
      </div>
      @if($loop->iteration % 2 == 1)
        </div>
      @endif
    @endforeach

  </div>
@endsection
