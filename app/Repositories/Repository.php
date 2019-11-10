<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\User;
use App\Image;

class Repository
{
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $items = $this->model::with('products','images')->get();
        return view('user.index',compact('items'));
    }

    public function create()
    {
        return view('user.create',['items'=>Product::get()]);
    }

    public function storeModel(UserRequest $request)
    {
        $item = $this->model::create($request->only('name'));
        if($request->input('products')): $item->products()->attach($request->input('products'));endif;

        if($request->hasFile('photo')):
            foreach ($request->file('photo') as $file)
            {
                $item->images()->create([
                    'img' => $file->store('images')
                ]);
            }
        endif;

        return redirect()->route('user.show',$item);
    }

    public function edit(User $user)
    {
        return view('user.edit',['user'=>$user,'items'=>Product::all()]);
    }

    public function update(UserEditRequest $request, User $user)
    {
        $user->update($request->only('name'));
        $user->products()->detach();
        if ($request->products): $user->products()->attach($request->products); endif;

        if($request->hasFile('photo')):
            foreach ($request->file('photo') as $file)
            {
                $user->images()->create([
                    'img' => $file->store('images')
                ]);
            }
        endif;

        if ($request->img){
            foreach ($request->img as $imageName) {
                $user->images()->where('img',$imageName)->delete();
                Storage::delete($imageName);
            }
        }
        return redirect()->route('user.show',$user);
    }


    public function delete(User $user)
    {
        Storage::delete($user->images()->pluck('img')->toArray());
        $user->products()->detach();
        $user->images()->delete();
        $user->delete();

        return redirect()->route('user.index');
    }


    public function show(User $user)
    {
        return view('user.show',['item'=>$user]);
    }



}
