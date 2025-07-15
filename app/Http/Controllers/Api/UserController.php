<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;


class UserController extends Controller
{
    //buscar usuario por id
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    //mostrar todos los usuarios
    public function index()
    {
        $users = User::paginate(10);
        return UserResource::collection($users);
    }  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
