<!-- Purchase Cost -->
<div class="form-group {{ $errors->has('sale_value') ? ' has-error' : '' }}">
    <label for="sale_value" class="col-md-3 control-label">{{ trans('general.sale_value') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">

            {{-- <input type="text" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)" /> --}}

            <input class="form-control" type="text" name="sale_value" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)" aria-label="sale_value" id="sale_value" value="{{ old('sale_value', \App\Helpers\Helper::formatCurrencyOutput($item->sale_value)) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('sale_value', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>

<script >

    function FormatCurrency(ctrl) {
        //Check if arrow keys are pressed - we want to allow navigation around textbox using arrow keys
        if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
            return;
        }

        var val = ctrl.sale_value;

        val = val.replace(/,/g, "")
        ctrl.sale_value = "";
        val += '';
        x = val.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';

        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        ctrl.sale_value = x1 + x2;
    }

    function CheckNumeric() {
        return event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 46;
    }

</script>