<!-- finish date  -->
<div class="form-group {{ $errors->has('finish_date') ? ' has-error' : '' }}">
    <label for="finish_date" class="col-md-3 control-label">{{ trans('general.finish_date') }}</label>
    <div class="input-group col-md-3">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="finish_date" id="finish_date" value="{{ old('finish_date', ($item->finish_date) ? $item->finish_date->format('Y-m-d') : '') }}">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('finish_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>
 
 