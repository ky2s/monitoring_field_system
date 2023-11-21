@extends('layouts.appsa')
@section('header')
 <legend style="margin-bottom:0px;">
   <h3>Input Form</h3> 
  </legend>
  <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-list"></i> Master</a></li>
      <li><a href="{{route('formmemberlist')}}">Form</a></li>
      <li class="active">Create</li>
  </ol>
@endsection
<div class="clearfix"></div>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">{{$form->name}}</div>
                <div class="panel-body">
                    <form id="idform" class="form-horizontal" method="POST" action="{{ route('formmemberstore', $formid) }}">
                        {{ csrf_field() }}
                        @foreach($form->detail as $row)
                            @if($row->tipe->cfield=='Y' && $row->group_id == '')
                            <div class="form-group">
                                <label for="f{{$row->id}}" class="col-md-4 control-label">{{$row->label}}</label>

                                <div class="col-md-6">
                                    @if($row->tipe->fvar =='TEXT')
                                        <textarea class="form-control" name="f{{$row->id}}" id="f{{$row->id}}"></textarea>
                                    @else
                                        <input id="f{{$row->id}}" type="text" class="form-control" name="f{{$row->id}}" value="">
                                    @endif
                                    
                                </div>
                            </div>
                            @elseif($row->tipe->isgroup=='N' && $row->group_id == '')
                            <div class="panel panel-info">
                                <div class="panel-heading">{{$row->label}}</div>
                            </div>
                             @elseif($row->tipe->isgroup == 'Y')
                                <div class="panel panel-success">
                                    <div class="panel-heading">{{$row->label}}</div>
                                @foreach($row->group as $r)
                                    <div class="panel-body">
                                    <div class="form-group">
                                        <label for="f{{$row->id}}" class="col-md-2 control-label">{{$r->label}}</label>

                                        <div class="col-md-4">
                                            @if($r->tipe->fvar =='TEXT')
                                                <textarea class="form-control" name="f{{$r->id}}" id="f{{$r->id}}"></textarea>
                                            @else
                                                <input id="f{{$r->id}}" type="text" class="form-control" name="f{{$r->id}}" value="">
                                            @endif
                                            
                                        </div>
                                    </div>
                                    </div>
                                @endforeach
                                </div>
                            @endif
                        @endforeach

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
            @foreach($form->detail as $row)
            @if($row->tipe->cfield=='Y' && $row->mandatory =='Y')
            f{{$row->id}}: "required",

            @endif
            @endforeach

        },
        messages: {
            @foreach($form->detail as $row)
            @if($row->tipe->cfield=='Y' && $row->mandatory =='Y')
            f{{$row->id}}: "{{$row->label}} Harus Diisin",
            
            @endif
            @endforeach
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