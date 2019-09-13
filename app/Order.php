<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cart, Session, DB;

class Order extends Model
{
    static public function save_new()
    {
        $order = new self();
        $order->user_id = Session::get('user_id');
        $order->data = serialize(Cart::getContent()->toArray());
        $order->total = Cart::getTotal();
        $order->save();
        Cart::clear();
        Session::flash('sm', 'Thank you, your order has been saved.');
        Session::flash('smpos', 'toast-top-center');
    }

    static public function getAll(&$data)
    {
        $data['orders'] = DB::table('orders AS o')
            ->join('users AS u', 'u.id', '=', 'o.user_id')
            ->orderBy('o.created_at', 'desc')
            ->get();
    }
}
