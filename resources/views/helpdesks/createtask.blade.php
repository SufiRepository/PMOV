@extends('layouts/default')

{{-- Page title --}}
@section('title')
Make Task
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


                <form id="create-form" class="form-horizontal" action="{{ route('helpdeskcreatetaskload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  
                     <div class="row">

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Select Issue:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <select class="form-control" name="task_name" style="width: 100%">
                                        @foreach ($helpdesks as $helpdesk)
                                            <option name="task_name" value="{{ $helpdesk->name }}"> 
                                                {{ $helpdesk->name }} 
                                            </option>
                                        @endforeach    
                                    </select>
                                </div>
                                
                            </div>
                        </div>  

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Select Project:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <select class="form-control" name="project_id" style="width: 100%">
                                        @foreach ($projects as $project)
                                            <option maxlength="20" class="input-group col-md-7 col-sm-12" name="project_id" value="{{ $project->id }}"> 
                                                {{ $project->name }} 
                                            </option>
                                        @endforeach    
                                    </select>
                                </div>
                                
                            </div>
                        </div>  


                        <!-- details -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Details</label>
                            <div class="col-md-7 col-sm-12">
                                <textarea class="col-md-6 form-control" id="details" aria-label="details" name="details"></textarea>
                            </div>
                        </div>                  

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

            
                    </div>
                   
                </form>

            </div> <!-- ./box-body -->


        </div><!-- box -->
        
    </div> <!-- col-md-8 -->

</div><!-- ./row -->

@stop