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
		<li class="active"><i class="fa fa-pencil-square-o"></i> {{$form->name}}</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="col-md-12 col-xs-12">
	<!-- <form id="rule2-form" action="{{ route('formdetailrule2', $form->id) }}" method="POST">
		{{ csrf_field() }}
	</form>
	<a href="#" onclick="event.preventDefault();document.getElementById('rule2-form').submit();" 
	class="btn btn-primary flat pull-right"><i class="fa fa-plus"></i> Create New Rules</a>	<br> <br><br> -->
</div>
<div class="clearfix"></div>
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
								<div class="head-side-right">
									<!-- <ul class="nav navbar-nav">
										<li class="dropdown">
											<a href="#" class="btn btn-default btn-sm flat btn-action side-right" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
												<i class="fa fa-gear" aria-hidden="true"></i>
											</a>
											<ul class="dropdown-menu dropdown-menu-side-right">
												<li><a href="#"><i class="fa fa-edit"></i> Switch to Draft</a></li>
												<li><a href="#"><i class="fa fa-trash"></i> Delete Project</a></li>
											</ul>
										</li>
									</ul> -->
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
		<div id="main-widget-container">
<div class="panel-group" id="draggablePanelList">
	<?php $z = 1; ?>
	@foreach($form->detail as $f)
	@if($f->group_id =='')
	<?php switch ($f->tipe_id) {
		case '15':
			$pnl = 'info';
			$color = '#31708f';
			break;
		case '7':
			$pnl = 'success';
			$color = '#3c763d';
			break;
		default:
			$pnl = 'primary';
			$color = '#fff';
			break;
	} ?>
    <div class="panel panel-{{$pnl}}" id="panel1">
        <div class="panel-heading" style="padding:0px !important;">
        	<div class="btn-group pull-left" style="right:20px; top:20px;">
	            <button class="btn btn-primary toggle-dropdown" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true"> <span class="glyphicon glyphicon-cog"></span>

	            </button>
	            <ul class="dropdown-menu dropdown-menu-right">
	            @if($f->tipe->isgroup=='Y')
	              <li><a href="{{ route('formgrouplist', $f->id) }}">Detail Group</a></li>
	              <li><a href="{{ route('formgroupclone', $f->id) }}">Clone Group</a></li>
	            @endif
	              <li><a href="#" onclick="event.preventDefault();
	                             document.getElementById('rule-form{{$f->id}}').submit();">Rules</a>
	              </li>
				@if(!$form->elock)
	              <li><a href="#" onclick="hapus({{$f->id}});">Delete</a>
	              </li>
	            @endif
	            </ul>
          	</div>

          <div class="clearfix"></div>
          	<form id="hapus-form{{$f->id}}" action="{{ route('formdetaildestroy', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <form id="rule-form{{$f->id}}" action="{{ route('formdetailrule', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
	        <h4 class="panel-title">
		        <a data-toggle="collapse" data-target="#input-detail-{{$f->id}}" 
		           href="#input-detail-{{$f->id}}" style="color:{{$color}}">
		          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;({{$f->position}}) {{$f->label}} -- {{$f->tipe->name}}
		          <span class="fa fa-right fa-caret-square-o-down pull-right"></span>
		        </a>
	      	</h4>
        </div>

        <div id="input-detail-{{$f->id}}" class="panel-collapse collapse">
            <div class="panel-body" style="padding-left:10px; padding-right:10px; padding-top:10px;">
            	<form action="{{URL::route('formdetailupdate', [$f->id, $f->form->id])}}" class="form-horizontal" id="fdetail{{$f->id}}" method="post">
			        {{ csrf_field() }}
			        <input type="hidden" name="iddetail" id="iddetail" value="{{$f->id}}">
			        <input type="hidden" name="position" id="position" value="{{$f->position}}">
			        <label><small>Label :</small></label>
			        <div>   
			            <input id="label" type="text" class="form-control" name="label" value="{{ $f->label }}" required autofocus>
			        </div>

			        <label><small>Keterangan :</small></label>
			        <div>
						<textarea id="keterangan" type="text" class="form-control" name="keterangan">{{ $f->keterangan }}</textarea>
			        </div>

			        <label><small>Mandatory :</small></label>
			        <div>
			            <input id="mandatory"name="mandatory" class="ace ace-switch ace-switch-3" type="checkbox" {{$f->mandatory=='Y'?'checked':''}} />
			            <span class="lbl" data-lbl="Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak"></span>
			        </div>

			        <label><small>Tipe :</small></label>
			        <div>   
			            <select id="tipe" name="tipe" class="form-control input-sm select2t" style="width:100%">
			                @foreach($tipes as $u)
			                    <option value="{{$u->id}}"{{$f->tipe_id == $u->id?' selected':''}}>{{$u->name}}</option>
			                @endforeach
			            </select>
			        </div>
			        <div class="tipechoice">
			            <label><small>Pilihan :</small></label>
			            <div>   
			                <input type="text" name="option" id="option" class="form-control" 
			                        value="{{str_replace(array("\r\n", '\r', '\n'), ',', $f->option)}}" placeholder="Masukkan Pilihan ..." data-role="tagsinput" />
			                <!-- <textarea name="option" id="option" cols="20" rows="5" class="form-control flat"></textarea> -->
			            </div>

			            <label><small>Multiple Choice :</small></label>
			            <div>   
			                <select id="ismultiple" name="ismultiple" class="form-control input-sm">
			                    <option value="Y"{{$f->ismultiple=='Y'?' selected':''}}>Ya</option>
			                    <option value="N"{{$f->ismultiple=='N'?' selected':''}}>Tidak</option>
			                </select>
			            </div>
			        </div>
			        <div id="divlength">
			            <label><small>Maximum :</small></label>
			            <div>   
			                <input id="maximum" type="text" class="form-control" name="maximum" value="{{ $f->maximum }}">
			            </div>

			        </div>
			        <div id="divupper">
			            <label><small>Tipe Tulisan :</small></label>
			            <div>   
			                <select id="tipetulisan" name="tipetulisan" class="form-control input-sm">
			                    <option value="upper"{{$f->tipetulisan=='upper'?' selected':''}}>Upper</option>
			                    <option value="lower"{{$f->tipetulisan=='lower'?' selected':''}}>Lower</option>
			                    <option value="free"{{$f->tipetulisan=='free'?' selected':''}}>Free</option>
			                </select>
			            </div>

			        </div>
			        <br>
			        @if(!$form->elock)
			        <button type="submit" class="btn btn-primary">
			            Simpan
			        </button>
			        @endif
			    </form>
            </div>
        </div>
    </div>
    <?php $z++; ?>
    @endif
    @endforeach
</div>
@if(!$form->elock)
	<div class="panel panel-default" id="panel1">
        <div class="panel-heading">
	        <h4 class="panel-title">
		        <a data-toggle="collapse" data-target="#input-detail-new" 
		           href="#input-detail-new">
		          Input Baru
		          <span class="fa fa-right fa-caret-square-o-down pull-right"></span>
		        </a>
	      	</h4>
        </div>

        <div id="input-detail-new" class="panel-collapse collapse">
            <div class="panel-body" style="padding-left:10px; padding-right:10px">
            	<form action="{{URL::route('formdetailstore', $form->id)}}" class="form-horizontal" id="fdetailnew" method="post">
			        {{ csrf_field() }}
			        <input type="hidden" name="position" id="position" value="{{$z}}">
			        <label><small>Label :</small></label>
			        <div>   
			            <input id="label" type="text" class="form-control" name="label" value="" required autofocus>
			        </div>

			        <label><small>Keterangan :</small></label>
			        <div>
			        	<textarea id="keterangan" type="text" class="form-control" name="keterangan"></textarea>
			        </div>

			        <label><small>Mandatory :</small></label>
			        <div>
			            <input id="mandatory"name="mandatory" class="ace ace-switch ace-switch-3" type="checkbox" />
			            <span class="lbl" data-lbl="Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak"></span>
			        </div>

			        <label><small>Tipe :</small></label>
			        <div>   
			            <select id="tipe" name="tipe" class="form-control input-sm select2t" style="width:100%">
			                @foreach($tipes as $u)
			                    <option value="{{$u->id}}">{{$u->name}}</option>
			                @endforeach
			            </select>
			        </div>
			        <div class="tipechoice">
			            <label><small>Pilihan :</small></label>
			            <div>   
			                <input type="text" name="option" id="option" class="form-control" 
			                        value="" placeholder="Masukkan Pilihan ..." data-role="tagsinput" />
			                <!-- <textarea name="option" id="option" cols="20" rows="5" class="form-control flat"></textarea> -->
			            </div>

			            <label><small>Multiple Choice :</small></label>
			            <div>   
			                <select id="ismultiple" name="ismultiple" class="form-control input-sm">
			                    <option value="Y">Ya</option>
			                    <option value="N">Tidak</option>
			                </select>
			            </div>
			        </div>
			        <div id="divlength">
			            <label><small>Maximum :</small></label>
			            <div>   
			                <input id="maximum" type="text" class="form-control" name="maximum" value="">
			            </div>

			        </div>
			        <div id="divupper">
			            <label><small>Tipe Tulisan :</small></label>
			            <div>   
			                <select id="tipetulisan" name="tipetulisan" class="form-control input-sm">
			                    <option value="upper">Upper</option>
			                    <option value="lower">Lower</option>
			                    <option value="free">Free</option>
			                </select>
			            </div>

			        </div>
			        <br>
			        @if(!$form->elock)
			        <button type="submit" class="btn btn-primary">
			            Simpan
			        </button>
			        @endif
			    </form>
            </div>
        </div>
    </div>
@endif
<!-- 			<input type="hidden" id="coll-aps" value="1">
			@foreach($form->detail as $f)
			<div id="widget-container-1" class="col-xs-7 widget-container-col">	
				<div class="widget-box widget-color-blue" id="my-widget-{{$f->id}}">
					<div class="widget-header">
						<h5 class="widget-title">{{$f->tipe->name}} -- {{$f->label}}</h5>
						<div class="widget-toolbar">
							<a data-action="collapse" href="#" class="collapsewid"><i class="ace-icon fa fa-chevron-up"></i></a>
						</div>
					</div>

					<div class="widget-body">
					 <div class="widget-main">
						<ul>
							<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$f->id}}').submit();"><i class="fa fa-edit"></i> Edit</a></li>
							<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('hapus-form{{$f->id}}').submit();"><i class="fa fa-trash"></i> Delete</a></li>
							<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('rule-form{{$f->id}}').submit();"><i class="fa fa-pencil"></i> Rules</a></li>
							<li><a href="#"><i class="fa fa-tasks"></i> Manage</a></li>
						</ul>
						<form id="edit-form{{$f->id}}" action="{{ route('formdetailedit', [$form->id, $f->id]) }}" method="POST" style="display: none;">
			                {{ csrf_field() }}
			            </form> 
						<form id="hapus-form{{$f->id}}" action="{{ route('formdetaildestroy', [$form->id, $f->id]) }}" method="POST" style="display: none;">
			                {{ csrf_field() }}
			            </form> 
			            <form id="rule-form{{$f->id}}" action="{{ route('formdetailrule', [$form->id, $f->id]) }}" method="POST" style="display: none;">
			                {{ csrf_field() }}
			            </form>
					 </div>
					</div>
				</div>
			</div>
			@endforeach -->
		</div>
<!-- 
		<?php $i=1; ?>
		@foreach($form->detail as $f)
		@if($i%2==1)
		<div class="form-item" data-aos="fade-up" data-aos-delay="300">
			<div class="form-item-header">
				<div class="form-item-label">
					<div class="item-publish">
						<b>{{$f->label}}</b>
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
                             document.getElementById('edit-form{{$f->id}}').submit();"><i class="fa fa-edit"></i> edit</a></li>
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('rule-form{{$f->id}}').submit();"><i class="fa fa-pencil"></i> Rules</a></li>
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('hapus-form{{$f->id}}').submit();"><i class="fa fa-trash"></i> delete</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="form-item-body">
				<h3>Tipe: {{$f->tipe->name}}</h3>
				<h3>Position: {{$f->position}}</h3>
			</div>
			<div class="form-item-footer">
			</div>
			<a href="#" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$f->id}}').submit();" class="item-link"></a>
			<form id="edit-form{{$f->id}}" action="{{ route('formdetailedit', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="rule-form{{$f->id}}" action="{{ route('formdetailrule', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
            <form id="hapus-form{{$f->id}}" action="{{ route('formdetaildestroy', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
		</div>
		@endif
		<?php $i++; ?>
		@endforeach
	</div>
	<div class="col-md-6">
		<?php $i=1; ?>
		@foreach($form->detail as $f)
		@if($i%2==0)
		<div class="form-item" data-aos="fade-up" data-aos-delay="300">
			<div class="form-item-header">
				<div class="form-item-label">
					<div class="item-publish">
						<b>{{$f->label}}</b>
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
                             document.getElementById('edit-form{{$f->id}}').submit();"><i class="fa fa-edit"></i> edit</a></li>
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('rule-form{{$f->id}}').submit();"><i class="fa fa-pencil"></i> Rules</a></li>
								<li><a href="#" onclick="event.preventDefault();
                             document.getElementById('hapus-form{{$f->id}}').submit();"><i class="fa fa-trash"></i> delete</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="form-item-body">
				<h3>Tipe: {{$f->tipe->name}}</h3>
				<h3>Position: {{$f->position}}</h3>
			</div>
			<div class="form-item-footer">
			</div>
			<a href="#" class="item-link" onclick="event.preventDefault();
                             document.getElementById('edit-form{{$f->id}}').submit();"></a>
			<form id="edit-form{{$f->id}}" action="{{ route('formdetailedit', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
			<form id="rule-form{{$f->id}}" action="{{ route('formdetailrule', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
            <form id="hapus-form{{$f->id}}" action="{{ route('formdetaildestroy', [$form->id, $f->id]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form> 
		</div>
		@endif
		<?php $i++; ?>
		@endforeach
		 -->

</div>

@endsection

@section('jscript')
@if(!$form->elock)
	jQuery(function($) {
        var panelList = $('#draggablePanelList');

        panelList.sortable({
            // Only make the .panel-heading child elements support dragging.
            // Omit this to make then entire <li>...</li> draggable.
            handle: '.panel-heading', 
            update: function() {
            	var x = 1;
                $('.panel', panelList).each(function(index, elem) {
                    var $listItem = $(elem),
                         newIndex = $listItem.index();

                   	// alert($(this).find("#iddetail").val());
                   	$(this).find("#position").val(x);
                   	$.get( "{{route('formreposition')}}", { id: $(this).find("#iddetail").val(), position: $(this).find("#position").val() } );
                 	// Persist the new indices.
                 	x++;
                });
            }
        });
    });
@endif

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
	$( ".select2t" ).select2( {placeholder: "Pilih Tipe",  maximumSelectionSize: 6 } );
	@foreach($form->detail as $f)
		$("#fdetail{{$f->id}}").find("#label").val("{{$f->label}}");
	    $("#fdetail{{$f->id}}").find("#position").val("{{$f->position}}");
	    $("#fdetail{{$f->id}}").find("#mandatory").val("{{$f->mandatory}}");
	    $("#fdetail{{$f->id}}").find("#tipe").val("{{$f->tipe_id}}");
	    $("#fdetail{{$f->id}}").find("#tipetulisan").val("{{$f->tipetulisan}}");

	    $("#fdetail{{$f->id}}").find("#ismultiple").val("{{$f->ismultiple}}");
	    $("#fdetail{{$f->id}}").find("#maximum").val("{{$f->maximum}}");

	    $("#fdetail{{$f->id}}").find("#tipe").change(function(){
	        if($("#fdetail{{$f->id}}").find("#tipe").val()==1)
	            $("#fdetail{{$f->id}}").find(".tipechoice").show();
	        else
	            $("#fdetail{{$f->id}}").find(".tipechoice").hide();

	        if($("#fdetail{{$f->id}}").find("#tipe").val()==1 || $("#fdetail{{$f->id}}").find("#tipe").val()==6 || $("#fdetail{{$f->id}}").find("#tipe").val()==10)
	            $("#fdetail{{$f->id}}").find("#divlength").show();
	        else
	            $("#fdetail{{$f->id}}").find("#divlength").hide();

	        if($("#fdetail{{$f->id}}").find("#tipe").val()==9 || $("#fdetail{{$f->id}}").find("#tipe").val()==10)
	            $("#fdetail{{$f->id}}").find("#divupper").show();
	        else
	            $("#fdetail{{$f->id}}").find("#divupper").hide();

	    });
	    $("#fdetail{{$f->id}}").find("#tipe").trigger("change");

	    $("#fdetail{{$f->id}}").find('#idform').validate({
	        ignore: "",
	        rules: {
	            name: "required",
	        },
	        messages: {
	            name: "Nama Harus Diisin",
	        },
	        errorClass: 'help-block col-lg-6',
	        highlight: function(element, errorClass, validClass) {
	            $("#fdetail{{$f->id}}").find(element).parents('.form-group').removeClass('has-success').addClass('has-error');
	        },
	        unhighlight: function(element, errorClass, validClass) {
	            $("#fdetail{{$f->id}}").find(element).parents('.form-group').removeClass('has-error').addClass('has-success');
	        }
	    });
	@endforeach
    $("#fdetailnew").find("#tipe").change(function(){
        if($("#fdetailnew").find("#tipe").val()==1)
            $("#fdetailnew").find(".tipechoice").show();
        else
            $("#fdetailnew").find(".tipechoice").hide();

        if($("#fdetailnew").find("#tipe").val()==1 || $("#fdetailnew").find("#tipe").val()==6 || $("#fdetailnew").find("#tipe").val()==10)
            $("#fdetailnew").find("#divlength").show();
        else
            $("#fdetailnew").find("#divlength").hide();

        if($("#fdetailnew").find("#tipe").val()==9 || $("#fdetailnew").find("#tipe").val()==10)
            $("#fdetailnew").find("#divupper").show();
        else
            $("#fdetailnew").find("#divupper").hide();

    });
    $("#fdetailnew").find("#tipe").trigger("change");

    $("#fdetailnew").find('#idform').validate({
        ignore: "",
        rules: {
            name: "required",
        },
        messages: {
            name: "Nama Harus Diisin",
        },
        errorClass: 'help-block col-lg-6',
        highlight: function(element, errorClass, validClass) {
            $("#fdetailnew").find(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $("#fdetailnew").find(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        }
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