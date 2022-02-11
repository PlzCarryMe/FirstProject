<!-- Extends template page-->
@extends('layouts.app')

@section('script')
<script>
    $(document).ready( function () {

        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                     "url": "{{ route('allroles') }}",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },

            columns: [
                { "data": "description"},
                { "data": "user[ | ]"},
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

      <h3>Role List</h3>
      <a class='btn btn-info float-left' href="{{route('role.create')}}">Add</a>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th width='40%'>description</th>
            <th width='40%'>user</th>
            <th width='20%'>actions</th>
          </tr>
        </thead>
        <tbody>
        {{-- @foreach($roles as $role)
           <tr>
              <td>{{ $role->description }}</td>

              <td>
              @foreach ($role->users as $user)
              {{ $user->name}} |
              @endforeach
              </td>

              <td>
                 <!-- Edit -->
                 <a href="{{ route('role.edit',[$role->id]) }}" class="btn btn-sm btn-info">Edit</a>
                 <!-- Delete -->
                 <a href="{{ route('role.delete',$role->id) }}" class="btn btn-sm btn-danger">Delete</a>
              </td>
           </tr>
        @endforeach --}}
        </tbody>
     </table>

   </div>
</div>
@endsection
