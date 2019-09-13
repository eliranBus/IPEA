<?php

namespace App\Http\Controllers;

use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\User;
use Session;

use Illuminate\Http\Request;

class UserController extends MainController
{

    function __construct()
    {
        parent::__construct();
        $this->middleware('signguard', ['except' => ['logout']]);
    }

    public function getSignin()
    {
        self::$data['title'] = 'Signin Page';
        return view('signin', self::$data);
    }
    public function postSignin(SigninRequest $request)
    {
        $rd = !empty($request['rd']) ? $request['rd'] : '';
        if (User::validateUser($request['email'], $request['password'])) {
            return redirect($rd);
        } else {
            self::$data['title'] = 'Signin Page';
            return view('signin', self::$data)->withErrors('Wrong email or password');
        }
    }
    public function getSignup()
    {
        self::$data['title'] = 'Signup Page';
        return view('signup', self::$data);
    }

    public function postSignup(SignupRequest $request)
    {
        User::save_new($request);
        return redirect('');
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect('user/signin');
    }
}
