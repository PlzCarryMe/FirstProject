<!-- Extends template page -->
@extends('layouts.app')

<!-- Specify content -->
@section('content')

<h3>Add User</h3>

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

        <a class='btn btn-info float-right' href="{{route('subjects')}}">List</a>

     </div>

     <form action="{{route('subjects.store')}}" method="post" >
        {{csrf_field()}}

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
             <input id="name" class="form-control col-md-12 col-xs-12" name="name" placeholder="Enter user name" required="required" type="text">

             @if ($errors->has('name'))
               <span class="errormsg">{{ $errors->first('name') }}</span>
             @endif
          </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input id="name" class="form-control col-md-12 col-xs-12" name="email" placeholder="Enter user email" required="required" type="text">

               @if ($errors->has('email'))
                 <span class="errormsg">{{ $errors->first('email') }}</span>
               @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input id="name" class="form-control col-md-12 col-xs-12" name="password" placeholder="Enter user password" required="required" type="password">

               @if ($errors->has('password'))
                 <span class="errormsg">{{ $errors->first('password') }}</span>
               @endif
            </div>
          </div>

        <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Roles <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">

            @foreach ($role as $role)

            <input type="checkbox" id= {{$role->id}} name="roles[]" value={{$role->id}}
            >{{$role->description}}<br>

            @endforeach

             @if ($errors->has('roles[]'))
                <span class="errormsg">{{ $errors->first('roles[]') }}</span>
             @endif
            </div>
            <br>
           <div class="col-md-6">
              <input type="submit" name="submit" value='Submit' class='btn btn-success'>
           </div>
        </div>

     </form>

   </div>
</div>
@stop
