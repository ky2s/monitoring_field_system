@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>Report</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{route('home')}}"><i class="fa fa-users"></i> Report</a></li>
		<li class="active"><i class="fa fa-users"></i> Detail</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<p>
	<button class="btn btn-primary" id="btn-stats">Statisik</button>
	<button class="btn btn-success" id="btn-maps">Maps</button>
    <button class="btn btn-warning" id="btn-table">Table</button>
</p>
<div id="collapse4" class="body body-content">
<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Data Inputan</div>
<!--                 <div class="panel-body">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">ID</label>
                        <div class="col-md-6">{{$data[0]->uid}}</div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Latitude</label>
                        <div class="col-md-6">{{$data[0]->latitude}}</div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Longitude</label>
                        <div class="col-md-6">{{$data[0]->longitude}}</div>
                    </div>
                </div> -->
                <div class="panel-body">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Waktuisi</label>
                        <div class="col-md-6">{{$data[0]->waktuisi}}</div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">User</label>
				  		<?php $user = App\User::getData($data[0]->user_id);?>
                        <div class="col-md-6">{{$user?$user->name:''}}</div>
                    </div>
                </div>
	 	      	@foreach($form->detail as $d)
				@if($d->tipe->cfield == 'Y')
					<?php $namefield = "f".$d->id; ?>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">{{$d->label}}</label>
                        <div class="col-md-6">
                        	@if($d->tipe->ismedia=='N')
                        		{{$data[0]->{$namefield} }}
                        	@else
                        		@if($data[0]->{$namefield})
                        		<span class="icontainer">
								  	<a href="{{ $data[0]->{$namefield} }}" target="_blank">Display Image</a>
									<img height="200" class="manImg" src="{{ $data[0]->{$namefield} }}">
								</span>
	                        	@endif
                        	@endif

                        </div>
                    </div>
                </div>
                @endif
		      	@endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@section('jscript')


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