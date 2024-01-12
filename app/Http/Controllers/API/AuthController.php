<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        try {
            $this->validate($request->all(), [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'date_of_birth' => 'nullable|date_format:Y-m-d',
                'phone' => 'nullable|string|max:20',
                
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'date_of_birth' => $request->date_of_birth,
                'phone' => $request->phone,
                
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            $this->response->data = ['token' => $token, 'user' => $user];
            $this->response->message[] = 'Your account has been successfully created.';
            return $this->response(201);

           
        } catch(\Exception $e) {            
            $this->response->error[] = $e->getMessage();
            return $this->response(500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = $request->user();
            $token = $user->createToken('authToken')->plainTextToken;

            $this->response->data = ['token' => $token, 'user' => $user];
            return $this->response(200);            
        } catch(\Exception $e) {            
            $this->response->error[] = $e->getMessage();
            return $this->response(500);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',  
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 400);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            $this->response->message[] = 'Logged out';
            return $this->response(200);
        } catch(\Exception $e) {            
            $this->response->error[] = $e->getMessage();
            return $this->response(500);
        }
    }

    public function get_profile() {
        try {
            $this->response->data['auth'] = $this->auth();

            $user = $this->auth();
            $address = User::with('address')->where('id', $user->id)->get();
            dd($address->toArray());


            return $this->response(200);
        } catch(\Exception $e) {            
            $this->response->error[] = $e->getMessage();
            return $this->response(500);
        }
    }

    public function update_profile(Request $request) {       
        try {
            $this->validate($request->all(), [
                'name' => 'required|string|max:200',
                'date_of_birth' => 'nullable|date_format:Y-m-d',
                'phone' => 'nullable|string|max:20',
               
            ]);

            $user = Auth::user();
            $user->name = $request->name; 
            $user->date_of_birth = $request->date_of_birth; 
            $user->phone = $request->phone; 
            $user->save();

            $this->response->data['auth'] = $user;
            $this->response->message[] = 'Your profile has been successfully updated.';
            return $this->response(200);
        } catch(\Exception $e) {
            $this->response->error[] = $e->getMessage();
            return $this->response(500);
        }
    }
}
