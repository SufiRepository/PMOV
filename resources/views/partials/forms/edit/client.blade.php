<!-- Client -->
<div class="form-group {{ $errors->has('client_id') ? ' has-error' : '' }}">
    <label for="client_id" class="col-md-3 control-label">{{ trans('general.clientclient_id') }}</label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'client_id')) ? ' required' : '' }}">
        {{ Form::select('client_id', $client_list , old('client_id', $item->client_id), ['class'=>'select2', 'style'=>'min-width:350px', 'id' => 'client_select_id']) }}
        {!! $errors->first('client_id', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left">
             <a href='{{ route('modal.show', 'client') }}' data-toggle="modal"  data-target="#createModal" data-dependency="client" data-select='client_select_id' class="btn btn-sm btn-primary">New</a>
    </div>
</div>
