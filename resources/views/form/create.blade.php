@extends('layouts.appv2')
@section('header')
 <div class="col-md-8">
    <h1>List Form <small>-- Project Name <small>-- {{$project->name}}</small></small></h1>
</div>
<div class="col-md-4">
    <ol class="breadcrumbs">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-users"></i><a href="{{route('projectlist')}}">Project</a></li>
        <li class="active"><i class="fa fa-eye"></i><a href="{{route('formlist', $project->id)}}">Form</a></li>
    </ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
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
<!--                             @if($project->publish == 'Y')
                            <label class="label published">Published</label> <br><br>
                            @else
                            <label class="label drafted">Draft</label> <br><br>
                            @endif
 -->                            
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
                            </div>-->
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
<form action="{{URL::route('formstore', $projectid)}}" class="form-horizontal" id="fcp" method="post">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="user_id" class="col-md-4 control-label">Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="auditor" class="col-md-4 control-label">Auditor</label>

        <div class="col-md-6">
            <select id="auditor" name="auditor[]" class="form-control input-sm select2" multiple>
                @foreach($auditors as $u)
                    <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
            </select>

        </div>
    </div>

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="team" class="col-md-4 control-label">Team</label>

        <div class="col-md-6">
            <select id="team" name="team[]" class="form-control input-sm select2t" multiple>
                @foreach($teams as $u)
                    <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
            </select>

        </div>
    </div>

    <div class="form-group">
        <label for="keterangan" class="col-md-4 control-label">Deskripsi Form</label>

        <div class="col-md-6">
            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
        </div>
    </div>
</form>

</div> <!-- /. col-md-6 -->

@endsection


@section('jscript')
    $('#idform').validate({
        ignore: "",
        rules: {
            name: "required",
        },
        messages: {
            name: "Nama Harus Diisin",
        },
        errorClass: 'help-block col-lg-6',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        }
    });
    $( "#auditor" ).select2( {placeholder: "Pilih User",  maximumSelectionSize: 6 } );
    $( ".select2t" ).select2( {placeholder: "Pilih Team",  maximumSelectionSize: 6 } );
@endsection