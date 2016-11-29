<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <title>Home - News Search Engine</title>

    </head>
    <body>
        <div class = "container">
          <div class = "row"><h1>News Search Engine</h1></div>

          <div class = "row">
            <form type = "post">
              <div class = "form-group">
                <label>Search Keyword</label>
                <input type="text" class = "form-control" name="keyword" id = "searchkeyword" autofocus>
              </div>
            </form>
          </div>

          <div class = "row">
            <h2 id = "caption">Featured News</h2>
          </div>

          <div class = "row" for = "content" id ="feature">
            {{-- Feature News Goes Here! --}}
          </div>

        </div>

        @include('footer')
    </body>

    <script src = "/js/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/05d65594f4.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
    <script type="text/javascript">
      function getFeatureNews ()
      {
        $.ajax({
          type: 'POST',
          url: "/news/feature",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          dataType: "text",
          success: function(resultData)
          {
            $('#caption').text("Featured News");
            $('#feature').html(resultData);
          }
        });
      }

      $(document).ready(function(){
        getFeatureNews();
        $('#searchkeyword').on('input propertychange paste', function() {
          if ($('#searchkeyword').val() != "")
          {
            $('#caption').text("Search Result for " + $('#searchkeyword').val());
            $('#feature').html("");
          }
          else
          {
            getFeatureNews();
          }
        });
      });
    </script>
</html>
