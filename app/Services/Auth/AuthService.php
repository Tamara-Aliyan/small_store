<?php
namespace App\Services\Auth;
use Illuminate\Support\Facades\{Auth,Hash};
use App\Models\API\V1\User;

class AuthService
{
    public function login(array $credentials, bool $remember = false)
    {
        if (Auth::attempt($credentials, $remember)) {
            $token = Auth::user()->createToken('api-token')->plainTextToken;
            return $token;
        }

        abort(401, 'Invalid credentials');
    }

    public function signup(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout()
    {
        Auth::guard('web')->logout();
    }


}
