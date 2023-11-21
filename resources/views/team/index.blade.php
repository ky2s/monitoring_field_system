@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>Team</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
		<li class="active"><i class="fa fa-users"></i> Team</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<p>
		@if(Auth::user()->tipe == 'admin')
		<button class="btn btn-success" id="btn-input"><i class="fa fa-plus"></i> &nbsp;Input Baru</button>
		@endif
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama</th>
	      <th style="width: 330px">&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($teamlist as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->name}}</td>
	          <td>
	          	<a href="{{URL::route('tmemberlist', $row->id )}}" class="btn btn-success btn-xs" data-original-title="" title="" style="width: 85px">({{$row->countmember($row->id)}}) Member</a>
	          	<a href="{{URL::route('tmanagerlist', $row->id )}}" class="btn btn-success btn-xs" data-original-title="" title="" style="width: 85px">({{$row->countmanager($row->id)}})Manager</a>
				@if(Auth::user()->tipe == 'admin')

	          	<a href="{{URL::route('teamedit', $row->id )}}" class="btn btn-primary btn-xs" data-original-title="" title="" style="width: 50px"><i class="fa fa-edit"></i>&nbsp; Edit</a>
	          	<a href="#" onclick="hapus({{$row->id}});" class="btn btn-danger btn-xs" data-original-title="" title="" style="width: 50px"><i class="fa fa-trash"></i>&nbsp; Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('teamdestroy', $row->id) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 

                @endif
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
		window.location = "{{URL::route('teamcreate')}}";
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