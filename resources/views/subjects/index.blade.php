<!-- Extends template page-->
@extends('layouts.app')

@section('script')
<script>
    $(document).ready( function () {

        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                     "url": "{{ route('allusers') }}",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },

            columns: [
                { "data": "name"},
                { "data": "roles[ | ]"},
                { "data": "pets[ <br> ]"},
                { "data": "actions", orderable: false },
            ]
        });

    });
</script>
@endsection

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

      <table class="table" id="dataTable">
        <thead>
          <tr>
            <th width='25%'>Name</th>
            <th width='30%'>Roles</th>
            <th width='30%'>Pets</th>
            <th width='25%'>Actions</th>
          </tr>
        </thead>
        <tbody>
            {{-- @foreach($subjects as $subject)
            <tr>
                <td>{{ $subject->name }}</td>
                <td>
                    @foreach ($subject->roles as $role)
                    {{ $role->description}} |
                    @endforeach
                </td>
                <td>
                    <ul>
                    @foreach ($subject->pets as $pet)
                        <li>
                            {{$pet->petnames->name}} - {{$pet->species->name}} - {{$pet->date_of_birth}}
                        </li>
                    @endforeach
                    </ul>
                </td>
                <td>
                    <!-- Edit -->
                    <a href="{{ route('subjects.edit',$subject->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <!-- Delete -->
                    <a href="{{ route('subjects.delete',$subject->id) }}" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach --}}
        </tbody>
     </table>

   </div>
</div>
@stop
