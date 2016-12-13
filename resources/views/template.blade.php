<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <title>@yield('title') - News Search Engine</title>

    </head>
    <body>
        <div class = "container">
          <div class = "row"><h1>@yield('title')</h1></div>

          @if(isset($status))
            <div class = "row">
              <div class = "alert alert-success" role = "success-alert">
                <strong>Well Done! </strong>{{$status}}
              </div>
            </div>
          @endif

          @yield('content')

          @include('footer')
        </div>
    </body>

    <script src = "/js/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/05d65594f4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>
    @yield('script')
</html>
