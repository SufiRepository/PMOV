<!-- Serial -->
<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
    <label for="{{ $fieldname }}" class="col-md-3 control-label">{{ trans('admin/hardware/form.serial') }} </label>
    <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'serial')) ? ' required' : '' }}">
        <input class="form-control" id="generateidtxt" type="text" name="{{ $fieldname }}"  value="{{ old('serial', $item->serial) }}" />
        {!! $errors->first('serial', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-2 text-left">
        <button type="button"  id="generateID" class="btn btn-primary">Generate</button>
    </div>
</div>

<script>
    const generateID = () =>
    Date.now().toString(Math.floor(Math.random() * 20) + 17);
      
    const btnGenerate = document.getElementById('generateID');
    const generateIDTXT = document.getElementById('generateidtxt');
    const copy = document.getElementById('copy');
    
    btnGenerate.addEventListener('click', () => {
      generateIDTXT.value = generateID();
    });
    
    </script>
