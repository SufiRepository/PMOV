<!-- issue -->
<div class="form-group {{ $errors->has('issue') ? ' has-error' : '' }}">
    <label for="issue" class="col-md-3 control-label">{{ trans('admin/hardware/form.issues') }}</label>
    <div class="col-md-7 col-sm-12">
        <input class="col-md-6 form-control" id="issue" aria-label="issue" name="issue">{{ old('issue', $item->issue) }}
        {!! $errors->first('issue', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
