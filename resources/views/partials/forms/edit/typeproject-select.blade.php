{{-- <div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"> --}}

    {{-- {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }} --}}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        {{-- <select class="js-data-ajax" data-endpoint="typeprojects" data-placeholder="{{ trans('general.select_typeproject') }}" name="{{ $fieldname }}" style="width: 100%" id="typeproject_select" aria-label="{{ $fieldname }}">
            @if ($typeproject_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $typeproject_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\Typeproject::find($typeproject_id)) ? \App\Models\Typeproject::find($typeproject_id)->name : '' }}
                </option>
            @else
                <option value=""  role="option">{{ trans('general.select_Typeproject') }}</option>
            @endif
        </select> --}}

        <select class="form-control" name="typeproject_id">
            @foreach($typeproject as $typeproject)
              <option value="{{$typeproject->id}} ">{{$typeproject->name}}   {{$typeproject->id}}
            </option>
            @endforeach
          </select>


          {{-- <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
            <select class="form-control" name="task_id" style="width: 100%">
                @foreach ($tasks as $task)
                    <option name="task_id" value="{{ $task->id }}"> 
                        {{ $task->name }} 
                    </option>
                @endforeach    
            </select>
        </div> --}}


    </div>
{{-- 
    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Typeproject::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                <a href='{{ route('modal.show', 'typeproject') }}' data-toggle="modal"  data-target="#createModal" data-select='typeproject_select' class="btn btn-sm btn-primary">New</a>
            @endif
        @endcan
    </div> --}}

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

</div>
