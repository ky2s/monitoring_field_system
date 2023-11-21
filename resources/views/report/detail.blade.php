@extends('layouts.appv2')
@section('header')
<style type="text/css">
	.table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding: 5px;
}
</style>
<div class="col-md-8">
	<h1>Report</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
		<li><a href="{{route('home')}}"><i class="fa fa-copy"></i> Report</a></li>
		<li class="active"><i class="fa fa-list"></i> Detail</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')			

<div class="row">

<div class="col-md-5">
	<button class="btn btn-warning" id="btn-table" style="width :100px"><i class="fa fa-table"></i> Table</button>
	<button class="btn btn-success" id="btn-maps" style="width :100px"><i class="fa fa-map"></i> Maps</button>
	<button class="btn btn-primary" id="btn-stats" style="width :100px"><i class="fa fa-bar-chart"></i> Statisik</button>
</div>

<div class="col-md-7">
<form method="get">
	<div class="col-md-9">
		<!-- #section:plugins/date-time.daterangepicker -->
		<?php 
		if(isset($_GET['users']))
			$userarr = $_GET['users'];
		else
			$userarr = array();

		?>
		<div class="input-group pull-left pilihUser">
			<select class="form-control" type="text" name="users[]" id="users" style="height: 42px" multiple="true" />
			@foreach($listusers as $d)
				<option value="{{$d->id}}"{{in_array($d->id, $userarr)?' selected':''}}>{{$d->name}}</option>
			@endforeach
			</select>
			
		</div>
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-calendar bigger-110"></i>
			</span>

			<input class="form-control" type="text" name="rangedate" id="rangedate" value="" style="height: 42px" />
		</div>
	</div>
	<button type="submit" class="btn btn-success pull-right"><i class="fa fa-refresh"></i> Reload</button>
</form>
</div>
</div>
<div id="collapse4" class="body body-content">
	<div style="overflow: scroll; height: 450px;">
	<table id="dataTable"  class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr >
	      <th nowrap>No.</th>
	      <th nowrap>View</th>
 	      <th nowrap>IMEI</th>
<!--	      <th nowrap>UID</th>
	      <th nowrap>Latitude</th>
	      <th nowrap>Longitude</th> -->
	      <th nowrap>Waktu Submit</th>
	      <th nowrap>Email</th>
	      <th nowrap>Kode</th>
	      @foreach($form->detail as $d)
			@if(($d->tipe->cfield == 'Y' || $d->tipe->isgroup == 'Y') && $d->group_id =='')
				@if($d->tipe->isgroup == 'Y')
					@foreach($d->group as $f)
						@if($f->tipe->cfield == 'Y')
							<th nowrap>
								{{$d->label}}##{{$f->label}}
							</th>
						@endif
					@endforeach
				@else
					<th nowrap>{{$d->label}}</th>
				@endif
			@endif
	      @endforeach
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	$kal = isset($_GET['page'])?$_GET['page']:1;
	  	$i = (($kal-1)*20)+1;

	  	?>
	  	@foreach($data as $d)
	  	<tr>
	  		<td nowrap>{{$i}}</td>
	  		<td nowrap><a href="{{ route('reportdata', [$id, $d->id]) }}" target="_blank" class="btn btn-sm btn-primary">View Data <i class="fa fa fa-arrow-right"></i></a></td>
 	  		<td nowrap>{{$d->imei}}</td>
<!--	  		<td nowrap>{{$d->uid}}</td>
	  		<td nowrap>{{$d->latitude}}</td>
	  		<td nowrap>{{$d->longitude}}</td> -->
	  		<td nowrap>{{$d->waktuisi}}</td>
	  		<td nowrap>{{$d->email}}</td>
	  		<td nowrap>{{$d->name}}</td>
			@foreach($form->detail as $r)
				@if(($r->tipe->cfield == 'Y' || $r->tipe->isgroup == 'Y') && $r->group_id =='')
					@if($r->tipe->isgroup == 'Y')
						@foreach($r->group as $v)
					  		@if($v->tipe->id!=7)
					  		<?php $namefield = "f".$v->id; ?>
							<td nowrap>
								@if($v->tipe->ismedia=='N')
									@if(substr($d->{$namefield}, 0, 1) == '[')
									<?php $arrsearch = array('[', ']') ?>
									{{str_replace(['[', ']'],'', $d->{$namefield}) }}
									@else
										{{$d->{$namefield} }}
									@endif

								@else
									@if($d->{$namefield})
									<span class="icontainer">
									  	<a href="{{ $d->{$namefield} }}" target="_blank"><img src="{{ $d->{$namefield} }}" width="50px" height="50px"></a>
										<img height="200" class="manImg" src="{{ $d->{$namefield} }}">
									</span>
									@endif
								@endif
							</td>
							@endif
						@endforeach
					@else
			  		<?php $namefield = "f".$r->id; ?>
						<td nowrap>
							@if($r->tipe->ismedia=='N')
								@if(substr($d->{$namefield}, 0, 1) == '[')
								<?php $arrsearch = array('[', ']') ?>
								{{str_replace(['[', ']'],'', $d->{$namefield}) }}
								@else
									{{$d->{$namefield} }}
								@endif

							@else
								@if($d->{$namefield})
								<span class="icontainer">

								  	<a id="example2" href="{{ $d->{$namefield} }}"><img alt="example1" width="50px" height="50px" src="{{ $d->{$namefield} }}" /></a>


									<img height="200" class="manImg" src="{{ $d->{$namefield} }}">
								</span>
								@endif
							@endif
						</td>
					@endif
				@endif
			@endforeach
	  	</tr>
	  	<?php $i++; ?>
	  	@endforeach
	  </tbody>
	</table>
	</div>
	<div class="pull-right">
	{{ $data->appends(request()->input())->links() }}
	</div>
<p style ="padding-top: 20px;">
	<button class="btn btn-primary" id="btn-excel"><i class="fa fa-list"></i>Export Excel</button>
	<button class="btn btn-success" id="btn-csv"><i class="fa fa-database"></i>Export CSV</button>
	<!-- <button class="btn btn-warning" id="btn-table"><i class="fa fa-cubes"></i>Generate Table</button> -->
</p>

</div>

@endsection

@section('jscript')
	$( "#users" ).select2( {placeholder: "Pilih User", maximumSelectionSize: 6 } );
	$('.input-daterange').datepicker({autoclose:true});
	$('input[name=rangedate]').daterangepicker({
		'applyClass' : 'btn-sm btn-success',
		'cancelClass' : 'btn-sm btn-default',
		'startDate' : '01-01-2018',
		'endDate' : '{{date("d-m-Y")}}',
		locale: {
			applyLabel: 'Apply',
			cancelLabel: 'Cancel',
        	format: 'DD-MM-YYYY',
		}
	})
	.prev().on(ace.click_event, function(){
		$(this).next().focus();
	});
	$('#xdataTable').dataTable({
  		"iDisplayLength": 10,
		"columnDefs": [
            {
                "targets": [
                ],
                "visible": false,
                "searchable": true
            }
        ],
		dom: 'Bfrtip',
		buttons: [
			{
                extend: 'excelHtml5',
                title: 'Data export {{$form->name}} - {{date("dmYHis")}}',
                exportOptions: {
                    columns: [
                    		 ]
                }
            },
            {
                extend: 'csv',
                title: 'Data export {{$form->name}} - {{date("dmYHis")}}',
                exportOptions: {
                    columns: [
                    		 ]
                }
            }
		],
		exportOptions: {
		  rows: ':visible'
		},
		scrollY:        "450px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 1
        }
    });
    $("#btn-maps").click(function(){
		var str = "{{$url_map}}";
		var res = str.replace("&amp;", "&");
		window.location = res;
	});
    $("#btn-stats").click(function(){
		window.location = "{{URL::route('reportstats', $id)}}";
	});
    $("#btn-table").click(function(){
	    window.location = "{{URL::route('reportdetail', $id)}}";
  	});
    $("#btn-excel").click(function(){
	    window.location = "{{URL::route('reportdetailexcel', [$id, 'rangedate' => isset($_GET['rangedate'])?$_GET['rangedate']:''])}}";
  	});
    $("#btn-csv").click(function(){
	    window.location = "{{URL::route('reportdetailcsv', [$id, 'rangedate' => isset($_GET['rangedate'])?$_GET['rangedate']:''])}}";
  	});
  	$("#rangedate").val("{{isset($_GET['rangedate'])?$_GET['rangedate']:''}}");

		$(document).ready(function() {
			/*
			*   Examples - images
			*/

			$("a#example1").fancybox();

			$("a#example2").fancybox({
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});

			$("a#example3").fancybox({
				'transitionIn'	: 'none',
				'transitionOut'	: 'none'	
			});

			$("a#example4").fancybox({
				'opacity'		: true,
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'none'
			});

			$("a#example5").fancybox();

			$("a#example6").fancybox({
				'titlePosition'		: 'outside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9
			});

			$("a#example7").fancybox({
				'titlePosition'	: 'inside'
			});

			$("a#example8").fancybox({
				'titlePosition'	: 'over'
			});



			$("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			$("#various2").fancybox();

			$("#various3").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			$("#various4").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});

@endsection
@section('addstyle')

@endsection
