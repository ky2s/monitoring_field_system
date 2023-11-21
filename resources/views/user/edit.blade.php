@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
    <h1>Edit User</h1>
</div>
<div class="col-md-4">
    <ol class="breadcrumbs">
        <li><a href="{{URL::route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::route('userlist')}}"><i class="fa fa-dashboard"></i> User</a></li>
        <li class="active"><i class="fa fa-edit"></i> Edit User</li>
    </ol>
</div>
@endsection
@section('content')
<div class="white-wrapper">
    <form class="form-horizontal" method="POST" action="{{ route('userupdate', $user->id) }}">
        {{ csrf_field() }}
        <label><small>Kode :</small></label>
        <div>   
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <label><small>Nomor Telepon :</small></label>
        <div>   
            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
        </div>

        <label><small>Type :</small></label>
        <div>   
            <select id="tipe" name="tipe" class="form-control input-sm">
                @if(Auth::user()->tipe=='sa')
                <option value="sa">Super Admin</option>
                <option value="admin">Admin</option>
                @endif
                @if(Auth::user()->tipe=='admin')
                <option value="manager">Manager</option>
                <option value="member">Member</option>
                <option value="auditor">Auditor</option>
                @endif
                @if(Auth::user()->tipe=='manager')
                <option value="member">Member</option>
                <option value="auditor">Auditor</option>
                @endif
            </select>
        </div>

        <label><small>Apps :</small></label>
        <div>   
            <select id="apps" name="apps" class="form-control input-sm">
                <option value="ads">Ads</option>
                <option value="editable">Editable</option>
                <option value="bi">BI</option>
            </select>
        </div>

        <label><small>Form :</small></label>
        <div>   
            <select id="form" name="form[]" multiple="true" class="select2 form-control input-sm">
                @foreach(App\models\Formmodel::listAll() as $form)
                <option value="{{$form->id}}">{{$form->name}}</option>
                @endforeach
            </select>
        </div>


        <label><small>Email Address :</small></label>
        <div>   
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <label><small>Password :</small></label>
        <div>   
            <input id="password" type="password" class="form-control" name="password">
        </div>

        <label><small>Confirm Password :</small></label>
        <div>   
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
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
    $("#name").val("{{$user->name}}");
    $("#phone").val("{{$user->phone}}");
    $("#tipe").val("{{$user->tipe}}");
    $("#email").val("{{$user->email}}");
    $("#apps").val("{{$user->apps}}");
    $('#fuser').validate({
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
    @foreach($user->form as $a)
        "{{$a->id_form}}",
    @endforeach
                ];
    $("#form").val(aud);

    $( ".select2" ).select2( {placeholder: "Pilih Form",  maximumSelectionSize: 6 } );
@endsection