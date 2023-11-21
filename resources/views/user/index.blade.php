@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>User</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
		<li class="active"><i class="fa fa-user"></i> User</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div id="collapse4" class="body body-content">
	<p>
		<button class="btn btn-success" id="btn-input"><i class="fa fa-plus"></i> &nbsp; Input Baru</button>
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama</th>
	      <th>Email</th>
	      <th>No. Telp</th>
	      <th>Tipe</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($userlist as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->name}}</td>
	          <td>{{$row->email}}</td>
	          <td>{{$row->phone}}</td>
	          <td>{{$row->tipe}}</td>
	          <td style="width: 140px">
	          	<a href="{{URL::route('useredit', $row->id )}}" class="btn btn-primary btn-xs" data-original-title="" title="" style="width: 50px"><i class="fa fa-edit"></i> Edit
	          	</a>
	          	<a href="#" onclick="hapus({{$row->id}});" class="btn btn-danger btn-xs" data-original-title="" title="" style="width: 50px"><i class="fa fa-trash"></i> Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('userdestroy', $row->id) }}" method="POST" style="display: none;">
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
		window.location = "{{URL::route('register')}}";
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