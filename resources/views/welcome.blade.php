@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6"><a href="{{route('user.index')}}"><img src="{{asset('images/user.png')}}" class="img-responsive img-circle" alt="user" ></a></div>
            <div class="col-md-6"><a href="{{route('product.index')}}"><img src="{{asset('images/products.png')}}" class="img-responsive img-circle" alt="products" ></a></div>
        </div>
    </div>

@endsection
