<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function redireToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('email', $user->email)?->first();

            if ($findUser) {

                $token = $findUser->createToken('my-app-token')->plainTextToken;

                return response()->api([
                    'user' => new UserResource($findUser),
                    'token' => $token
                ]);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => encrypt($user->id),
                    'avatar' => trim($user->avatar, '\\')
                ]);
                $token = $newUser->createToken('my-app-token')->plainTextToken;

                return response()->api([
                    'user' => new UserResource($newUser),
                    'token' => $token
                ]);
            }
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;

            return response()->api($data);
        } else {

            return response()->api([], 1, __('auth.failed'));
        } //end of else

    } //end of login

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        $request->merge([
            'password' => bcrypt($request->password),
        ]);

        $user = User::create($request->all());

        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('my-app-token')->plainTextToken;

        return response()->api($data);
    } //end of register

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        if ($request->get('password')) {
            $request->validate([
                'password' => ['string', 'min:4', 'confirmed'],
            ], [
                'password.confirmed' => 'password confirme',
            ]);
            $validatedData['password'] = Hash::make($request->password);
        }
        $user->update($validatedData);

        return response()->api([
            "user" => $user
        ]);
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();
        return response()->api();
    }
}
