@extends('layouts.appv2')
@section('header')
 <div class="col-md-6">
    <h1>Create Rules <small>-- {{$form->name}} <small>-- {{$form->project->name}}</small></small></h1>
</div>
<div class="col-md-6">
    <ol class="breadcrumbs">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('projectlist')}}"><i class="fa fa-dashboard"></i> Project</a></li>
        <li><a href="{{route('formlist', $form->project->id)}}"><i class="fa fa-dashboard"></i> Form List</a></li>
        <li><a href="{{route('formdetaillist', $form->id)}}"><i class="fa fa-dashboard"></i> {{$form->name}}</a></li>
        <li class="active"><i class="fa fa-pencil-square-o"></i> Create Rules</li>
    </ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Form Detail</div>
                <div class="panel-body">
                    <form action="{{URL::route('formdetailupdaterule', [$detailid, $formid])}}" class="form-horizontal" id="fcp" method="post">
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
                                <textarea class="form-control" name="option" id="option">{{$detail->option}}</textarea>
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
                            <label for="andor" class="col-md-4 control-label">Kondisi</label>

                            <div class="col-md-6">
                                <select id="andor" name="andor" class="form-control input-sm">
                                    <option value="AND">Semua benar</option>
                                    <option value="OR">Salah satu benar</option>
                                </select>

                            </div>
                        </div>
                        @foreach($detail->kondisi as $k)
                        <div class="form-group" style="padding-left:10px">
                            <div class="col-md-4">
                                <select id="detail" name="detail[]" class="form-control input-sm select2d">
                                    <option></option>
                                    @foreach($detlist as $d)
                                    <option value="{{$d->id}}" {{$d->id==$k->idDetailkondisi?"selected":""}}>{{$d->label}} - ({{$d->position}})</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-2" style="width:200px;">
                                <select id="logika" name="logika[]" class="form-control input-sm logikad">
                                    <option value="<" {{$k->kondisi=="<"?"selected":""}}>Lebih Besar</option>
                                    <option value=">" {{$k->kondisi==">"?"selected":""}}>Lebih Kecil</option>
                                    <option value="<=" {{$k->kondisi=="<="?"selected":""}}>Lebih Kecil Sama Dengan</option>
                                    <option value=">=" {{$k->kondisi==">="?"selected":""}}>Lebih Besar Sama Dengan</option>
                                    <option value="==" {{$k->kondisi=="=="?"selected":""}}>Sama Dengan</option>
                                    <option value="!=" {{$k->kondisi=="!="?"selected":""}}>Tidak Sama Dengan</option>
                                </select>

                            </div>
                            <div class="col-md-2" style="width:210px;">
                                <input id="nilai" type="text" data-role="tagsinput" class="form-control nilaid" name="nilai[]" value="{{ old('nilai')?old('nilai'):$k->nilai }}" required>
                            </div>
                            <div class="col-md-2" style="width:100px;">
                                
                                <a href="{{URL::route('formdetaildestroyrule', [$detailid, $formid] )}}" onclick="event.preventDefault();
                                             document.getElementById('hapus-form{{$k->id}}').submit();" class="btn btn-danger btn-xs" data-original-title="" title="">Hapus</a>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group" style="padding-left:10px">
                            <div class="col-md-4">
                                <select id="detail" name="detail[]" class="form-control input-sm select2d">
                                    <option></option>
                                    @foreach($detlist as $d)
                                    <option value="{{$d->id}}">{{$d->label}} - ({{$d->position}})</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-2" style="width:200px;">
                                <select id="logika" name="logika[]" class="form-control input-sm logikad"
                                    <option value="<">Lebih Besar</option>
                                    <option value=">">Lebih Kecil</option>
                                    <option value="<=">Lebih Kecil Sama Dengan</option>
                                    <option value=">=">Lebih Besar Sama Dengan</option>
                                    <option value="==">Sama Dengan</option>
                                    <option value="!=">Tidak Sama Dengan</option>
                                </select>

                            </div>
                            <div class="col-md-2" style="width:150px;">
                                <input id="nilai" type="text" class="form-control nilaid" data-role="tagsinput" name="nilai[]" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                @if(!$form->elock)
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($detail->kondisi as $k)
<form id="hapus-form{{$k->id}}" action="{{ route('formdetaildestroyrule', [$detailid, $formid]) }}" method="POST" style="display: none;">
    <input type="hidden" name="idkondisi" value="{{$k->id}}">
    {{ csrf_field() }}
</form> 
@endforeach

@endsection


@section('jscript')
    $("#label").val("{{$detail->label}}");
    $("#position").val("{{$detail->position}}");
    $("#mandatory").val("{{$detail->mandatory}}");
    $("#tipe").val("{{$detail->tipe_id}}");
    $("#ismultiple").val("{{$detail->ismultiple}}");
    $("#andor").val("{{$detail->andor?$detail->andor:'AND'}}");


    $('input[type=text]').prop("disabled", "true");
    $('select').prop("disabled", "true");
    $('textarea').prop("disabled", "true");

    $("#andor").removeAttr("disabled"); 
    $(".select2d").removeAttr("disabled"); 
    $(".logikad").removeAttr("disabled"); 
    $(".nilaid").removeAttr("disabled"); 

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
    $( ".select2d" ).select2( {placeholder: "Pilih Data",  maximumSelectionSize: 6 } );
@endsection