<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Session;

class menu extends Model
{
    public function contents()
    {
        return $this->hasMany('App\content');
    }

    static public function save_new($request)
    {
        $menu = new self();
        $menu->link = $request['link'];
        $menu->url = $request['url'];
        $menu->title = $request['title'];
        $menu->save();
        Session::flash('sm', 'Menu created successfuly');
        Session::flash('smpos', 'toast-top-center');
    }

    static public function update_item($request, $id)
    {
        $menu = self::find($id);
        $menu->link = $request['link'];
        $menu->url = $request['url'];
        $menu->title = $request['title'];
        $menu->save();
        Session::flash('sm', 'Menu updated successfuly');
        Session::flash('smpos', 'toast-top-center');
    }
}
