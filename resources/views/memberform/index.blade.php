@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Member Form</h3> 
  </legend>
  <ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
	  <li>Member Form</li>
	  <li class="active">List</li>
  </ol>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<!-- <p>
		<button class="btn btn-success" id="btn-input">Input Baru</button>
	</p> -->
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($form as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->name}}</td>
	          <td>
	          	<a href="{{URL::route('formmembercreate', $row->id )}}" class="btn btn-success btn-xs" data-original-title="" title="">Isi Data</a>
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
		window.location = "{{URL::route('projectcreate')}}";
	});
@endsection