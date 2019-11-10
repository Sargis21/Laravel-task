@extends('layouts.app')

@section('content')

    <div class="container-fluid mb-2">
        <h2 class="text-center">EDIT</h2>
        <a href="{{route('user.index')}}" class="btn btn-primary">Back</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    {{csrf_field()}}
                    <p>Delete Photo</p>
                    @foreach($user->images as $img)
                        <div style="display: inline-flex" class="form-check">
                            <input value="{{$img->img}}" name="img[]"  type="checkbox" class="form-check-input" id="images{{$img->id}}">
                            <label class="form-check-label" for="images{{$img->id}}"><img width="50" src="{{asset($img->img)}}" alt="user"></label>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input value="{{$user->name}}" type="text" id="name" name="name" class="form-control">
                        @error('name')
                        <div  class="alert alert-danger mt-2" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="products">Products</label>
                        <select class="form-control"  name="products[]" id="products" multiple>
                            @foreach($items as $item)
                                <option @if($user->products->where('id',$item->id)->count()) selected @endif
                                    value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Add Photo</label>
                        <input type="file" id="photo" name="photo[]" class="form-control-file" multiple>
                    </div><hr>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
