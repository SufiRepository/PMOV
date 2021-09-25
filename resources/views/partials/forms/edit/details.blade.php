<!-- details -->
<div class="form-group {{ $errors->has('details') ? ' has-error' : '' }}">
    <label for="details" class="col-md-3 control-label">{{ trans('admin/projects/form.details') }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="details" aria-label="details" name="details">{{ old('details', $item->details) }}</textarea>
        {!! $errors->first('details', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
