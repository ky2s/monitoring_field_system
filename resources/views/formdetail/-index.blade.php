@extends('layouts.appv2')
@section('header')
<div class="col-md-7">
	<h1>Question List <small>-- {{$form->name}} <small>-- {{$form->project->name}}</small></small></h1>
</div>
<div class="col-md-5">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{route('projectlist')}}"><i class="fa fa-dashboard"></i> Project</a></li>
		<li><a href="{{route('formlist', $form->project->id)}}"><i class="fa fa-dashboard"></i> Form List</a></li>
		<li class="active"><i class="fa fa-pencil-square-o"></i> Form Name</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="side-header">
			<div class="panel-group" id="accordion">
		        <div class="panel panel-default">
		            <div class="panel-heading flat">
		                <h4 class="panel-title">
		                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><b>{{$form->name}}</b> <span class="fa fa-right fa-caret-square-o-down pull-right"></span></a>
		                </h4>
		            </div>
		            <div id="collapseOne" class="panel-collapse collapse in">
		                <div class="panel-body flat">
							<div class="head-side-header">
<!-- 								<label class="label published">Published</label> <br><br>
								<label class="label drafted">Draft</label> <br><br>
								<p><i class="fa fa-comments"></i> 6 Questions</p>
								<p><i class="fa fa-users"></i> 182 Participans</p>
								<span><i class="fa fa-clock-o"></i> Last Published 08 Agustus 2017</span> -->
								<div class="head-side-right">
									<ul class="nav navbar-nav">
										<li class="dropdown">
											<a href="#" class="btn btn-default btn-sm flat btn-action side-right" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
												<i class="fa fa-gear" aria-hidden="true"></i>
											</a>
											<ul class="dropdown-menu dropdown-menu-side-right">
												<li><a href="#"><i class="fa fa-edit"></i> Switch to Draft</a></li>
												<li><a href="#"><i class="fa fa-trash"></i> Delete Project</a></li>
											</ul>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="body-side-header">
								<form>
									<label><small>Name :</small></label>
									<div>	
										<input type="text" value="{{$form->name}}" class="form-control flat" id="basic-url" aria-describedby="basic-addon3" disabled="true">
									</div>

									<label><small>Description :</small></label>
									<div>	
										<textarea disabled="true" name="" id="" cols="30" rows="5" class="form-control flat">{{$form->keterangan}}</textarea>
									</div>
									<br>
									<div>
										<!-- <input type="submit" class="btn btn-default published flat btn-block" value="Publish"> -->
									</div>
								</form>
							</div>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="side-header">
			<div class="panel-group" id="accordion">
		        <div class="panel panel-default panel-question flat">
		            <div class="panel-heading flat">
		                <h4 class="panel-title question-title">
		                    <a data-toggle="collapse" data-parent="#accordion" href="#questionOne"><b>Usia</b> <span class="fa fa-caret-square-o-down pull-right"></span></a>
		                </h4>
		                <div class="panel-title-right pull-right">
		                	<h4><small>Text</small></h4>
		                </div>
		                <div class="qNumber">
		                	<select name="" id="" class="form-control flat">
		                		<option value="">1</option>
		                	</select>
		                </div>
		            </div>
		            <div id="questionOne" class="panel-collapse collapse">
		                <div class="panel-body flat">
							<div class="body-side-header">
								<form>
									<div class="row">
										<div class="col-md-12">
											<label><small>Label :</small></label>
											<div>	
												<input type="text" class="form-control flat" id="basic-url" aria-describedby="basic-addon3">
											</div>

											<label><small>Description :</small></label>
											<div>	
												<textarea name="" id="" cols="30" rows="5" class="form-control flat">
													
												</textarea>
											</div>
										</div>
										<div class="col-md-6">
											<label><small>Kondisi :</small></label>
											<div>
												<select name="" id="" class="form-control flat">
													<option value="">Semua Benar</option>
													<option value="">Salah Satu Benar</option>
												</select>
											</div>
											<label><small>Type :</small></label>
											<div>
												<select name="" id="" class="form-control flat">
													<option value="">Ya</option>
													<option value="">Tidak</option>
												</select>
											</div>
										</div>	
										<div class="col-md-6">
											<label><small>Mandatory :</small></label>
											<div>
												<select name="" id="" class="form-control flat">
													<option value="">Ya</option>
													<option value="">Tidak</option>
												</select>
											</div>
										</div>
										<div class="clearfix"></div> <br>
										<div class="col-md-4">
											<label><small>Pilih Data :</small></label>
											<div>
												<select name="" id="" class="form-control flat">
													<option value="">Ya</option>
													<option value="">Tidak</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<label><small>Operasi :</small></label>
											<div>
												<select name="" id="" class="form-control flat">
													<option value="">Tidak Sama Dengan (!=)</option>
													<option value="">Tidak</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<label><small>Input :</small></label>
											<div>	
												<input type="text" class="form-control flat" id="basic-url" aria-describedby="basic-addon3">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
		            </div>
		        </div>
		        <br><br>
		        <a href="#" class="btn btn-default btn-inverse btn-block flat"><i class="fa fa-plus"></i> Add New Question</a>
		    </div>
		</div>
	</div> <!-- /. col-md-8 -->

</div>
<div id="collapse4" class="body body-content">
	<p>
	<form id="create-form" action="{{ route('formdetailcreate', $form->id) }}" method="POST">
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
		@foreach($form->detail as $row)
			@if($row->group_id == '')
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->label}}</td>
	          <td>{{$row->mandatory=='Y'?'Ya':'Tidak'}}</td>
	          <td>{{$row->position}}</td>
	          <td>{{$row->tipe->name}}</td>
	          <td>
	          	<!-- start rules -->
	          	<a href="{{URL::route('formdetailrule', [$row->id, $form->id] )}}" onclick="event.preventDefault();
                             document.getElementById('rule-form{{$row->id}}').submit();" class="btn btn-warning btn-xs" data-original-title="" title="">Rules</a>
                <form id="rule-form{{$row->id}}" action="{{ route('formdetailrule', [$row->id, $form->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
                <!-- end rules -->
	          	<a href="{{URL::route('formdetailedit', [$row->id, $form->id] )}}" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title="">Edit</a>
                <form id="edit-form{{$row->id}}" action="{{ route('formdetailedit', [$row->id, $form->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          	<a href="{{URL::route('formdetaildestroy', [$row->id, $form->id] )}}" onclick="event.preventDefault();
                             document.getElementById('hapus-form{{$row->id}}').submit();" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('formdetaildestroy', [$row->id, $form->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          	@if($row->tipe->isgroup == 'Y')
	          	<a href="{{URL::route('formgrouplist', $row->id)}}" class="btn btn-info btn-xs" data-original-title="" title="">Detail</a>
	          	@endif
	          </td>
	        </tr>
	        @endif
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