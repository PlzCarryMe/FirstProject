<!-- Extends template page -->
@extends('layouts.app')

<!-- Specify content -->
@section('content')

<h3>Add Pets</h3>

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

        <a class='btn btn-info float-right' href="{{route('pets')}}">List</a>

     </div>

     <form action="{{route('pets.store')}}" method="post" >
        {{csrf_field()}}

        <div class="form-group">

          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Date of Birth <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="date" id="DoB" name="date_of_birth" required = required>
          </div>

          <br>

          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">User List <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              @foreach ($users as $user)
                <input type="radio" name="users_id" required = required value="{{$user->id}} ">
                {{$user->name}}
              @endforeach
          </div>

          <br>

          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Pet Name List <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">

            @foreach ($petnames as $petname)
                <input type="radio" name="petnames_id" required = required value="{{$petname->id}}">
                {{$petname->name}}
            @endforeach
          </div>

          <br>

          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Species List <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">

            @foreach ($species as $species)
                <input type="radio" name="species_id" required = required value="{{$species->id}}">
                {{$species->name}}
            @endforeach
          </div>

          {{-- <label class="control-label col-md-3 col-sm-3 col-xs-12" for="species">Species: </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="country" name="species_id" value="" readonly>
          </div> --}}

          {{-- <div class="col-md-6 col-sm-6 col-xs-12">
              @foreach ($petnames as $petname)
                <input type="radio" name="petnames_id" value="{{$petname->id}}">
                {{$petname->name}}
              @endforeach
          </div> --}}

        </div>

        <div class="form-group">
           <div class="col-md-6">
              <input type="submit" name="submit" value='Submit' class='btn btn-success'>
           </div>
        </div>

     </form>

   </div>
</div>
@stop
