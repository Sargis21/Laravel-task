@extends('layouts.app')

@section('content')

    <div class="container">
        <a class="btn btn-success" href="{{route('product.index')}}">Back</a>
        <div class="row">
            <div class="col-md-12 text-md-center mt-5">
                <span>PRODUCT</span>
                <h1>{{$item->name}}</h1>

                @if($item->images->pluck('img')->implode(', '))
                    @foreach($item->images as $it)
                        <img width="250" src="{{asset($it->img)}}" alt="product">
                    @endforeach
                @else
                    <img width="250" src="{{asset('images/nofoto.jpg')}}" alt="product">
                @endif
                <h4>{{$item->description}}</h4>
                <b>{{$item->price}}$</b>

                <hr>
            </div>

            @if($item->users->pluck('name')->implode(' '))
            <div class="col-md-12 text-md-center">
                <span>Users</span>
                <h2>{{$item->users->pluck('name')->implode(', ')}}</h2>
            </div>
            @endif

        </div>
    </div>

@endsection
