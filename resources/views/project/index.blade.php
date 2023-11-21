@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>Project</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-users"></i> Project</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<p>
		<button class="btn btn-success" id="btn-input">Input Baru</button>
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama</th>
	      <th>Keterangan</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($projectlist as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->name}}</td>
	          <td>
	          	<?php $i = 0; ?>
	          	@foreach($row->formr as $p)
	          		<?php $i++; ?>
	          	@endforeach
	          	Jumlah Form {{$i}}</td>
	          <!-- <td>{{$row->publish=='Y'?'Publish':'Draft'}}</td> -->
	          <td>
	          	<a href="{{URL::route('formlist', $row->id )}}" class="btn btn-success btn-xs" data-original-title="" title="">List Form</a>
	          	<a href="{{URL::route('projectedit', $row->id )}}" class="btn btn-primary btn-xs" data-original-title="" title="">Edit</a>
	          	<a href="#" onclick="hapus({{$row->id}});" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('projectdestroy', $row->id) }}" method="POST" style="display: none;">
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
		window.location = "{{URL::route('projectcreate')}}";
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