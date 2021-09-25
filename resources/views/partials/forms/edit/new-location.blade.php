<!-- location new -->
<div class="form-group {{ $errors->has('location') ? ' has-error' : '' }}">
    <label for="location" class="col-md-3 control-label">{{ trans('general.location') }}</label>
    <div class="col-md-7 col-sm-12">
       
    <input class="form-control" type="text" name="location" placeholder="location "aria-label="location" id="location" value="{{ old('location', $item->location) }}"/>
   
        {!! $errors->first('location', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
