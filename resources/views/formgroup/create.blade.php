@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Master Form Detail</h3> 
  </legend>
  <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
      <li><a href="{{route('projectlist')}}">Project</a></li>
      <li><a href="{{route('formlist', $form->form->project_id)}}">Form</a></li>
      <li><a href="{{route('formdetaillist', $formid)}}">Detail</a></li>
      <li class="active">Create</li>
  </ol>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Form Detail</div>
                <div class="panel-body">
                    <form action="{{URL::route('formgroupstore', $formid)}}" class="form-horizontal" id="fcp" method="post">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                            <label for="label" class="col-md-4 control-label">Label</label>

                            <div class="col-md-6">
                                <input id="label" type="text" class="form-control" name="label" value="{{ old('label') }}" required autofocus>

                                @if ($errors->has('label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('label') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <label for="position" class="col-md-4 control-label">Position</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control" name="position" value="{{ old('position') }}" required autofocus>

                                @if ($errors->has('position'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mandatory') ? ' has-error' : '' }}">
                            <label for="mandatory" class="col-md-4 control-label">Mandatory</label>

                            <div class="col-md-6">
                                <select id="mandatory" name="mandatory" class="form-control input-sm">
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tipe') ? ' has-error' : '' }}">
                            <label for="tipe" class="col-md-4 control-label">Tipe</label>

                            <div class="col-md-6">
                                <select id="tipe" name="tipe" class="form-control input-sm select2t">
                                    @foreach($tipes as $u)
                                        <option value="{{$u->id}}">{{$u->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group tipechoice">
                            <label for="option" class="col-md-4 control-label">Pilihan</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="option" id="option"></textarea>
                            </div>
                        </div>

                        <div class="form-group tipechoice">
                            <label for="ismultiple" class="col-md-4 control-label">Mutiple Choice</label>

                            <div class="col-md-6">
                                <select id="ismultiple" name="ismultiple" class="form-control input-sm">
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>

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
    $("#tipe").change(function(){
        if($("#tipe").val()==1)
            $(".tipechoice").show();
        else
            $(".tipechoice").hide();
    });
    if($("#tipe").val()==1)
        $(".tipechoice").show();
    else
        $(".tipechoice").hide();

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
    $( "#tipe" ).select2( {placeholder: "Pilih Tipe",  maximumSelectionSize: 6 } );
@endsection