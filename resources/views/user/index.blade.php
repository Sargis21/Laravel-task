@extends('layouts.app')

@section('content')

    <div class="container-fluid mb-2">
        <h2 class="text-center">USERS</h2>
        <a href="{{route('user.create')}}" class="btn btn-primary">Create User</a>
        <a href="{{url('/')}}" class="btn btn-primary float-md-right">Main Page</a>
    </div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Products</th>
        <th scope="col">Images</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
        <td><a href="{{route('user.show',$item->id)}}">{{$item->name}}</a></td>
        <td>{{$item->products->pluck('name')->implode(', ')}}</td>
        <td>
            @if($item->images->pluck('img')->implode(', '))
                @foreach($item->images as $it)
                    @if($loop->first)
                    <img width="50" src="{{asset($it->img)}}" alt="user">
                    @endif
                @endforeach
                @else
                <img width="50" src="{{asset('images/nofoto.jpg')}}" alt="user">
            @endif
        </td>
        <td><a class="btn btn-primary" href="{{route('user.edit',$item->id)}}">Edit</a></td>
        <td>
            <form onsubmit="if (confirm('Delete ?')){return true}else{return false} " method="POST" action="{{route('user.destroy',$item)}}">
                @method('DELETE')
                @csrf
                @foreach($item->images as $it)
                <input value="{{$it->img}}" name="imgName[]"  type="hidden" class="form-check-input" id="images">
                @endforeach
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </td>
    </tr>
        @endforeach
    </tbody>
</table>

@endsection
