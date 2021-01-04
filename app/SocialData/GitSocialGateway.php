<?php

namespace App\SocialData;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\User;
class GitSocialGateway implements SocialGatewayContract{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct(){

    }

    public function siteCall($provider){

        
        return Socialite::driver($provider)->redirect();
    }

    public function siteConnect($provider){

        $user=Socialite::driver($provider)->user();
        $authUser=User::whereEmail($user->getEmail())->first();
        if($authUser){
            auth()->login($authUser);
            return redirect($this->redirectTo);
        }
        $newUser=User::create([
            'name'=>$user->getName(),
            'email'=>$user->getEmail(),
            'password'=>bcrypt("sdasdasdasdas"),

        ]);

        auth()->login($newUser);
        return redirect($this->redirectTo);


    }


}