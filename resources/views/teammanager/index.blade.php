@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>Team Name :<small> {{$team->name}}</small></small></h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{route('teamlist')}}"><i class="fa fa-users"></i> Team</a></li>
		<li class="active"><i class="fa fa-eye"></i> Manager {{$team->name}}</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<p>
	<form id="create-form" action="{{ route('tmanagercreate', $team->id) }}" method="POST">
		{{ csrf_field() }}
		<button class="btn btn-success" id="btn-input">Input Baru</button>
	</form>
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Idx</th>
	      <th>Nama</th>
	      <th>Tipe</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($team->member as $row)
			@if($row->user->tipe == 'manager' && $row->user->deleted == 'Tidak' && $row->deleted == 'Tidak')
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->user->name}}</td>
	          <td>{{$row->user->tipe}}</td>
	          <td>
	          	<a href="{{URL::route('tmanageredit', [$row->id, $team->id] )}}" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title="">Edit</a>
                <form id="edit-form{{$row->id}}" action="{{ route('tmanageredit', [$row->id, $team->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          	<a href="#" onclick="hapus({{$row->id}});" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('tmanagerdestroy', [$row->id, $team->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          </td>
	        </tr>
	        @endif
		@endforeach
	  </tbody>
	</table>
</div>

@endsection

@section('jscript')
	$('#dataTable').dataTable({
	//         "sDom": "<'pull-right'l>t<'row'<'col-lg-6'f><'col-lg-6'p>>",
	//         "sPaginationType": "bootstrap",
	//         "oLanguage": {
	//             "sLengthMenu": "Show _MENU_ entries"
	//         }
    });

	$("#btn-input").click(function(){
		window.location = "{{URL::route('tmanagercreate', $team->id)}}";
	});
@endsection
@section('funjscript')
function hapus(id){
    var r = confirm("Hapus Data?");
    if (r == true) {
    	var idform = "#hapus-form"+id;
        $(idform).submit();
    } else {
        
    }
}
@endsection