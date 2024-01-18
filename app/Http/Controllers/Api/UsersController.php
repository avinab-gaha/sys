<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $response = ['success' => TRUE, 'data' => $users, 'message' => 'OK'];
        return response()->json($response);
    }

    public function create(Request $request)
    {

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->all()], status: 409);
        }

        try {

            $user = User::where('email', $request->email)->first();

            if (!$user) {

                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                ]);
            }
            return response()->json(['success' => TRUE, 'data' => $user, 'message' => 'User created successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['success' => FALSE, 'message' => 'Error fetching user data'], 500);
        }
    }
    public function show(string $id)
    {
        $user = User::find($id);
        $response = ['success' => TRUE, 'data' => $user, 'message' => 'OK'];
        return response()->json($response);
    }

    // public function showId($id) {
    //     $user = User::find($id);
    //     if(is_null($user)) {
    //         return response()->json($user);
    //     }
    //     return response()->json($user::find($id), 200);
    // }
    /**
     * Update the specified resource in storage.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $response = ['success' => TRUE, 'data' => $user, 'message' => 'OK'];
        return response()->json($response);
    }

    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        $user->save();
        $response = ['success' => TRUE, 'data' => $user, 'message' => 'OK'];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => FALSE, 'message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['success' => TRUE, 'data' => $user, 'message' => 'User deleted successfully']);
    }

    //login
    public function login(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->all()], status: 409);
        }

        try {
            $user = User::where('email', $request->email)->get()->first();
            if ($user) {
                $password = $request->password;

                if (Hash::check($password, $user->password)) {
                    return response()->json(['user' => $user]);
                }
                //$user = User::create($request->all());
            }
            return response()->json(['success' => TRUE, 'data' => $user, 'message' => 'User created successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['success' => FALSE, 'message' => 'Error fetching user data'], 500);
        }
    }

}
