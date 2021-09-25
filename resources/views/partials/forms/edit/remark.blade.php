<!-- remark -->
<div class="form-group {{ $errors->has('remark') ? ' has-error' : '' }}">
    <label for="remark" class="col-md-3 control-label">{{ trans('admin/billquantities/form.remark') }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="remark" aria-label="remark" name="remark">{{ old('remark', $item->remark) }}</textarea>
        {!! $errors->first('remark', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
