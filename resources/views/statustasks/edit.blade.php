@extends('layouts/edit-form', [
    'createText' => trans('admin/statustasks/table.create') ,
    'updateText' => trans('admin/statustasks/table.update'),
    'helpTitle' => trans('admin/statustasks/table.about_statustasks_title'),
    'helpText' => trans('admin/statustasks/table.about_statustasks_text'),
    
    'formAction' => (isset($item->id)) ? route('statustasks.update', ['client' => $item->id]) : route('statustasks.store'),
    // 'formAction' => (isset($item->id)) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store'),

])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/statustasks/table.name')])


@include ('partials.forms.edit.image-upload')
@stop
