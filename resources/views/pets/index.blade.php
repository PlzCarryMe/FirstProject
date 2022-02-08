<!-- Extends template page-->
@extends('layouts.app')

@section('script')
<script>
    $(document).ready( function () {

        $('#dataTable').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ajax:{
                     "url": "{{ route('allpets') }}",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },

            columns: [
                { "data": "birth"},
                { "data": "user"},
                { "data": "petname"},
                { "data": "species"},
                { "data": "actions", orderable: false },
            ]
        });

      $("#dataTable_filter.dataTables_filter").append($("#categoryFilter"));

      var categoryIndex = 0;
      $("#dataTable th").each(function (i) {
        if ($($(this)).html() == "Species") {
          categoryIndex = i; return false;
        }
      });

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = $('#categoryFilter').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );

      $("#dataTable").change(function (e) {
        table.draw();
      });
      table.draw();

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

      <h3>Pets List</h3>
      <a class='btn btn-info float-left' href="{{route('pets.create')}}">Add</a>

      <div class="category-filter">
        <select id="categoryFilter" class="form-control">
            <option value="">Show All</option>
            @foreach ($species as $species)
                <option value="{{$species->name}}">{{$species->name}}</option>
            @endforeach

        </select>
      </div>

      <table class="table" id="dataTable" >
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

        {{-- @foreach($pets as $pets)
           <tr>
              <td>
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
        @endforeach --}}

        </tbody>
     </table>

   </div>
</div>
@stop
