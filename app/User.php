<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Hash;
use Session;

class User extends Model
{
    static public function validateUser($email, $password)
    {

        $valid = false;

        $user = DB::table('users AS u')
            ->join('users_roles AS ur', 'u.id', '=', 'ur.uid')
            ->where('u.email', '=', $email)
            ->first();

        if ($user && Hash::check($password, $user->password)) {

            $valid = true;
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);

            if ($user->rid == 6) {
                Session::put('is_admin', true);
            }
            Session::flash('sm', 'Welcome back, ' . $user->name);
            Session::flash('smpos', 'toast-top-center');
        }

        return $valid;
    }

    static public function save_new($request)
    {
        $user = new self();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        $uid = $user->id;
        DB::insert("INSERT INTO users_roles VALUES($uid, 7)");
        Session::put('user_id', $uid);
        Session::put('user_name', $request['name']);
        Session::flash('sm', 'Welcome, ' . $request['name']) . '. You signed up successfuly.';
        Session::flash('smpos', 'toast-top-center');
    }
}
