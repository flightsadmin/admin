<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
        $social = Socialite::driver($provider)->user();
        $existingUser = User::where('email', $social->email)->where('auth_type', $provider)->first();
        if($existingUser) {
            Auth::login($existingUser);
            return redirect(route(config('admin.blogRoute')));
        } else {
            $uuid = Str::uuid()->toString();

            $newUser = new User();
            $newUser->name =  $social->name;
            $newUser->email = $social->email;
            $newUser->photo = $social->avatar;
            $newUser->phone = '+254700000000';
            $newUser->title = 'Developer';
            $newUser->password = Hash::make($uuid.now());
            $newUser->auth_type = $provider;
            $newUser->save();
            $newUser->syncRoles(['1']);

            Auth::login($newUser);
            return redirect(route(config('admin.blogRoute')));
        }
    }
}