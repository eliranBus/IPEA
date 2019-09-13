<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use Session;

class MenuController extends MainController
{

    public function index()
    {
        return view('cms.menu', self::$data);
    }

    public function create()
    {
        return view('cms.add_menu', self::$data);
    }

    public function store(MenuRequest $request)
    {
        Menu::save_new($request);
        return redirect('cms/menu');
    }

    public function show($id)
    {
        self::$data['item_id'] = $id;
        return view('cms.delete_menu', self::$data);
    }

    public function edit($id)
    {
        self::$data['menu_item'] = Menu::find($id)->toArray();
        return view('cms.edit_menu', self::$data);
    }

    public function update(MenuRequest $request, $id)
    {
        Menu::update_item($request, $id);
        return redirect('cms/menu');
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        Session::flash('sm', 'Item has been deleted');
        Session::flash('smpos', 'toast-top-center');
        return redirect('cms/menu');
    }
}
