<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Content extends Model
{
    static public function getAll($url, &$data)
    {
        if ($menu = Menu::where('url', '=', $url)->first()) {
            $data['contents'] = Menu::find($menu->id)->contents;
            $data['title'] = $menu->title;
            $data['url'] = $url;
        } else {
            abort(404);
        }
    }
    static public function save_new($request)
    {
        $content = new self();
        $content->menu_id = $request['menu_id'];
        $content->ctitle = $request['ctitle'];
        $content->article = $request['article'];
        $content->save();
        Session::flash('sm', 'Content created successfuly');
        Session::flash('smpos', 'toast-top-center');
    }

    static public function update_item($request, $id)
    {
        $content = self::find($id);
        $content->menu_id = $request['menu_id'];
        $content->ctitle = $request['ctitle'];
        $content->article = $request['article'];
        $content->save();
        Session::flash('sm', 'Content updated successfuly');
        Session::flash('smpos', 'toast-top-center');
    }
}
