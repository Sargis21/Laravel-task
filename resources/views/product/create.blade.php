@extends('layouts.app')

@section('content')

    <div class="container-fluid mb-2">
        <h2 class="text-center">CREATE</h2>
        <a href="{{route('product.index')}}" class="btn btn-primary">Back</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input value="{{old('name')}}" type="text" id="name" name="name" class="form-control">
                        @error('name')
                        <div  class="alert alert-danger mt-2" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input value="{{old('description')}}" type="text" id="description" name="description" class="form-control">
                        @error('description')
                        <div  class="alert alert-danger mt-2" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input value="{{old('price')}}" type="text" id="price" name="price" class="form-control">
                        @error('price')
                        <div  class="alert alert-danger mt-2" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="products">Products</label>
                        <select class="form-control"  name="users[]" id="products" multiple>
                            @foreach($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" id="photo" name="photo[]" class="form-control" multiple>
                        @error('photo')
                        <div  class="alert alert-danger mt-2" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
