<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class CmsController extends MainController
{
    public function dashboard()
    {
        return view('cms.dashboard', self::$data);
    }

    public function orders()
    {
        Order::getAll(self::$data);
        return view('cms.orders', self::$data);
    }
}
