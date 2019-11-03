<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        // set the model
        $this->model = new Repository($user);
    }

    public function index()
    {
        return $this->model->all();
    }


    public function create()
    {
        return $this->model->create();
    }


    public function store(UserRequest $request)
    {
        return $this->model->storeModel($request);
    }


    public function show(User $user)
    {
        return $this->model->show($user);
    }


    public function edit(User $user)
    {
        return $this->model->edit($user);
    }


    public function update(UserEditRequest $request, User $user)
    {
        return $this->model->update($request,$user);
    }


    public function destroy(Request $request, User $user)
    {
        return $this->model->delete($request, $user);
    }
}
