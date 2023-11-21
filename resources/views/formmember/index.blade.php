@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Member Team -- {{$team->name}}</h3> 
  </legend>
  <ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
	  <li>Team</li>
	  <li class="active">List</li>
  </ol>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<p>
	<form id="create-form" action="{{ route('tmembercreate', $team->id) }}" method="POST">
		{{ csrf_field() }}
		<button class="btn btn-success" id="btn-input">Input Baru</button>
	</form>
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama</th>
	      <th>Tipe</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($team->member as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->user->name}}</td>
	          <td>{{$row->user->tipe}}</td>
	          <td>
	          	<a href="{{URL::route('tmemberedit', [$row->id, $team->id] )}}" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title="">Edit</a>
                <form id="edit-form{{$row->id}}" action="{{ route('tmemberedit', [$row->id, $team->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          	<a href="#" onclick="hapus({{$row->id}});" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('tmemberdestroy', [$row->id, $team->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          </td>
	        </tr>
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
		window.location = "{{URL::route('tmembercreate', $team->id)}}";
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