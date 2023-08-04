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
            'nik' => 'required',
            'role_id' => 'required',
            'jadwalkerja_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'name'     => 'required',
            'email'   => 'required',
            'position_id' => 'required',
            'dob' => 'required',
            'phone_number' => 'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required' 
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $nikGenerate = 'AB' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/users', $image->hashName());

        //create post
        $user = User::create([
            'nik' => $nikGenerate,
            'role_id'   => $request->role_id,
            'jadwalkerja_id'   => $request->jadwalkerja_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name'     => $request->name,
            'email'   => $request->email,
            'dob' => $request->dob,
            'phone_number' => $request->phone_number,
            'image'     => $image->hashName(),
            'password'   => $request->password,
            'position_id'   => $request->position_id
        ]);

        //return response
        return new UserResource(true, 'Data Post Berhasil Ditambahkan!', $user);
    }

    public function show(Request $request, $id) {
        
        $user = User::with('absensi')->find($id);

        return new UserResource(true, 'Data Berhasil Ditampilkan', $user);
    }

    public function update(Request $request, User $user, $id)
    {
        $user = User::find($id);
        
        if(!$user) {
            return response()->json(['message'=>'User not found'], 404);
        }
        //define validation rules
        $validator = Validator::make($request->all(), [
            // 'nik' => 'required',
            'role_id' => 'required',
            'jadwalkerja_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'name'     => 'required',
            'email'   => 'required',
            'position_id' => 'required',
            'dob' => 'required',
            'phone_number' => 'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required' 
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

            // $nikGenerate = 'AB' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

            //update post with new image
            $user->update([
                // 'nik' => $nikGenerate,
                'role_id'   => $request->role_id,
                'jadwalkerja_id'   => $request->jadwalkerja_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name'     => $request->name,
                'email'   => $request->email,
                'dob' => $request->dob,
                'phone_number' => $request->phone_number,
                'image'     => $image->hashName(),
                'password'   => $request->password,
                'position_id'   => $request->position_id
            ]);

        } else {

            //update post without image
            $user->update([
                'role_id'   => $request->role_id,
                // 'jadwalkerja_id'   => $request->jadwalkerja_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name'     => $request->name,
                'email'   => $request->email,
                'dob' => $request->dob,
                'phone_number' => $request->phone_number,
                'password'   => $request->password,
                'position_id'   => $request->position_id
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