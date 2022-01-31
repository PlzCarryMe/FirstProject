<!-- Extends template page -->
@extends('layouts.app')

<!-- Specify content -->
@section('content')

<h3>Add Species</h3>

<div class="row">

   <div class="col-md-12 col-sm-12 col-xs-12">

     <!-- Alert message (start) -->
     @if(Session::has('message'))
     <div class="alert {{ Session::get('alert-class') }}">
        {{ Session::get('message') }}
     </div>
     @endif
     <!-- Alert message (end) -->

     <div class="actionbutton">

        <a class='btn btn-info float-right' href="{{route('species')}}">List</a>

     </div>

     <form action="{{route('species.store')}}" method="post" >
        {{csrf_field()}}

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Name <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
             <input id="desc" class="form-control col-md-12 col-xs-12" name="name" placeholder="Enter description" required="required" type="text">

             @if ($errors->has('name'))
               <span class="errormsg">{{ $errors->first('name') }}</span>
             @endif
          </div>

          <td>
        <br>

        <div class="form-group">
           <div class="col-md-6">

              <input type="submit" name="submit" value='Submit' class='btn btn-success'>
           </div>
        </div>

     </form>

   </div>
</div>
@stop
