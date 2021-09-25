<!-- Project -->
<div class="form-group {{ $errors->has('project_id') ? ' has-error' : '' }}">
    <label for="project_id" class="col-md-3 control-label">{{ trans('general.project') }}</label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'project_id')) ? ' required' : '' }}">
        {{ Form::select('project_id', $project_list , old('project_id', $item->project_id), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('project_id', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
