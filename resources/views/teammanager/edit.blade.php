@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
    <h1>Edit Manager</h1>
</div>
<div class="col-md-4">
    <ol class="breadcrumbs">
        <li><a href="{{URL::route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('tmanagerlist', $teamid)}}">Team</a></li>
        <li class="active"><i class="fa fa-plus"></i> Edit Manager</li>
    </ol>
</div>
@endsection
@section('content')
<div class="white-wrapper">
    <p>Create New Team Manager for <b>{{$team->name}}</b> Team</p>
    <form action="{{URL::route('tmanagerupdate', [$managerid, $teamid])}}" class="form-horizontal" id="fcp" method="post">
        {{ csrf_field() }}
        <label><small>Name :</small></label>
        <div>   
            <select id="user_id" name="user_id" class="form-control input-sm select2">
                @foreach($users as $u)
                    <option value="{{$u->id}}">{{$u->name}} -- {{$u->tipe}}</option>
                @endforeach
            </select>
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
    $("#user_id").val("{{$tmanager->user_id}}");
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
    $( ".select2" ).select2( {placeholder: "Pilih User",  maximumSelectionSize: 6 } );
@endsection