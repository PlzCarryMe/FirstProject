<!-- Extends template page-->
@extends('layouts.app')

@section('script')
<script>
    $(document).ready( function () {

    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                    "url": "{{ route('allspecies') }}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },

        columns: [
            { "data": "id"},
            { "data": "species"},
            { "data": "petnames[ | ]"},
            { "data": "actions", orderable: false},
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

      <h3>Species List</h3>
      <a class='btn btn-info float-left' href="{{route('species.create')}}">Add</a>

      <table class="table" id="dataTable">
        <thead>
          <tr>
            <th width='30%'>id</th>
            <th width='30%'>Species</th>
            <th width='30%'>Pet Name</th>
            <th width='20%'>Action</th>
          </tr>
        </thead>
        <tbody>
        {{-- @foreach($species as $species)
           <tr>
              <td>{{ $species->id }}</td>

              <td> {{$species->name}} </td>

              <td>
                @foreach ($species->pets as $pet)
                    {{ $pet->petnames->name}} |
                @endforeach
              </td>

              <td>
                 <!-- Edit -->
                 <a href="{{ route('species.edit',[$species->id]) }}" class="btn btn-sm btn-info">Edit</a>
                 <!-- Delete -->
                 <a href="{{ route('species.delete',$species->id) }}" class="btn btn-sm btn-danger">Delete</a>
              </td>
           </tr>
        @endforeach --}}

        </tbody>
     </table>

   </div>
</div>
@stop
