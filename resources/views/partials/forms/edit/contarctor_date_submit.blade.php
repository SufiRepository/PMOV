<!-- start date  -->
<div class="form-group {{ $errors->has('date_submit') ? ' has-error' : '' }}">
    <label for="date_submit" class="col-md-3 control-label">{{ trans('general.date_submit') }}</label>
    <div class="input-group col-md-3">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="{{ trans('general.date_submit') }}" name="date_submit" id="date_submit" value="{{ old('date_submit', ($item->audit_date) ? $item->audit_date->format('Y-m-d') : '') }}">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('date_submit', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>
 
 