@extends('layouts/edit-form', [
    'createText' => trans('admin/roles/table.create') ,
    'updateText' => trans('admin/roles/table.update'),
    'helpTitle' => trans('admin/roles/table.about_roles_title'),
    'helpText' => trans('admin/roles/table.about_roles_text'),
    
    'formAction' => (isset($item->id)) ? route('roles.update', ['contractor' => $item->id]) : route('roles.store'),
    // 'formAction' => (isset($item->id)) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store'),

])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/roles/table.name')])

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Access Level</label>
    <div class="col-md-7 col-md-10">
        {{-- <label for="files" class="col-md-20 control-label">ddd</label> --}}
        <select id="access_level" name="access_level">
            <option value=""></option>
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">level 3</option>
            <option value="4">level 4</option>
          </select>
    </div>
</div>
@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif

@stop
