@extends('layouts/edit-form', [
    'createText' => trans('admin/clients/table.create') ,
    'updateText' => trans('admin/clients/table.update'),
    'helpTitle' => trans('admin/clients/table.about_clients_title'),
    'helpText' => trans('admin/clients/table.about_clients_text'),
    
    'formAction' => (isset($item->id)) ? route('clients.update', ['client' => $item->id]) : route('clients.store'),
    // 'formAction' => (isset($item->id)) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store'),

])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/clients/table.name')])
@include ('partials.forms.edit.department')

@include ('partials.forms.edit.address')

<div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
    {{ Form::label('contact', trans('admin/clients/table.contact'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('contact', old('contact', $item->contact), array('class' => 'form-control')) }}
        {!! $errors->first('contact', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.phone')

<div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
    {{ Form::label('fax', trans('admin/clients/table.fax'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('fax', old('fax', $item->fax), array('class' => 'form-control')) }}
        {!! $errors->first('fax', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.email')

<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
    {{ Form::label('url', trans('admin/clients/table.url'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('url', old('url', $item->url), array('class' => 'form-control')) }}
        {!! $errors->first('url', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif

@include ('partials.forms.edit.notes')

<!-- Image -->
@if (($item->image) && ($item->image!=''))
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            <label for="image_delete">
                {{ Form::checkbox('image_delete', '1', old('image_delete'), array('class' => 'minimal', 'aria-label'=>'required')) }}
            </label>
            <br>
            <img src="{{ url('/') }}/uploads/clients/{{ $item->image }}" alt="Image for {{ $item->name }}" class="img-responsive">
            {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true"><br>:message</span>') !!}
        </div>
    </div>


@endif

{{-- @include ('partials.forms.edit.image-upload') --}}
@stop
