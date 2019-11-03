@extends('layouts.app')

@section('content')

    <div class="container">
        <a class="btn btn-success" href="{{route('user.index')}}">Back</a>
        <div class="row">
            <div class="col-md-12 text-md-center mt-5">
                <span>USER</span>
                <h1>{{$item->name}}</h1>
                @if($item->images->pluck('img')->implode(', '))
                    @foreach($item->images as $it)
                        <img width="250" src="{{asset($it->img)}}" alt="user">
                    @endforeach
                @else
                    <img width="250" src="{{asset('images/nofoto.jpg')}}" alt="user">
                @endif
                <hr>
            </div>
            @if($item->products->pluck('name')->implode(' '))

            <div class="col-md-12 text-md-center">
                <span>Products</span>
                <h2>{{$item->products->pluck('name')->implode(', ')}}</h2>,
                <p>{{$item->products->pluck('description')->implode(' ')}}</p>
                <p>{{$item->products->pluck('price')->implode('$, ')}}$</p>

            </div>
                {{--<div class="col-md-12 text-md-center">--}}
                    {{--<span>description</span>--}}
                    {{--<h2>{{$item->products->pluck('description')->implode(' ')}}</h2>--}}
                {{--</div>--}}
                {{--<div class="col-md-12 text-md-center">--}}
                    {{--<span>price</span>--}}
                    {{--<h2>{{$item->products->pluck('price')->implode(', ')}}</h2>--}}
                {{--</div>--}}
            @endif
        </div>
    </div>

@endsection
