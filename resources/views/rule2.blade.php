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
                    <form action="{{URL::route('formdetailupdaterule2', $formid)}}" class="form-horizontal" id="fcp" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="detail" class="col-md-4 control-label">Input Detail</label>

                            <div class="col-md-6">
                                <select id="detail" name="detail[]" class="form-control input-sm" multiple>
                                    @foreach($konlist as $d)
                                    <?php
                                        $chk = App\models\Formkondisimodel::getSelected($d->id);
                                        if($chk !=''){
                                            $andor = $d->andor;
                                            $idk = $d->id;
                                        }
                                        else{
                                            $andor ='';
                                        }
                                    ?>
                                    <option value="{{$d->id}}"{{$chk}}>{{$d->label}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="andor" class="col-md-4 control-label">Kondisi</label>

                            <div class="col-md-6">
                                <select id="andor" name="andor" class="form-control input-sm">
                                    <option value="AND"{{$andor=='AND'?' checked':''}}>Semua benar</option>
                                    <option value="OR"{{$andor=='OR'?' checked':''}}>Salah satu benar</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            @foreach($kondisilist as $k)
                            <div class="col-md-4">
                                <select id="kondisi" name="kondisi[]" class="form-control input-sm select2d">
                                    <option></option>
                                    @foreach($detlist as $d)
                                        <option value="{{$d->id}}"{{$d->id==$k->idDetailkondisi?' selected':''}}>{{$d->label}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-2" style="width:200px;">
                                <select id="logika" name="logika[]" class="form-control input-sm logikad">
                                    <option value="<"{{$k->kondisi=='<'?' selected':''}}>Lebih Besar</option>
                                    <option value=">"{{$k->kondisi=='>'?' selected':''}}>Lebih Kecil</option>
                                    <option value="<="{{$k->kondisi=='<='?' selected':''}}>Lebih Kecil Sama Dengan</option>
                                    <option value=">="{{$k->kondisi=='>='?' selected':''}}>Lebih Besar Sama Dengan</option>
                                    <option value="=="{{$k->kondisi=='=='?' selected':''}}>Sama Dengan</option>
                                    <option value="!="{{$k->kondisi=='!='?' selected':''}}>Tidak Sama Dengan</option>
                                </select>

                            </div>
                            <div class="col-md-2" style="width:150px;">
                                <input id="nilai" type="text" class="form-control nilaid" data-role="tagsinput" name="nilai[]" value="{{$k->nilai}}">
                            </div>
                            @endforeach
                            <div class="col-md-4">
                                <select id="kondisi" name="kondisi[]" class="form-control input-sm select2d">
                                    <option></option>
                                    @foreach($detlist as $d)
                                        <option value="{{$d->id}}">{{$d->label}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-2" style="width:200px;">
                                <select id="logika" name="logika[]" class="form-control input-sm logikad">
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

    $('input[type=text]').prop("disabled", "true");
    $('select').prop("disabled", "true");
    $('textarea').prop("disabled", "true");

    $("#andor").removeAttr("disabled"); 
    $(".select2d").removeAttr("disabled"); 
    $(".logikad").removeAttr("disabled"); 
    $(".nilaid").removeAttr("disabled"); 
    $("#detail").removeAttr("disabled"); 
    $("#detail").removeAttr("disabled"); 

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
    $( "#detail" ).select2( {placeholder: "Pilih Data",  maximumSelectionSize: 6 } );
@endsection