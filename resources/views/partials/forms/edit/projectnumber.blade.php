<!-- projectnumber -->
<div class="form-group {{ $errors->has('projectnumbers') ? ' has-error' : '' }}">
    <label for="projectnumbers" class="col-md-3 control-label">{{ trans('general.projectnumbers') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="projectnumber" id="projectnumbers" value="{{ Request::old('projectnumbers', $item->projectnumber) }}" />
        </div>
    </div>
    {!! $errors->first('projectnumbers', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>