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
	  <thead style="background-color:#389af0; color:#f0f0f0;">
	    <tr>
	      <th style="width: 30px">No.</th>
	      <th style="width: auto">Nama Project</th>
	      <th style="width: auto">Nama Form</th>
	      <th style="width: 100px">Jumlah Data</th>
	      <th style="width: 40px"></th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i = 1; ?>
		@foreach($formlist as $row)
	  		<?php $jml = App\models\Formmodel::getCount($row->id);?>
	        <tr>
	          <td style="width: 30px">{{$i}}</td>
	          <td style="width: auto">{{$row->project->name}}</td>
	          <td style="width: auto">{{$row->name}}</td>
	          <td style="width: 100px">{{$jml}}</td>
	          <td style="width: 40px">
	          	<a href="{{URL::route('reportdetail', $row->id )}}" onclick="event.preventDefault(); document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title=""> <i class="fa  fa-list-ul"></i> &nbsp; View Detail</a>
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