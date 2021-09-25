<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">Select role:</label>
    <div class="col-md-9">
        <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
            <select class="form-control" name="role_id[1]" style="width: 100%">
                @foreach ($roles as $role)
                    <option name="role_id[1]" value="{{ $role->id }}"> 
                        {{ $role->name }} 
                    </option>
                @endforeach    
            </select>
        </div>
    </div>
</div>