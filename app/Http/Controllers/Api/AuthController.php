<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'name'  => 'required|string',
            'email' => 'required|email|unique:users',
            'dob' => 'required|date_format:Y-m-d',
            'phone_number' => 'required',
            'image' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Data yang anda masukkan tidak valid",
                'errors' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        // Generate NIK dengan format 23 + Angka Random 6 DIGIT
        $input['nik'] = '23' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $user = User::create($input);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;
        $success['nik'] = $user->nik;
        return response()->json([
            'success'   => true,
            'message'   => "Registrasi berhasil",
            'data'      => $success
        ]);
    }

    public function showRegister() {

    }

    public function login(Request $request) {
        if(Auth::attempt(['nik' => $request->nik, 'password' => $request->password])) {
            // Authentication passed...
            $user = User::with('role', 'position', 'jadwalkerja')->where('nik', $request->nik)->first();
            $role = $user->role->name;
            $position = $user->position->name;
            // $jadwalkerja = $user->jadwalkerja->slug;
            
            if($user){
                $success['token'] = $user->createToken('auth_token')->plainTextToken;
                $success['name'] = $user->name;
                $success['nik'] = $user->nik;
                $success['role'] = $role; 
                $success['id'] = $user->id;
                $success['first_name'] = $user->first_name;
                $success['last_name'] = $user->last_name;
                $success['email'] = $user->email;
                $success['dob'] = $user->dob;
                $success['phone_number'] = $user->phone_number;
                $success['image'] = $user->image;
                $success['position'] = $position;
                // $success['jadwalkerja'] = $jadwalkerja;
                return response()->json([
                    'success'=> true,
                    'message' => 'Login Berhasil',
                    'data' => $success
                ]);
            } else {
                return response()->json([
                    'success'=>false,
                    'error'=>'NIK Tidak Terdaftar!',
                    'data' => null
                    ]);
            }
        }
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User Succesfully Inactive'
        ]);
    }

    public function logined(Request $request) {
        return response()->json(Auth::user());
    }

    
public function getCsrfCookie()
{
    return response()->json(['message' => 'CSRF Cookie obtained'], 200)->withCookie('XSRF-TOKEN', csrf_token());
}
}
