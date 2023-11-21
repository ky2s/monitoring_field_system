@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
    <h1>Create New Project</h1>
</div>
<div class="col-md-4">
    <ol class="breadcrumbs">
        <li><a href="{{URL::route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::route('projectlist')}}"><i class="fa fa-dashboard"></i> team</a></li>
        <li class="active"><i class="fa fa-plus"></i> Create New Project</li>
    </ol>
</div>
@endsection
@section('content')
<div class="white-wrapper">
    <form class="form-horizontal" method="POST" action="{{ route('projectupdate', $project->id) }}">
        {{ csrf_field() }}        <label><small>Project Name :</small></label>
        <div>   
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <label><small>Deskripsi Project :</small></label>
        <div>   
            <textarea name="description" id="description" cols="30" rows="10" class="form-control flat">{{$project->description}}</textarea>
        </div>
        <label><small>Admin :</small></label>
        <div>   
            <select id="admin" name="admin[]" class="form-control input-sm select2" multiple>
                @foreach($admins as $u)
                    <option value="{{$u->id}}">{{$u->name}}</option>
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
    var aud = [
    @foreach($project->admin as $a)
        "{{$a->user_id}}",
    @endforeach
                ];
    $("#admin").val(aud);

    $( "#admin" ).select2( {placeholder: "Pilih User",  maximumSelectionSize: 6 } );
    $("#name").val("{{$project->name}}");

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