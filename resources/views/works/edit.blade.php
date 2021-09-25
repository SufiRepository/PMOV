@extends('layouts/edit-form', [
    'createText' => trans('admin/projects/form.create'),
    'updateText' => trans('admin/projects/form.update'),
    'topSubmit' => true,
    'formAction' => ($item->id) ? route('projects.update', ['project' => $item->id]) : route('projects.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/projects/form.name'), 'required' => 'true'])

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif
<!-- Location -->
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
{{-- @include ('partials.forms.edit.new-location') --}}

{{-- client register --}}
@include ('partials.forms.edit.client-select', ['translated_name' => trans('general.client'), 'fieldname' => 'client_id'])

{{-- contractor register --}}
@include ('partials.forms.edit.contractor-select', ['translated_name' => trans('general.contractors'), 'fieldname' => 'contractor_id'])



@include ('partials.forms.edit.costing')
@include ('partials.forms.edit.start_date')
@include ('partials.forms.edit.due_date')
 
@include ('partials.forms.edit.details')


   

@stop
