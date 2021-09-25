@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Outgoing Mail Server Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop

@section('content')

    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

<div class="row">
    <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

    <div class="panel box box-default">
        <div class="box-header with-border">
            <h2 class="box-title">
                <i class="fa fa-bell"></i> Edit Outgoing Mail Server Settings
            </h2>
        </div>
        <div class="box-body">

            <!-- Alert Email -->
            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Username :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_email', old('env_email', $email_setting->env_email), array('class' => 'form-control','placeholder' => 'pmo.mindwave@gmail.com')) }}
                    {!! $errors->first('env_email', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Password :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_password', old('env_password', $email_setting->env_password), array('class' => 'form-control','placeholder' => 'Your Password')) }}
                    {!! $errors->first('env_password', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}
                    {{-- {{ config('mail.reply_to.name') }}
                    {{ config('mail.reply_to.address') }} --}}
                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail From Name :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_name', old('env_name', $email_setting->env_name), array('class' => 'form-control','placeholder' => 'Project Management Office')) }}
                    {!! $errors->first('env_name', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Driver :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_driver', old('env_driver', $email_setting->env_driver), array('class' => 'form-control','placeholder' => 'smtp')) }}
                    {!! $errors->first('env_driver', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Host :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_host', old('env_host', $email_setting->env_host), array('class' => 'form-control','placeholder' => 'smtp.gmail.com')) }}
                    {!! $errors->first('env_host', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Port :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_port', old('env_port', $email_setting->env_port), array('class' => 'form-control','placeholder' => '587')) }}
                    {!! $errors->first('env_port', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail From Address :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_mailfromaddr', old('env_mailfromaddr', $email_setting->env_mailfromaddr), array('class' => 'form-control','placeholder' => 'pmo.mindwave@gmail.com')) }}
                    {!! $errors->first('env_mailfromaddr', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Reply To Address :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_replytoaddr', old('env_replytoaddr', $email_setting->env_replytoaddr), array('class' => 'form-control','placeholder' => 'pmo.mindwave@gmail.com')) }}
                    {!! $errors->first('env_replytoaddr', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                <div class="col-md-3">
                    Mail Reply To Name :
                </div>
                <div class="col-md-7">
                    {{ Form::text('env_replytoname', old('env_replytoname', $email_setting->env_replytoname), array('class' => 'form-control','placeholder' => 'Project Management Office')) }}
                    {!! $errors->first('env_replytoname', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                </div>
            </div>

            <div class="box-footer">
                <div class="text-left col-md-6">
                    <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                </div>
                <div class="text-right col-md-6">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                </div>

            </div>
        </div>


    </div>
    </div>
</div>

{{Form::close()}}

@stop
