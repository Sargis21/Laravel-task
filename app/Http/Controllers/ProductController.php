<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductEditRequest;
use App\Http\Requests\ProducteStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\User;
use App\Image;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $items = Product::with('users','images')->orderBy('id', 'desc')->paginate(5);
        return view('product.index',compact('items'));
    }


    public function create()
    {
        return view('product.create',['items'=>User::get()]);

    }


    public function store(ProducteStoreRequest $request)
    {
        $item = Product::create($request->only('name','description','price'));

        if($request->input('users')):
            $item->users()->attach($request->input('users'));
        endif;

        if($request->hasFile('photo')):
            $paths = []; $files = $request->file('photo');
            foreach ($files as $key=> $file)
            {
                $fileName = 'product-'.time().'.'.$file->getClientOriginalExtension();
                $paths[] = $file->storeAs('images',$key.$fileName);
            }
            foreach ($paths as $path): Image::create([
                'product_id'=>$item->id,
                'img'=>$path
            ]);
            endforeach;
        endif;

        return redirect()->route('product.show',$item);
    }


    public function show(Product $product)
    {
        return view('product.show',['item'=>$product]);
    }


    public function edit(Product $product)
    {
        return view('product.edit',['product'=>$product,'items'=>User::all()]);
    }


    public function update(ProductEditRequest $request, Product $product)
    {
        $product->update($request->only('name','description','price'));

        $product->users()->detach();

        if ($request->users): $product->users()->attach($request->users);
        endif;

        if($request->hasFile('photo')):
            $paths = [];
            $files = $request->file('photo');
            foreach ($files as $key=> $file)
            {
                $fileName = 'product-'.time().'.'.$file->getClientOriginalExtension();
                $paths[] = $file->storeAs('images',$key.$fileName);
            }
            foreach ($paths as $path): Image::create([
                'product_id'=>$product->id,
                'img'=>$path
            ]);
            endforeach;
        endif;

        if ($request->img){
            foreach ($request->img as $id) {
                Image::destroy($id);
                Storage::delete($request->imgName);
            }
        }
        return redirect()->route('product.show',$product);
    }


    public function destroy(Request $request,Product $product)
    {
        $product->delete();
        $product->users()->detach();
        $product->images()->delete();
        Storage::delete($request->imgName);
        return redirect()->route('product.index');
    }
}
