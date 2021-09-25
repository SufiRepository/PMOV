<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">Select status:</label>
    <div class="col-md-9">
        <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
            <select class="form-control" name="statustask_id" style="width: 100%">
                @foreach ($statustasks as $statustask)
                    <option  value="{{ $statustask->id }}"> 
                        {{ $statustask->name }} 
                    </option>
                @endforeach    
            </select>
        </div>
    </div>
</div>