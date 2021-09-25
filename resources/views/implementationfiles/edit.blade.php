@extends('layouts/edit-form', [
    'createText' => trans('Upload File') ,
    'updateText' => trans('Update File'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.teams'),
    'formAction' => (isset($item->id)) ? route('implementationuploads.update', ['implementationuploads' => $item->id]) : route('implementationuploads.store'),
])

{{-- Page content --}}
@section('inputFields')

<input type="hidden" id="implementation" name="implementationplans_id" value="{{request()->get('id')}}">

<!-- filename -->
<div class="form-group {{ $errors->has('filename') ? ' has-error' : '' }}">
    <label for="filename" class="col-md-3 control-label">{{ trans('admin/implementationplans/form.filename') }}</label>
    <div class="col-md-7 col-sm-12">
        {{-- <div class="col-xs-3"> --}}
    <input class="form-control" type="text" name="filename" aria-label="filename" id="filename" value="{{ old('filename', $item->filename) }}"/>
  </div>
  {!! $errors->first('filename', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.notes', ['translated_name' => trans('notes'), 'fieldname' => 'notes'])

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Select Files</label>
    <div class="col-md-7 col-sm-12">
        <input type="file" name="file" class="custom-file-input" id="chooseFile">
    </div>
    
</div>



{{-- end add --}}


@stop
