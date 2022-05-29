@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @foreach ($products['data'] as $product )
            <div class="row">
                <ul>
                    <h3>{{$product['id']}}</h3>
                    <div class="col-sm-4">{{$product['first_name']}}</div>
                    <div class="col-sm-4">{{$product['last_name']}}</div>
                    <div class="col-sm-4">{{$product['email']}}</div>
                </ul>
            </div>
            @endforeach



        </div>
    </div>
</div>
@endsection
