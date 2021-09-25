<!-- client new -->
<div class="form-group {{ $errors->has('client') ? ' has-error' : '' }}">
    <label for="client" class="col-md-3 control-label">{{ trans('general.client') }}</label>
    <div class="col-md-7 col-sm-12">
       
    <input class="form-control" type="text" name="client" placeholder="client "aria-label="client" id="client" value="{{ old('client', $item->client) }}"/>
   
        {!! $errors->first('client', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
