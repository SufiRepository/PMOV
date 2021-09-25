<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="contractors" data-placeholder="{{ trans('general.select_contractors') }}" name="{{ $fieldname }}" style="width: 100%" id="contractor_select" aria-label="{{ $fieldname }}">
            @if ($contractor_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $contractor_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\Contractor::find($contractor_id)) ? \App\Models\Contractor::find($contractor_id)->name : '' }}
                </option>
            @else
                <option value=""  role="option">{{ trans('general.select_client') }}</option>
            @endif
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Contractor::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                <a href='{{ route('modal.show', 'contractor') }}' data-toggle="modal"  data-target="#createModal" data-select='contractor_select' class="btn btn-sm btn-primary">New</a>
            @endif
        @endcan
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

</div>
