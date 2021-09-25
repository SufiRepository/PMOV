@extends('layouts/default')

{{-- Page title --}}
@section('title')
Make Billing
@parent
@stop

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ URL::previous() }}" class="btn btn-primary">
    {{ trans('general.back') }}</a>
</div>
@stop

@section('content')

<!-- row -->
<div class="row">
    <!-- col-md-8 -->
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

        <!-- box -->
        <div class="box box-default">

            <!-- box-header -->
            <div class="box-header with-border text-right">

                <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                    <div class="col-md-12" style="padding: 0px; margin: 0px;">
                        {{-- <div class="col-md-9 text-left">
                            @if ($item->id)
                                <h2 class="box-title text-left" style="padding-top: 8px;">
                                    {{ $item->display_name }}
                                </h2>
                            @endif
                        </div>
                        <div class="col-md-3 text-right" style="padding-right: 10px;">
                            <a class="btn btn-link text-left" href="">
                                {{ trans('button.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check icon-white" aria-hidden="true"></i>
                                {{ trans('general.save') }}
                            </button>
                        </div> --}}
                    </div>
                </div>
                @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
                @endif
            </div><!-- /.box-header -->

            <!-- box-body -->
            <div class="box-body">


                <form id="create-form" class="form-horizontal" action="{{ route('billings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  
                     <div class="row">

                        {{-- Client name / Project Owner --}}
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Project Owner:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <p class="form-control"><b>{{$project->clientName}}</b></p>
                                    {{-- <label>{{$project->clientName}}</label> --}}
                                </div>
                            </div>
                        </div>

                        {{-- Project Name --}}
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Project Name:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    {{-- <p class="form-control">{{$project->name}}</p> --}}
                                    <label>{{$project->name}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label for="costing" class="col-md-3 control-label">Task:</label>
                            <div class="col-md-9">
                                {{-- <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <select class="form-control" name="task_id" style="width: 100%">
                                        @foreach ($tasks as $task)
                                            <option name="task_id" value="{{ $task->id }}"> 
                                                {{ $task->name }} 
                                            </option>
                                        @endforeach    
                                    </select>
                                </div> --}}
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <p class="form-control"></p>
                                </div>
                            </div>
                        </div>  

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Task Amount:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <p class="form-control"></p>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Amount:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                    <input class="form-control" type="text" name="amount" id="amount" value="" />
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Payment Schedule:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <p class="form-control">{{$task->payment_schedule_date}}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Billing Date --}}
                        <div class="form-group">
                            <label class="col-md-3 control-label">Billing Date:</label>
                            <div class="input-group col-md-3">
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                                    <input type="text" class="form-control" placeholder="Select date" name="billingdate" id="billingdate" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                        {{-- project id  --}}
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        {{-- task id  --}}
                        <input type="hidden" name="task_id" value="{{ $task->id }}">

                        <!-- details -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-7 col-sm-12">
                                <textarea class="col-md-6 form-control" id="description" aria-label="description" name="description"></textarea>
                            </div>
                        </div>

                        <input type="hidden" id="payment" name="payment" value="PAID">

                        <input type="hidden" id="paid" name="paid" value="PAID">
                        <input type="hidden" id="pending" name="pending" value="PENDING">

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        {{-- <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Invoice number:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-4 col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <input type="text" name="invoice_no" class="form-control" id="invoice_no" value="" required="required"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Invoice files:</label>
                            <div class="col-md-7 col-sm-12">
                                <input type="file" name="file_invoice_no" class="custom-file-input" id="file_invoice_no" value="" required="required"/>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Delivery Order number:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                    <input type="text" name="deliveryorder_no" class="form-control" id="deliveryorder_no" value="" placeholder="Deliveryorders" required="required">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Delivery Order files:</label>
                            <div class="col-md-7 col-sm-12">
                                <input type="file" name="file_deliveryorder_no" class="custom-file-input" id="file_deliveryorder_no" value="">
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Supporting Document:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                    <input type="text" name="supportingdocument" class="form-control" id="supportingdocument" value="" placeholder="Supportingdocuments">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Supporting document files:</label>
                            <div class="col-md-7 col-sm-12">
                                <input type="file" name="file_supportingdocument" class="custom-file-input" id="file_supportingdocument" value="">
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Payment Number:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                    <input type="text" name="payment_no" class="form-control" id="payment_no" value="" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Payment no files:</label>
                            <div class="col-md-7 col-sm-12">
                                <input type="file" name="file_payment_no" class="custom-file-input" id="file_payment_no" value="">
                            </div>
                        </div> --}}

                        {{-- select billing status --}}
                        {{-- <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Select Billing Status:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <select class="form-control" name="billingstatus" style="width: 100%">
                                        <option name="billingstatus" value="received">
                                            RECEIVED
                                        </option>
                                        <option name="billingstatus" value="pending">
                                            PENDING
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>   --}}
                    </div>
                   
                </form>

            </div> <!-- ./box-body -->


        </div><!-- box -->
        
    </div> <!-- col-md-8 -->

</div><!-- ./row -->









@stop