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
        if($request->hasFile('photo')):$paths = []; $files = $request->file('photo');
            foreach ($files as $key=> $file)
            {
                $fileName = 'user-'.time().'.'.$file->getClientOriginalExtension();
                $paths[] = $file->storeAs('images',$key.$fileName);
            }
            foreach ($paths as $path): Image::create([
                    'user_id'=>$item->id,
                    'img'=>$path
                ]);
            endforeach;
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

        if($request->hasFile('photo')): $paths = []; $files = $request->file('photo');
            foreach ($files as $key=> $file)
            {
                $fileName = 'profile-'.time().'.'.$file->getClientOriginalExtension();
                $paths[] = $file->storeAs('images',$key.$fileName);
            }
            foreach ($paths as $path): Image::create([
                    'user_id'=>$user->id,
                    'img'=>$path
                ]);
            endforeach;
        endif;

        if ($request->img){
            foreach ($request->img as $id) {
                $img[] = Image::destroy($id);
                Storage::delete($request->imgName);
            }
        }
        return redirect()->route('user.show',$user);
    }


    public function delete(Request $request, User $user)
    {
        $user->delete();
        $user->products()->detach();
        $user->images()->delete();
        Storage::delete($request->imgName);
        return redirect()->route('user.index');
    }


    public function show(User $user)
    {
        return view('user.show',['item'=>$user]);
    }



}
