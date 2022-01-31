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


      <h3>User List</h3>
      <a class='btn btn-info float-left' href="{{route('subjects.create')}}">Add</a>


      <table class="table" >
        @foreach($subjects as $subject)
        <thead>
          <tr>
            <th width='40%'>Name</th>
            <th width='30%'>Roles</th>
            <th width='30%'>Actions</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $subject->name }}</td>
                <td>
                    @foreach ($subject->roles as $role)
                    {{ $role->description}} |
                    @endforeach
                </td>
                <td>
                    <!-- Edit -->
                    <a href="{{ route('subjects.edit',$subject->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <!-- Delete -->
                    <a href="{{ route('subjects.delete',$subject->id) }}" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <tr>
                <div class="table">
                <thead align="center">
                    <tr>
                    <th width='25%'>Pet Name</th>
                    <th width='25%'>Species</th>
                    <th width='25%'>Date of Birth</th>
                    </tr>
                </thead>
                <tbody align="center">

                    @foreach ($subject->pets as $pet)
                    <tr>
                        <td>{{$pet->petnames->name}}</td>
                        <td>{{$pet->species->name}}</td>
                        <td>{{$pet->date_of_birth}}</td>
                    </tr>
                    @endforeach

                </tbody>
                </div>
            </tr>
            @endforeach
        </tbody>
     </table>

   </div>
</div>
@stop
