@extends('adminlte::page')

@section('title', 'Auto Replies')

@section('content_header')
   @stop

@section('content')
    <div class="container-gallery">
    <div class="header-gallery">
        <h3> Auto Replies </h3>
    </div>
    <div class="col-xs-12">
        <div class="card-body table-responsive">
          <table class="datatable table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
            <thead>
        <tr>
            <th>ID</th>
            <th>Request</th>
            <th>Response</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($shows as $show)
    <tr>
        <td>{{$show->id}} </td>
        <td>{{$show->requests}}</td>
        <td>{{$show->response}}</td>
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
          scrollY:        '50vh',
          scrollCollapse: true,
          paging:         false,
       });
        $('#myTable tbody').on( 'dblclick', 'tr', function () {
        self.Editor.edit( this );
        } );
		    $('input[aria-controls="myTable"]').addClass("search-table");
		    $('select[aria-controls="myTable"]').addClass("search-table");
		});
      </script>
@stop