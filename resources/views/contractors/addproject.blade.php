@extends('layouts/edit-form', [
    'createText' => trans('admin/contractors/table.create') ,
    'updateText' => trans('admin/contractors/table.addproject'),
    'helpTitle' => trans('admin/contractors/table.about_contractors_title'),
    'helpText' => trans('admin/contractors/table.about_contractors_text'),
    
    'formAction' => (isset($item->id)) ? route('contractors.update', ['contractor' => $item->id]) : route('contractors.store'),

])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/contractors/table.name')])

@include ('partials.forms.edit.projects-select', ['translated_name' => trans('general.project'), 'fieldname' => 'project_id'])

{{-- <input type="text" id="project" name="project_id" > --}}


@stop
