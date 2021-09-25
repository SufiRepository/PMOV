@extends('layouts/edit-form', [
    'createText' => trans('Upload File') ,
    'updateText' => trans('Update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.teams'),
    'formAction' => (isset($item->id)) ? route('projectuploads.update', ['projectuploads' => $item->id]) : route('projectuploads.store'),
])

{{-- Page content --}}
@section('inputFields')

<input type="hidden" id="project" name="project_id" value="{{request()->get('id')}}">

<!-- filename -->
<div class="form-group {{ $errors->has('filename') ? ' has-error' : '' }}">
    <label for="filename" class="col-md-3 control-label">Filename</label>
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
        <p >only csv,txt,xlx,xls,pdf type file, and 5Mb</p>

    </div>

</div>



{{-- end add --}}


@stop
