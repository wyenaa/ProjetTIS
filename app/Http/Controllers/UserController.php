<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Register user baru
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Simpan user
    $user = User::create([
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => app('hash')->make($request->input('password')),
    ]);

    return response()->json(['message' => 'User registered successfully'], 201);
}

    // Login user
    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    if (Hash::check($request->password, $user->password)) {
    return response()->json([
        'message' => 'Login successful',
        'user'    => [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'phone'    => $user->phone,
            'address'  => $user->address,
            'photo'    => $user->photo,
        ]
    ]);
}

    return response()->json(['message' => 'Invalid password'], 401);
}

    // List semua user
    public function index()
    {
        return response()->json(User::all());
    }

    // Detail user by id
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    // Update user by id
    public function update(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $validator = Validator::make($request->all(), [
    'username' => 'nullable|string|unique:users,username,' . $id,
    'email'    => 'nullable|email|unique:users,email,' . $id,
    'password' => 'nullable|min:6',
    'phone'    => 'nullable|string',
    'address'  => 'nullable|string',
    'photo'    => 'nullable|image|max:2048',
]);

if ($validator->fails()) {
    return response()->json(['errors' => $validator->errors()], 422);
}




    $user->username = $request->input('username', $user->username);
    $user->email    = $request->input('email', $user->email);
    $user->phone    = $request->input('phone', $user->phone);
    $user->address  = $request->input('address', $user->address);

    // Upload foto profil jika ada
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/profile'), $filename);
        $user->photo = url('uploads/profile/'.$filename);
    }

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return response()->json($user);
}


    // Delete user by id
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}