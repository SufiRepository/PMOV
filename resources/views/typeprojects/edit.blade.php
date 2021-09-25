@extends('layouts/edit-form', [
    'createText' => trans('admin/typeprojects/table.create') ,
    'updateText' => trans('admin/typeprojects/table.update'),
    'helpTitle' => trans('admin/typeprojects/table.about_typeprojects_title'),
    'helpText' => trans('admin/typeprojects/table.about_typeprojects_text'),
    'formAction' => (isset($item->id)) ? route('typeprojects.update', ['typeproject' => $item->id]) : route('typeprojects.store'),
])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/typeprojects/table.name')])

<!-- Image -->
@if (($item->image) && ($item->image!=''))
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            <label for="image_delete">
                {{ Form::checkbox('image_delete', '1', old('image_delete'), array('class' => 'minimal', 'aria-label'=>'required')) }}
            </label>
            <br>
            <img src="{{ url('/') }}/uploads/typeprojects/{{ $item->image }}" alt="Image for {{ $item->name }}" class="img-responsive">
            {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true"><br>:message</span>') !!}
        </div>
    </div>


@endif

@include ('partials.forms.edit.image-upload')
@stop
