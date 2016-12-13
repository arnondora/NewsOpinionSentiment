@extends('template')

@section('title','News Publisher Management')

@section('content')
  <div class = "row">
    <div class = "card card-block">
      <h4 class = "card-title">New News Publisher</h4>
      <form action="/publisher/add" method="post">
        <div class = "form-group">
          <label>Name : </label>
          <input class = "form-control" type="text" name="name" id = "name" value="">
        </div>

        <div class = "form-group">
          <label>RSS URL : </label>
          <input class = "form-control" type="text" name="url" id = "url" value="">
        </div>

        <div class = "form-group">
          {{ csrf_field() }}
          <a href = "/publisher/sample/add" class = "btn btn-info pull-right" style = "color:white; margin-left:10px;">Add Sample Data</a>
          <input class = "btn btn-primary pull-right" id = "submitBtn" type = "submit" disabled="true" value = "Add News Publisher">
        </div>

      </form>
    </div>
  </div>

  @if(count($publishers) > 0)
    <div class = "row">
      <table class = "table table-bordered">
        <tr>
          <td>Name</td>
          <td>URL</td>
          <td>Edit</td>
          <td>Delete</td>
        </tr>
          @foreach ($publishers as $publisher)
            <tr>
              <td><a href = "/publisher/{{$publisher->id}}">{{$publisher->name}}<a></td>
              <td><a href = "{{$publisher->url}}">{{$publisher->url}}</a></td>
              <td><i class="fa fa-pencil" aria-hidden="true"></i></td>
              <td>
                <form action = "/publisher/delete" method = "post">
                  {{csrf_field()}}
                  <input type = "hidden" name = "_method" value = "delete">
                  <input type = "hidden" name = "newsID" value = "{{$publisher->id}}">
                  <button class = "btn btn-danger"><i class = "fa fa-trash"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
      </table>
    </div>
  @else
    <div class = "row"><h2>There's no news publisher right now. You can add with the New button</h2></div>
  @endif

@endsection

@section('script')
  <script type ="text/javascript">
    $(document).ready(function(){

      function validateField ()
      {
        if ($('#name').val() === "" || $('#url').val() === "") {$('#submitBtn').prop('disabled', true);}
        else if ($('#name').val() !== "" && $('url').val() !== "") {$('#submitBtn').prop('disabled', false);}
      }

      $('#name').change(function() {
        validateField();
      });

      $('#url').change(function() {
        validateField();
      });
    });
  </script>
@endsection
