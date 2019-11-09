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

        // connection adding photo logic
        include base_path()."/inc/File.php";

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

        include base_path()."/inc/File.php";


        if ($request->img){
            foreach ($request->img as $id) {
                Image::where('img',$id)->delete();
                Storage::delete($id);
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
