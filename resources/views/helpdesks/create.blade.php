@extends('layouts/default', [
    'createText' => trans('admin/helpdesks/table.create') ,
    'updateText' => trans('admin/helpdesks/table.update'),
    'helpTitle' => trans('admin/helpdesks/table.about_helpdesks_title'),
    'helpText' => trans('admin/helpdesks/table.about_helpdesks_text'),
    'formAction' => (isset($item->id)) ? route('manufacturers.update', ['manufacturer' => $item->id]) : route('manufacturers.store'),
])

@section('content')

<div class="row">
  <div class="col-sm-8 offset-sm-2">
     <h1 class="display-3">Add helpdesk</h1>
   <div>
     @if ($errors->any())
       <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
             @endforeach
         </ul>
       </div><br />
     @endif
       <form method="post" action="{{ route('helpdesks.store') }}">
           @csrf
           <div class="form-group">    
               <label for="Issue">Issue:</label>
               <input type="text" class="form-control" name="issue"/>
           </div>           
           <button type="submit" class="btn btn-primary">Create</button>
       </form>
   </div>
 </div>
 </div>

@stop

