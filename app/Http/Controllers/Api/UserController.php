<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index() {
        // get data user
        $user = User::latest()->get();
        
        // return collection dari user resource
        return new UserResource(true, 'Succesfully', $user);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'   => 'required',
            'role' => 'required',
            'position' => 'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required' 
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/users', $image->hashName());

        //create post
        $user = User::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'role'   => $request->role,
            'position'   => $request->position,
            'image'     => $image->hashName(),
            'password'   => $request->password,
        ]);

        //return response
        return new UserResource(true, 'Data Post Berhasil Ditambahkan!', $user);
    }

    public function show(User $user) {

        return new UserResource(true, 'Data Berhasil Ditampilkan', $user);
    }

    public function update(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());

            //delete old image
            Storage::delete('public/users/'.$user->image);

            //update post with new image
            $user->update([
                'name'     => $request->name,
                'email'   => $request->email,
                'role'   => $request->role,
                'position'   => $request->position,
                'image'   => $image->hashName(),
                //  
            ]);

        } else {

            //update post without image
            $user->update([
                'name'     => $request->name,
                'email'   => $request->email,
                'role'   => $request->role,
                'position'   => $request->position,
            ]);
        }

        //return response
        return new UserResource(true, 'Data User Berhasil Diubah!', $user);
    }

    public function destroy(User $user)
    {
        //delete image
        Storage::delete('public/users/'.$user->image);

        //delete user
        $user->delete();

        //return response
        return new UserResource(true, 'Data user Berhasil Dihapus!', null);
    }

    
}