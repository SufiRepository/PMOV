<!-- projectnumber -->
<div class="form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
    <label for="duration" class="col-md-3 control-label">{{ trans('general.duration') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="duration" id="duration" value="{{ Request::old('duration', $item->duration) }}" />
        </div>
    </div>
    {!! $errors->first('duration', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>