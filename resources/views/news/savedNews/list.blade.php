@extends('template')

@section('title',"Saved News")

@section('content')
  <div class = "row">
    @if (count($newses) > 0)
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
            @if (isset($news->NewsThumbnailLink))
              <img class = "card-img-top" src = "{{$news->NewsThumbnailLink}}" alt = "{{$news->NewsHeader}}">
            @endif
            <div class = "card-block">
              <h4 class = "card-title">{{$news->NewsHeader}}</h4>
              <p>Publication Date : {{$news->PublishcationDate}}</p>
              <p>{{$news->NewsLink}}</p>
              <form action = "/news/parser" method="post">
                @if (isset($news->NewsThumbnailLink))
                  <input type = "hidden" name = "thumbnailURL" value = "{{$news->NewsThumbnailLink}}">
                @endif
                <input type = "hidden" name = "link" value = "{{$news->NewsLink}}">
                <input type = "hidden" name = "publisher" value = "{{$news->PublisherID}}">
                <input type = "hidden" name = "publishDateTime" value = "{{date('d M Y',strtotime($news->pubDate))}}">
                <input type = "hidden" name = "isSave" value = "1">
                {{csrf_field()}}
                <input type = "submit" class = "btn btn-info" value = "Read More">
                <a href = "/news/delete/{{$news->id}}" class = "btn btn-danger">Delete This News</a>
              </form>
            </div>
          </div>
        </div>
        @if($loop->iteration % 2 == 1)
          </div>
        @endif
      @endforeach
    @else
      <h3>There's no saved news right now.</h3>
      <a href = "/" class = "btn btn-primary pull-right">Back to homepage</a>
    @endif
  </div>
@endsection
