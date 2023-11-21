@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
    <h1>Create New Team</h1>
</div>
<div class="col-md-4">
    <ol class="breadcrumbs">
        <li><a href="{{URL::route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::route('teamlist')}}"><i class="fa fa-dashboard"></i> team</a></li>
        <li class="active"><i class="fa fa-edit"></i> Edit Team</li>
    </ol>
</div>
@endsection
@section('content')
<div class="white-wrapper">
    <form id="idform" class="form-horizontal" method="POST" action="{{ route('teamupdate', $team->id) }}">
        {{ csrf_field() }}
        <label><small>Name :</small></label>
        <div>   
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <label><small>Deskripsi Team :</small></label>
        <div>   
            <textarea name="description" id="description" cols="30" rows="10" class="form-control flat">{{$team->description}}</textarea>
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
    $("#name").val("{{$team->name}}");

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
@endsection