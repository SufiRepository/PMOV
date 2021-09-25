<!-- Purchase Cost -->
<div class="form-group {{ $errors->has('costing') ? ' has-error' : '' }}">
    <label for="costing" class="col-md-3 control-label">{{ trans('general.costing') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input class="form-control" type="text" name="costing" aria-label="costing" id="costing" value="{{ old('costing', \App\Helpers\Helper::formatCurrencyOutput($item->costing)) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('costing', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

</div>
