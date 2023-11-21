@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Master Team</h3> 
  </legend>
  <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
      <li><a href="{{route('teamlist')}}">Team</a></li>
      <li class="active">Create</li>
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
                    <form action="{{URL::route('tmemberstore', $teamid)}}" class="form-horizontal" id="fcp" method="post">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="user_id" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <select id="user_id" name="user_id" class="form-control input-sm select2">
                                    @foreach($users as $u)
                                        <option value="{{$u->id}}">{{$u->name}} -- {{$u->tipe}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

<!--                         <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Deskripsi Team</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div> -->

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