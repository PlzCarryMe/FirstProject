<!-- Extends template page-->
@extends('layouts.app')

@section('script')
<script>
    $(document).ready( function () {

        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                     "url": "{{ route('allpetnames') }}",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },

            columns: [
                { "data": "id"},
                { "data": "name"},
                { "data": "species[ | ]"},
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

      <h3>Pet Name List</h3>
      <a class='btn btn-info float-left' href="{{route('petnames.create')}}">Add</a>

      <table class="table" id="dataTable">
        <thead>
          <tr>
            <th width='30%'>id</th>
            <th width='30%'>Name</th>
            <th width='25%'>Species</th>
            <th width='25%'>Action</th>
          </tr>
        </thead>
        <tbody>
        {{-- @foreach($petnames as $petname)
           <tr>
              <td>{{ $petname->id }}</td>

              <td> {{$petname->name}} </td>

            <td>
              @foreach ($petname->pets as $pet)
                {{$pet->species->name}} |
              @endforeach
            </td>


              <td>
                 <!-- Edit -->
                 <a href="{{ route('petnames.edit',[$petname->id]) }}" class="btn btn-sm btn-info">Edit</a>
                 <!-- Delete -->
                 <a href="{{ route('petnames.delete',$petname->id) }}" class="btn btn-sm btn-danger">Delete</a>
              </td>
           </tr>
        @endforeach --}}
        </tbody>
     </table>

   </div>
</div>
@stop
