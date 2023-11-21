@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Form Detail -- {{$form->label}}</h3> 
  </legend>
  <ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
	  <li><a href="{{route('projectlist')}}">Project</a></li>
	  <li><a href="{{route('formlist', $form->form->project_id)}}">Form</a></li>
	  <li><a href="{{route('formdetaillist', $form->form_id)}}">Form Detail</a></li>
	  <li class="active">List</li>
  </ol>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<p>
	<form id="create-form" action="{{ route('formgroupcreate', $form->id) }}" method="POST">
		{{ csrf_field() }}
		<button class="btn btn-success" id="btn-input">Input Baru</button>
	</form>
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Label</th>
	      <th>Mandatory</th>
	      <th>Position</th>
	      <th>Tipe</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($form->group as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->label}}</td>
	          <td>{{$row->mandatory=='Y'?'Ya':'Tidak'}}</td>
	          <td>{{$row->position}}</td>
	          <td>{{$row->tipe->name}}</td>
	          <td>
	          	<a href="{{URL::route('formgroupedit', [$row->id, $form->id] )}}" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title="">Edit</a>
                <form id="edit-form{{$row->id}}" action="{{ route('formgroupedit', [$row->id, $form->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          	<a href="{{URL::route('formgroupdestroy', [$row->id, $form->id] )}}" onclick="event.preventDefault();
                             document.getElementById('hapus-form{{$row->id}}').submit();" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('formgroupdestroy', [$row->id, $form->id]) }}" method="POST" style="display: none;">
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
		window.location = "{{URL::route('formcreate', $form->id)}}";
	});
@endsection