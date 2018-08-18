@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   @stop

@section('content')
    <div class="container-gallery">
    <div class="header-gallery">
        <h3> Event Logs </h3>
    </div>
    <div class="col-xs-12">
        <div class="card-body table-responsive">
          <table class="datatable table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
            <thead>
        <tr>
            <th>ID</th>
            <th>Event</th>
            <th>Username</th>
            <th>Request</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($shows as $show)
    <tr>
        <td>{{$show->id}} </td>
        <td>{{$show->event}}</td>
        <td>{{$show->username}}</td>
        <td id="request{{$show->id}}">{{$show->request}}</td>
        <td><a class="insert" data-id="{{$show->id}}"><i class="fa fa-plus" aria-hidden="true"></i></a> <a href="/admin/gallery/delete/{{$show->id}}" data-id="{{$show->id}}" class="delete"><i class="fa fa-minus" aria-hidden="true"></i></a></td>
    </tr>
    @endforeach
          </tbody>
        </table>
        </div>
      </div>
  </div>
@stop

@section('css')
    <link href="{{ asset('/css/admin_custom.css') }}" rel="stylesheet">
@stop

@section('js')
     <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js')  }}"></script>
     <script>
       $(document).ready(function(){
       var table = $('#myTable').DataTable({
          "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            }
        ],
          scrollY:        '50vh',
          scrollCollapse: true,
          paging:         false,
       });

        $('#myTable tbody').on('click','.delete', function(e){
          e.preventDefault();
           var confirm  = window.confirm("Are you sure to delete this log ? \n press OK button to delete or close to reject your decision");
           var base_url = window.location.origin; 
           if (confirm == true) {
            var id = ($(this).attr('data-id'));
            table
                .row( $(this).parents('tr') )
                .remove()
                .draw();
              $.ajax({
                  type   : "POST",
                    url    : base_url + "/admin/delete/" + id,
                    // url    : base_url + "/wibubot" +  "/public/admin/delete/" + id,
                    data   : {"_method": 'DELETE',},
                    success : function(){
                   }
              });
            }
         });

        $('#myTable tbody').on('click','.insert', function(e){
          e.preventDefault();
           var confirm  = window.confirm("Are you sure to insert this log to auto replies table  ? \n press OK button to delete or close to reject your decision");
           var base_url = window.location.origin; 
           var id = ($(this).attr('data-id'));
           var request = $('#request' + id).html();
            if (confirm == true) {
            var id = ($(this).attr('data-id'));
             table
                    .row( $(this).parents('tr') )
                    .remove()
                    .draw();
                  }
              $.ajax({
                  type   : "POST",
                    url    : base_url + "/admin/insert/" + id,
                    // url    :  "http://localhost/wibubot/public/admin/insert/"+ id,
                    data   : {"request": request,
                              "_method": 'PUT'}, 
                    success : function(insert){
                  }
              });
         });



		    $('input[aria-controls="myTable"]').addClass("search-table");
		    $('select[aria-controls="myTable"]').addClass("search-table");
		});
      </script>
@stop