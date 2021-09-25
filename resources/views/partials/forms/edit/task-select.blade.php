<!-- task -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-6{{  ((isset($required) && ($required =='true'))) ?  ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="tasks" data-placeholder="{{ trans('general.select_task') }}" name="{{ $fieldname }}" style="width: 100%" id="{{ $fieldname }}_task_select" aria-label="{{ $fieldname }}" {!!  ((isset($item)) && (\App\Helpers\Helper::checkIfRequired($item, $fieldname))) ? ' data-validation="required" required' : '' !!}>
            @if ($task_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $task_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\Task::find($task_id)) ? \App\Models\Task::find($task_id)->name : '' }}
                </option>
            @else
                <option value=""  role="option">{{ trans('general.select_task') }}</option>
            @endif
        </select>
    </div>

    {{-- <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Task::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
            <a href='{{ route('modal.show', 'task') }}' data-toggle="modal"  data-target="#createModal" data-select='{{ $fieldname }}_task_select' class="btn btn-sm btn-primary">New</a>
            @endif
        @endcan
    </div> --}}

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

    @if (isset($help_text))
    <div class="col-md-7 col-sm-11 col-md-offset-3">
        <p class="help-block">{{ $help_text }}</p>
    </div>
    @endif


</div>



