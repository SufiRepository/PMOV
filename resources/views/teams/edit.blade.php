@extends('layouts/edit-form', [
    'createText' => trans('Add New Members'),
    'updateText' => trans('Update Members'),
    'topSubmit' => true,
    'helpText' => trans('help.projectteam'),
    'helpPosition' => 'right',
    'formAction' => ($item->id) ? route('teams.update', ['teams' => $item->id]) : route('teams.store'),
])

{{-- Page content --}}

@section('inputFields')

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif
<input type="hidden" id="project" name="project_id" value="{{request()->get('id')}}">

  <!-- Asset Tag -->
<div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
    <label for="asset_tag" class="col-md-3 control-label">{{ trans('Add Members') }}</label>

    <!-- we are creating a new asset - let people use more than one asset tag -->
        <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">

            <select class="form-control" name="user_id[]" id="asset_tag" value="{{ Request::old('asset_tag', \App\Models\Asset::autoincrement_asset()) }}" style="width: 100%">
            <option value="0"></option>   
             @foreach ($users as $user )       
                        <option  value="{{ $user->id }}"> 
                            {{ $user->username }} 
                        </option>
                @endforeach
            </select>
            {!! $errors->first('asset_tags', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
        <div class="col-md-2 col-sm-12">
            <button class="add_field_button btn btn-default btn-sm">
                <i class="fa fa-plus"></i>
            </button>
        </div>
            <br><br><br> 
        <label for="ItemLabel" class="col-md-3 control-label">{{ trans('Project Role') }}</label>
  {{-- <label class="ItemLabel">project Role:</label> --}}

  <div class="col-md-7 col-sm-12">
    <select class="form-control" name="role_id[]" style="width: 100%">
       <option value="0"></option>  
       @foreach ($roles as $role)    
                <option  value="{{ $role->id }}"> 
                    {{ $role->name }} 
                </option>
        @endforeach    
    </select>
  </div>
</div>


    {{-- @include ('partials.forms.edit.serial', ['fieldname'=> 'serials[1]', 'translated_serial' => trans('admin/hardware/form.serial')]) --}}

    {{-- @include ('partials.forms.edit.role', ['fieldname'=> 'role_id[1]', 'translated_serial' => trans('Role')]) --}}

<div class="input_fields_wrap"></div>

@stop

@section('moar_scripts')

<script nonce="{{ csrf_token() }}">


    var transformed_oldvals={};

    function fetchCustomFields() {
        //save custom field choices
        var oldvals = $('#custom_fields_content').find('input,select').serializeArray();
        for(var i in oldvals) {
            transformed_oldvals[oldvals[i].name]=oldvals[i].value;
        }

        var modelid = $('#model_select_id').val();
        if (modelid == '') {
            $('#custom_fields_content').html("");
        } else {

            $.ajax({
                type: 'GET',
                url: "{{url('/') }}/models/" + modelid + "/custom_fields",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                _token: "{{ csrf_token() }}",
                dataType: 'html',
                success: function (data) {
                    $('#custom_fields_content').html(data);
                    $('#custom_fields_content select').select2(); //enable select2 on any custom fields that are select-boxes
                    //now re-populate the custom fields based on the previously saved values
                    $('#custom_fields_content').find('input,select').each(function (index,elem) {
                        if(transformed_oldvals[elem.name]) {
                            $(elem).val(transformed_oldvals[elem.name]).trigger('change'); //the trigger is for select2-based objects, if we have any
                        }

                    });
                }
            });
        }
    }

    function user_add(status_id) {

        if (status_id != '') {
            $(".status_spinner").css("display", "inline");
            $.ajax({
                url: "{{url('/') }}/api/v1/statuslabels/" + status_id + "/deployable",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $(".status_spinner").css("display", "none");
                    $("#selected_status_status").fadeIn();

                    if (data == true) {
                        $("#assignto_selector").show();
                        $("#assigned_user").show();

                        $("#selected_status_status").removeClass('text-danger');
                        $("#selected_status_status").removeClass('text-warning');
                        $("#selected_status_status").addClass('text-success');
                        $("#selected_status_status").html('<i class="fa fa-check"></i> That status is deployable. This asset can be checked out.');


                    } else {
                        $("#assignto_selector").hide();
                        $("#selected_status_status").removeClass('text-danger');
                        $("#selected_status_status").removeClass('text-success');
                        $("#selected_status_status").addClass('text-warning');
                        $("#selected_status_status").html('<i class="fa fa-warning"></i> That asset status is not deployable. This asset cannot be checked out. ');
                    }
                }
            });
        }
    }


    $(function () {
        //grab custom fields for this model whenever model changes.
        $('#model_select_id').on("change", fetchCustomFields);

        //initialize assigned user/loc/asset based on statuslabel's statustype
        user_add($(".status_id option:selected").val());

        //whenever statuslabel changes, update assigned user/loc/asset
        $(".status_id").on("change", function () {
            user_add($(".status_id").val());
        });

    });


    // Add another asset tag + serial combination if the plus sign is clicked
    $(document).ready(function() {

        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x               = 1; //initial text box count




        $(add_button).click(function(e){ //on add input button click

            e.preventDefault();

            var auto_tag        = $("#asset_tag").val().replace(/[^\d]/g, '');
            var box_html        = '';
			const zeroPad 		= (num, places) => String(num).padStart(places, '0');

            // Check that we haven't exceeded the max number of asset fields
            if (x < max_fields) {

                if (auto_tag!='') {
                     auto_tag = zeroPad(parseInt(auto_tag) + parseInt(x),auto_tag.length);
                } else {
                     auto_tag = '';
                }

                x++; //text box increment

                box_html += '<span class="fields_wrapper">';
                box_html += '<div class="form-group"><label for="asset_tag" class="col-md-3 control-label">{{ trans('Add Members') }} ' + x + '</label>';
                box_html += '<div class="col-md-7 col-sm-12 required">';
                box_html += '<select class="form-control"name="user_id[]" value="{{ (($snipeSettings->auto_increment_prefix!='') && ($snipeSettings->auto_increment_assets=='1')) ? $snipeSettings->auto_increment_prefix : '' }}'+ auto_tag +'" data-validation="required">';
                box_html += '@foreach ($users as $user)';
                box_html += '<option value="{{ $user->id }}">';
                box_html += ' {{ $user->username }} ';
                box_html += '</option>';
                box_html += '@endforeach';
                box_html += '</select>';
                box_html += '</div>';
                box_html += '<div class="col-md-2 col-sm-12">';
                box_html += '<a href="#" class="remove_field btn btn-default btn-sm"><i class="fa fa-minus"></i></a>';
                box_html += '</div>';
                box_html += '</div>';

                box_html += '<div class="form-group"><label for="serial" class="col-md-3 control-label">{{ trans('Select Role') }} ' + x + '</label>';
                box_html += '<div class="col-md-7 col-sm-12">';
                box_html += '<div class="form-group col-sm-12 col-md-12">'
                box_html += '<div class="col-md-20">'
                box_html += '<div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">'
                box_html += '<select class="form-control" name="role_id[]" style="width: 100%">'
                box_html += '@foreach ($roles as $role)'
                box_html += '<option name="role_id[]" value="{{ $role->id }}">'
                box_html += ' {{ $role->name }} '
                box_html += '</option>'
                box_html += '@endforeach'
                box_html += '</select>'
                box_html += '</div>'
                box_html += '</div>'
                box_html += '</div> '
                box_html += '</div>';
                box_html += '</div>';
                box_html += '</span>';
                $(wrapper).append(box_html);

            // We have reached the maximum number of extra asset fields, so disable the button
            } else {
                $(".add_field_button").attr('disabled');
                $(".add_field_button").addClass('disabled');
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user clicks on remove text
            $(".add_field_button").removeAttr('disabled');
            $(".add_field_button").removeClass('disabled');
            e.preventDefault();
            console.log(x);

            $(this).parent('div').parent('div').parent('span').remove();
            x--;
        })
    });


</script>
@stop