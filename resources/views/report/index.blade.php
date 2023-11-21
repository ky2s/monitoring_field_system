@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>Report</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
		<li class="active"><i class="fa fa-copy"></i> Report</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama Project</th>
	      <th>Nama Form</th>
	      <th>Jumlah Data</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i = 1; ?>
		@foreach($formlist as $row)
	  		<?php $jml = App\models\Formmodel::getCount($row->id);?>
	        <tr>
	          <td>{{$i}}</td>
	          <td>{{$row->project->name}}</td>
	          <td>{{$row->name}}</td>
	          <td>{{$jml}}</td>
	          <td>
	          	<a href="{{URL::route('reportdetail', $row->id )}}" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title="">View Detail</a>
                <form id="edit-form{{$row->id}}" action="{{ route('reportdetail', $row->id) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          </td>
	        </tr>
	        <?php $i++; ?>
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
@endsection