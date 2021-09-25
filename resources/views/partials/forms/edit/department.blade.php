<!-- projectnumber -->
<div class="form-group {{ $errors->has('department') ? ' has-error' : '' }}">
    <label for="department" class="col-md-3 control-label">{{ trans('general.department') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="department" id="department" value="{{ Request::old('department', $item->department) }}" />
        </div>
    </div>
    {!! $errors->first('department', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>