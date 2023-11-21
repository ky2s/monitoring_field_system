@extends('layouts.appv2')
@section('header')
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
<p>
	<button class="btn btn-primary" id="btn-stats"><i class="fa fa-bar-chart"></i> Statisik</button>
	<button class="btn btn-success" id="btn-maps"><i class="fa fa-map"></i> Maps</button>
	<button class="btn btn-warning" id="btn-table"><i class="fa fa-table"></i> Table</button>
</p>
<div id="collapse4" class="body body-content">
	<table id="dataTable"  class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr >
	      <th nowrap>Id</th>
	      <th nowrap>UID</th>
	      <th nowrap>Latitude</th>
	      <th nowrap>Longitude</th>
	      <th nowrap>Waktuisi</th>
	      <th nowrap>User</th>
	      <?php $a = 6;
	      	$hid = array();
	      	$visib = array();
	      	$vis = array();
	      	$done = array();
	      ?>
	      @foreach($form->detail as $d)
			@if(($d->tipe->cfield == 'Y' || $d->tipe->isgroup == 'Y') && $d->group_id =='')
				@if($d->tipe->isgroup == 'Y')
					@foreach($d->group as $f)
						@if($f->tipe->ismedia=='Y')
							<th nowrap>
								{{$d->label}}##{{$f->label}}
							</th>
							<?php
								$hid[] = $a;
								$a++;
								$visib[] = $a;
							?>
						@endif
						<th nowrap>
							{{$d->label}}##{{$f->label}}
						</th>
						<?php
							$a++;
						?>
					@endforeach
				@else
					@if($d->tipe->ismedia=='Y')
						<th nowrap>{{$d->label}}</th>
						<?php
							$hid[] = $a;
							$a++;
							$visib[] = $a;
						?>
					@endif
					<th nowrap>{{$d->label}}</th>
					<?php
						$a++;
					?>
				@endif
			@endif
	      @endforeach
	      @for($i=0;$i<$a;$i++)
	      	<?php $vis[] = $i; ?>
	      @endfor
	      <?php $vis = array_diff($vis, $visib); ?>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($data as $d)
	  	<tr>
	  		<td nowrap>{{$d->id}}</td>
	  		<td nowrap>{{$d->uid}}</td>
	  		<td nowrap>{{$d->latitude}}</td>
	  		<td nowrap>{{$d->longitude}}</td>
	  		<td nowrap>{{$d->waktuisi}}</td>
	  		<?php $user = App\User::getData($d->user_id);?>
	  		<td nowrap>{{$user?$user->name:''}}</td>
			@foreach($form->detail as $r)
				@if(($r->tipe->cfield == 'Y' || $r->tipe->isgroup == 'Y') && $r->group_id =='')
					@if($r->tipe->isgroup == 'Y')
						@foreach($r->group as $v)
					  		<?php $namefield = "f".$v->id; ?>
							@if($v->tipe->ismedia=='Y')
							<td nowrap>
								{{ Storage::disk('spaces')->url($r->form_id.'/'.$d->{$namefield}) }}
							</td>
							@endif
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
									  	<a href="{{ Storage::disk('spaces')->url($v->form_id.'/'.$d->{$namefield}) }}" target="_blank">Display Image</a>
										<img height="200" class="manImg" src="{{ Storage::disk('spaces')->url($v->form_id.'/'.$d->{$namefield}) }}">
									</span>
									@endif
								@endif
							</td>
						@endforeach
					@else
			  		<?php $namefield = "f".$r->id; ?>
						@if($r->tipe->ismedia=='Y')
						<td nowrap>
							{{ Storage::disk('spaces')->url($r->form_id.'/'.$d->{$namefield}) }}
						</td>
						@endif
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
								  	<a href="{{ Storage::disk('spaces')->url($r->form_id.'/'.$d->{$namefield}) }}" target="_blank">Display Image</a>
									<img height="200" class="manImg" src="{{ Storage::disk('spaces')->url($r->form_id.'/'.$d->{$namefield}) }}">
								</span>
								@endif
							@endif
						</td>
					@endif
				@endif
			@endforeach
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
</div>

@endsection

@section('jscript')
	$('#dataTable').dataTable({
  		"iDisplayLength": 10,
		"columnDefs": [
            {
                "targets": [
                	@foreach($hid as $h)
                		{{$h}},
                	@endforeach
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
			                    @foreach($vis as $h)
			                		{{$h}},
			                	@endforeach
                    		 ]
                }
            },
            {
                extend: 'csv',
                title: 'Data export {{$form->name}} - {{date("dmYHis")}}',
                exportOptions: {
                    columns: [
			                    @foreach($vis as $h)
			                		{{$h}},
			                	@endforeach
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
		window.location = "{{URL::route('reportmaps', $id)}}";
	});
    $("#btn-stats").click(function(){
		window.location = "{{URL::route('reportstats', $id)}}";
	});
    $("#btn-table").click(function(){
	    window.location = "{{URL::route('reportdetail', $id)}}";
  	});
@endsection
@section('addstyle')

@endsection
