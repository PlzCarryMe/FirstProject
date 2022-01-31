<!-- Extends template page-->
@extends('layouts.app')

<!-- Specify content -->
@section('content')



<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <!-- Alert message (start) -->
      @if(Session::has('message'))
      <div class="alert {{ Session::get('alert-class') }}">
         {{ Session::get('message') }}
      </div>
      @endif
      <!-- Alert message (end) -->

      <h3>Pets List</h3>
      <a class='btn btn-info float-left' href="{{route('pets.create')}}">Add</a>

      <table class="table" >
        <thead>
          <tr>
            <th width='20%'>Birth Date</th>
            <th width='20%'>User</th>
            <th width='20%'>Pet Name</th>
            <th width='20%'>Species</th>
            <th width='20%'>Actions</th>
          </tr>
        </thead>
        <tbody>

        @foreach($pets as $pets)
           <tr>

              <td>
              {{-- @foreach ($role->users as $user)
              {{ $user->name}} |
              @endforeach --}}

                {{$pets->date_of_birth}}
              </td>

              <td>{{ $pets->users->name}}</td>
              <td>{{ $pets->petnames->name}}</td>
              <td>{{ $pets->species->name }}</td>

              <td>
                 <!-- Edit -->
                 <a href="{{ route('pets.edit',[$pets->id]) }}" class="btn btn-sm btn-info">Edit</a>
                 <!-- Delete -->
                 <a href="{{ route('pets.delete',$pets->id) }}" class="btn btn-sm btn-danger">Delete</a>
              </td>
           </tr>
        @endforeach

        </tbody>
     </table>

   </div>
</div>
@stop
