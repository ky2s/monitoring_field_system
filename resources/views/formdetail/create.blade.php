@extends('layouts.appv2')
@section('header')
 <div class="col-md-7">
    <h1>Create Question <small>-- {{$form->name}} <small>-- {{$form->project->name}}</small></small></h1>
</div>
<div class="col-md-5">
    <ol class="breadcrumbs">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('projectlist')}}"><i class="fa fa-dashboard"></i> Project</a></li>
        <li><a href="{{route('formlist', $form->project->id)}}"><i class="fa fa-dashboard"></i> Form List</a></li>
        <li class="active"><i class="fa fa-pencil-square-o"></i> Create Detail</li>
    </ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="white-wrapper">
    <form action="{{URL::route('formdetailstore', $formid)}}" class="form-horizontal" id="fcp" method="post">
        {{ csrf_field() }}

        <label><small>Label :</small></label>
        <div>   
            <input id="label" type="text" class="form-control" name="label" value="{{ old('label') }}" required autofocus>
        </div>

        <label><small>Position :</small></label>
        <div>   
            <input id="position" type="text" class="form-control" name="position" value="{{ old('position') }}" required>
        </div>

        <label><small>Mandatory :</small></label>
        <div>
            <input id="mandatory"name="mandatory" class="ace ace-switch ace-switch-3" type="checkbox" checked />
            <span class="lbl" data-lbl="Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak"></span>
        </div>

        <label><small>Tipe :</small></label>
        <div>   
            <select id="tipe" name="tipe" class="form-control input-sm select2t">
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
                <input id="maximum" type="text" class="form-control" name="maximum" value="{{ old('maximum') }}">
            </div>

        </div>
        <div id="divupper">
            <label><small>Tipe Tulisan :</small></label>
            <div>   
                <select id="tipetulisan" name="tipetulisan" class="form-control input-sm">
                    <option value="upper">Upper</option>
                    <option value="lower">Lower</option>
                    <option value="free" selected>Free</option>
                </select>
            </div>

        </div>
        <br>
        <button type="submit" class="btn btn-primary">
            Simpan
        </button>
    </form>
    <div class="clearfix"></div>
</div>

@endsection


@section('jscript')
    $("#tipe").change(function(){
        if($("#tipe").val()==1)
            $(".tipechoice").show();
        else
            $(".tipechoice").hide();

        if($("#tipe").val()==1 || $("#tipe").val()==6 || $("#tipe").val()==10)
            $("#divlength").show();
        else
            $("#divlength").hide();

        if($("#tipe").val()==9 || $("#tipe").val()==10)
            $("#divupper").show();
        else
            $("#divupper").hide();

    });
    $("#tipe").trigger("change");

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