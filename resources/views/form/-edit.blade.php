@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Master Team</h3> 
  </legend>
  <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
      <li><a href="{{route('projectlist')}}">Project</a></li>
      <li><a href="{{route('formlist', $projectid)}}">Form</a></li>
      <li class="active">Edit</li>
  </ol>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Team</div>
                <div class="panel-body">
                    <form action="{{URL::route('formupdate', [$formid, $projectid])}}" class="form-horizontal" id="fcp" method="post">
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
                        <div class="form-group{{ $errors->has('auditor') ? ' has-error' : '' }}">
                            <label for="auditor" class="col-md-4 control-label">Auditor</label>

                            <div class="col-md-6">
                                <select id="auditor" name="auditor[]" class="form-control input-sm select2" multiple>
                                    @foreach($auditors as $u)
                                        <option value="{{$u->id}}">{{$u->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('team') ? ' has-error' : '' }}">
                            <label for="fteam" class="col-md-4 control-label">Team</label>

                            <div class="col-md-6">
                                <select id="fteam" name="team[]" class="form-control input-sm select2t" multiple>
                                    @foreach($teams as $u)
                                        <option value="{{$u->id}}">{{$u->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan" class="col-md-4 control-label">Deskripsi Form</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="keterangan" id="keterangan">{{$form->keterangan}}</textarea>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('jscript')
    var tm = [
    @foreach($form->team as $a)
        "{{$a->team_id}}",
    @endforeach
                ];
    $("#fteam").val(tm);

    $("#name").val("{{$form->name}}");

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
    var aud = [
    @foreach($form->auditor as $a)
        "{{$a->user_id}}",
    @endforeach
                ];
    $("#auditor").val(aud);

    $( "#auditor" ).select2( {placeholder: "Pilih User",  maximumSelectionSize: 6 } );
    $( "#fteam" ).select2( {placeholder: "Pilih Team",  maximumSelectionSize: 6 } );
@endsection