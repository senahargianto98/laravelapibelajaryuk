<?php

namespace App\Http\Controllers; 

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function test(Request $request)
    {
        $user = User::with('profile')->find(\Auth::id());
        return ($user);
    }

    public function register(Request $request)
    {

        $rules = [
            'username' => 'required|unique:users,username',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ];
        
        $messages = [
            'username.required' => 'Isi Username Anda',
            'email.required' => 'Isi Email Anda',
            'password.required' => 'Isi Password Anda',
            'password_confrim.required' => 'Isi Password Konfirmasi Anda',

            'same' => 'Password dengan Password Confrim Harus sama',
            'email' => 'Email harus di isikan dengan email valid',
            'unique' => 'Username sudah di gunakan',
        ];
        
        $request->validate($rules,$messages);

        $guest = new User;
        $guest->username = $request->input('username');
        $guest->user_uuid = Uuid::uuid4()->getHex();
        $guest->email = $request->input('email');
        $guest->password = \Hash::make($request->input('password'));
        $guest->save();
        return response($guest);
    }

    public function login(Request $request)
    {
        if (!\Auth::attempt($request->only('username','email', 'password'))) {
            return response([
                'error' => 'invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = \Auth::user();

        $adminLogin = $request->path() === 'api/admin/login';

        if ($adminLogin && !$user->is_admin) {
            return response([
                'error' => 'Access Denied!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $scope = $adminLogin ? 'admin' : 'ambassador';
        $jwt = $user->createToken('token', [$scope])->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60 * 24); // 1 day

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    } 

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();

        $user->update($request->only('username','email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->update([
            'password' => \Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
