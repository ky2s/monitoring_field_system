@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>List Form <small>-- Project Name <small>-- {{$project->name}}</small></small></h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><i class="fa fa-users"></i><a href="{{route('projectlist')}}">Project</a></li>
	  	<li>Form</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="col-md-12 col-xs-12">
	<form id="create-form" action="{{ route('formcreate', $project->id) }}" method="POST">
		{{ csrf_field() }}
	</form>
	<a href="#" onclick="event.preventDefault();document.getElementById('create-form').submit();" 
	class="btn btn-primary flat pull-right"><i class="fa fa-plus"></i> Create New Form</a>	<br> <br>
</div>
<div class="clearfix"></div>
<div class="col-md-4">
	<div class="side-header">
		<div class="panel-group" id="accordion">
	        <div class="panel panel-default">
	            <div class="panel-heading flat">
	                <h4 class="panel-title">
	                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><b>Project Detail</b> <span class="fa fa-caret-square-o-down pull-right"></span></a>
	                </h4>
	            </div>
	            <div id="collapseOne" class="panel-collapse collapse in">
	                <div class="panel-body flat">
						<div class="head-side-header">
							<!-- @if($project->publish == 'Y')
							<label class="label published">Published</label> <br><br>
							@else
							<label class="label drafted">Draft</label> <br><br>
							@endif -->
							
							<!-- <p><i class="fa fa-list"></i> 18 Form</p>
							<p><i class="fa fa-users"></i> 182 Participans</p>
							<span><i class="fa fa-clock-o"></i> Last Published 08 Agustus 2017</span>
							<div class="head-side-right">
								<ul class="nav navbar-nav">
									<li class="dropdown">
										<a href="#" class="btn btn-default btn-sm flat btn-action side-right" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-gear" aria-hidden="true"></i><i class="fa fa-caret-down"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-side-right">
											<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('update-project').submit();"><i class="fa fa-edit"></i> Switch to {{$project->publish=='Y'?'Draft':'Publish'}}</a></li>
											<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('hapus-project').submit();"><i class="fa fa-trash"></i> Delete Project</a></li>
											<form id="hapus-project" action="{{ route('projectdestroy', $project->id) }}" method="POST" style="display: none;">
							                    {{ csrf_field() }}
							                </form> 
							                <form id="update-project" action="{{ route('projectpublish', $project->id) }}" method="POST" style="display: none;">
							                    {{ csrf_field() }}
							                    <input type="hidden" name="publish" value="{{$project->publish=='N'?'Y':'N'}}">
							                </form> 
										</ul>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							 -->
						</div>
						<div class="body-side-header">
							<form>
								<label><small>Name :</small></label>
								<div>	
									<input type="text" class="form-control flat" id="basic-url" aria-describedby="basic-addon3" value="{{$project->name}}" disabled="true">
								</div>

								<label><small>Description :</small></label>
								<div>	
									<textarea name="" id="" cols="30" rows="5" class="form-control flat" disabled="true">{{$project->description}}</textarea>
								</div>
								<br>
								<!-- <div>
									<input type="submit" class="btn btn-default published flat btn-block" value="Publish">
								</div> -->
							</form>
						</div>
					</div>
	            </div>
	        </div>
	    </div>  
	</div>
</div>
<div class="col-md-8">
<!-- 	<form>
		<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control flat input-search-head" placeholder="Search here....">
				<div class="input-group-addon no-padding flat add-on-search">
					<button type="submit" class="btn btn-search-head"><i class="fa fa-search"></i> Search</button>
				</div>
			</div>
		</div>
	</form> -->
	<div class="col-md-6">
		<?php $i=1; ?>
		@foreach($project->formr as $f)
		@if($i%2==1)
		<div class="form-item" data-aos="fade-up" data-aos-delay="300" style="height: 158px">
			<div class="form-item-header">
				<div class="form-item-label">
					<div class="item-publish">
						<b>{{$f->publish=='Y'?'PUBLISH':'DRAFT'}}</b>
						<span class="item-publisha"></span>
					</div>
				</div>
				<div class="form-item-header-right">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="btn btn-default btn-sm flat btn-action" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-gear" aria-hidden="true"></i> Action <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('publish-form{{$f->id}}').submit();"><i class="fa fa-pencil"></i> Switch to {{$f->publish=='Y'?'Draft':'Publish'}}</a></li>
                             	<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('lock-form{{$f->id}}').submit();"><i class="fa fa-key"></i> Switch to {{$f->elock==true?'UNLOCK':'LOCK'}}</a></li>
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$f->id}}').submit();"><i class="fa fa-edit"></i> Edit</a></li>
								<li><a href="#" onclick="hapus({{$f->id}});"><i class="fa fa-trash"></i> Delete</a></li>
								<li><a href="#" onclick="duplicate('{{$f->id}}');"><i class="fa fa-copy"></i> Duplicate </a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="form-item-body">
				<h3>{{$f->name}}</h3>
				<!-- <ul>
					<li>Nama</li>
					<li>Alamat</li>
					<li>No. HP</li>
					<li>......</li>
				</ul> -->
			</div>
			<div class="form-item-footer">
				<!-- <div class="row">
					<div class="col-md-6 col-xs-6 bottom-left">
						<small>Updated</small> <br>
						<span>08 Agustus 2017</span>
					</div>
					<div class="col-md-6 col-xs-6 bottom-right">
						<small>Published</small> <br>
						<span>08 Agustus 2017</span>
					</div>
				</div> -->
			</div>
			<a href="{{URL::route('formdetaillist', $f->id )}}" class="item-link"></a>
			<form id="publish-form{{$f->id}}" action="{{ route('formpublish', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="lock-form{{$f->id}}" action="{{ route('formlock', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="edit-form{{$f->id}}" action="{{ route('formedit', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
            <form id="hapus-form{{$f->id}}" action="{{ route('formdestroy', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="duplicate{{$f->id}}" action="{{ route('duplicate', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
		</div>
		@endif
		<?php $i++; ?>
		@endforeach
	</div>
	<div class="col-md-6">
		<?php $i=1; ?>
		@foreach($project->formr as $f)
		@if($i%2==0)
		<div class="form-item" data-aos="fade-up" data-aos-delay="300" style="height: 158px">
			<div class="form-item-header">
				<div class="form-item-label">
					<div class="item-publish">
						<b>{{$f->publish=='Y'?'PUBLISH':'DRAFT'}}</b>
						<span class="item-publisha"></span>
					</div>
				</div>
				<div class="form-item-header-right">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="btn btn-default btn-sm flat btn-action" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-gear" aria-hidden="true"></i> Action <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('publish-form{{$f->id}}').submit();"><i class="fa fa-pencil"></i> Switch to {{$f->publish=='Y'?'Draft':'Publish'}}</a></li>
                             <li><a href="#" onclick="event.preventDefault();
                             document.getElementById('lock-form{{$f->id}}').submit();"><i class="fa fa-key"></i> Switch to {{$f->elock?'UNLOCK':'LOCK'}}</a></li>
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$f->id}}').submit();"><i class="fa fa-edit"></i> edit</a></li>
								<li><a href="#" onclick="hapus({{$f->id}});"><i class="fa fa-trash"></i> delete</a></li>
								<li><a href="#" onclick="duplicate('{{$f->id}}');"><i class="fa fa-copy"></i> Duplicate </a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="form-item-body">
				<h3>{{$f->name}}</h3>
				<!-- <ul>
					<li>Nama</li>
					<li>Alamat</li>
					<li>No. HP</li>
					<li>......</li>
				</ul> -->
			</div>
			<div class="form-item-footer">
				<!-- <div class="row">
					<div class="col-md-6 col-xs-6 bottom-left">
						<small>Updated</small> <br>
						<span>08 Agustus 2017</span>
					</div>
					<div class="col-md-6 col-xs-6 bottom-right">
						<small>Published</small> <br>
						<span>08 Agustus 2017</span>
					</div>
				</div> -->
			</div>
			<a href="{{URL::route('formdetaillist', $f->id )}}" class="item-link"></a>
			<form id="publish-form{{$f->id}}" action="{{ route('formpublish', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <form id="lock-form{{$f->id}}" action="{{ route('formlock', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="edit-form{{$f->id}}" action="{{ route('formedit', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
            <form id="hapus-form{{$f->id}}" action="{{ route('formdestroy', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="duplicate{{$f->id}}" action="{{ route('duplicate', [$f->id, $project->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
		</div>
		@endif
		<?php $i++; ?>
		@endforeach
	</div>
</div>

<!-- <div id="collapse4" class="body body-content">
	<p>
	
	</p>
	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Nama</th>
	      <th>&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($project->formr as $row)
	        <tr>
	          <td>{{$row->id}}</td>
	          <td>{{$row->name}}</td>
	          <td>
	          	<a href="{{URL::route('formdetaillist', $row->id )}}" class="btn btn-success btn-xs" data-original-title="" title="">Detail Form</a>
	          	<a href="{{URL::route('formedit', [$row->id, $project->id] )}}" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$row->id}}').submit();" class="btn btn-primary btn-xs" data-original-title="" title="">Edit</a>
                <form id="edit-form{{$row->id}}" action="{{ route('formedit', [$row->id, $project->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          	<a href="{{URL::route('formdestroy', [$row->id, $project->id] )}}" onclick="event.preventDefault();
                             document.getElementById('hapus-form{{$row->id}}').submit();" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                <form id="hapus-form{{$row->id}}" action="{{ route('formdestroy', [$row->id, $project->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> 
	          </td>
	        </tr>
		@endforeach
	  </tbody>
	</table>
</div>
 -->
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
		window.location = "{{URL::route('formcreate', $project->id)}}";
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

function duplicate(id){
    var r = confirm("Anda yakin akan menduplikasi form ini?");
    if (r == true) {
    	var idform = "#duplicate"+id;
        $(idform).submit();
    } else {
        
    }
}
@endsection