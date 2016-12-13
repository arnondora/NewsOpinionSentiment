@if (count($newses) > 0)
  @foreach ($newses as $news)
    @if ($loop->iteration % 2 == 1)<div class = "row">@endif
    <div class = "col-md-6">
      <div class="card">
        <img class="card-img-top" src="{{$news->NewsThumbnailLink}}" alt="Card image cap">
        <div class="card-block">
          <h4 class="card-title">{{$news->NewsHeader}}</h4>
          <h5 class = "text-muted">{{App\NewsPublisher::find($news->PublisherID)->name}}</h5>
          <p>{{$news->NewsLink}}</p>
          <form action = "/news/parser" method="post">
            @if (isset($news->NewsThumbnailLink))
              <input type = "hidden" name = "thumbnailURL" value = "{{$news->NewsThumbnailLink}}">
            @endif
            <input type = "hidden" name = "link" value = "{{$news->NewsLink}}">
            <input type = "hidden" name = "publisher" value = "{{$news->PublisherID}}">
            <input type = "hidden" name = "publishDateTime" value = "{{$news->PublishcationDate}}">
            <input type = "hidden" name = "isSave" value = "1">
            {{csrf_field()}}
            <input type = "submit" class = "btn btn-info" value = "Read More">
          </form>
        </div>
      </div>
    </div>
    @if ($loop->iteration % 2 == 0)</div>@endif
  @endforeach
@else
  <h4>There's no news that match your criteria. You can save news by go to this <a href = "/publisher">page</a></h4>
@endif
