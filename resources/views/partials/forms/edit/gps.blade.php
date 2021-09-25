<!-- gps -->
<div class="form-group {{ $errors->has('gps') ? ' has-error' : '' }}">
    <label for="gps" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-xs-3">
    <input class="form-control" type="text" name="longitude" placeholder="longitude"aria-label="longitude" id="longitude" value="{{ old('longitude', $item->longitude) }}"/>
  </div>
  <div class="col-xs-3">
    <input class="form-control" type="text" name="latitude"  placeholder="latitude" aria-label="latitude" id="latitude" value="{{ old('latitude', $item->latitude) }}"/>
</div>
      
        {!! $errors->first('gps', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
