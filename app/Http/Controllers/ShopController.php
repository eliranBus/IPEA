<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Categorie;
use App\Product;
use App\Order;
use DB, Cart, Session;

class ShopController extends MainController
{
    public function categories()
    {
        self::$data['categories'] = Categorie::All()->toArray();
        self::$data['title'] = 'Shop Categories';
        $arr = ['The average life-span of a sofa is 2,958 days (that’s roughly 8 years).', 'Have you ever wondered who invented the office chair? It was none-other than Charles Darwin in the 1800s, who added wheels to his chair to get around his study quicker.', 'Throughout a sofa‘s life, it will host roughly 782 visitors.', 'The oldest known chairs were ceremonial furniture from Ancient Egypt 5,000 years ago.', 'Chairs didn’t come into common use until the 16th century. Before then people sat on stones or wooden benches.', 'People sit on their sofa for an average of 4 hours each day.', 'If you ever lose your car/bike key, you 53% chances of finding it between the folds of your sofa.'];
        self::$data['fun'] = Arr::random($arr);
        return view('categories', self::$data);
    }

    public function products($curl, Request $request)
    {
        if (isset($request['sort'])) {
            self::$data['sort'] = $request['sort'];
        }
        Product::getProducts($curl, self::$data, $request);
        self::$data['curl'] = $curl;
        return view('products', self::$data);
    }

    public function item($curl, $purl)
    {
        Product::getItem($purl, self::$data);
        self::$data['purl'] = $purl;
        self::$data['curl'] = $curl;
        return view('item', self::$data);
    }

    public function addToCart(Request $request)
    {
        Product::addToCart($request['pid']);
    }

    public function checkout()
    {
        $cart = Cart::getContent()->toArray();
        sort($cart);
        self::$data['title'] = 'Shop Checkout';
        self::$data['cart'] = $cart;
        return view('checkout', self::$data);
    }

    public function updateCart(Request $request)
    {
        Product::updateCart($request);
        return redirect('shop/checkout');
    }

    public function clearCart()
    {
        Cart::clear();
        return redirect('shop/checkout');
    }

    public function removeItem(Request $request)
    {
        if (Cart::get($request['pid'])) {
            Cart::remove($request['pid']);
        }
        return redirect('shop/checkout');
    }

    public function orderNow()
    {
        if (Cart::isEmpty()) {
            return redirect('shop/checkout');
        } else {
            if (!Session::has('user_id')) {
                return redirect('user/signin?rd=shop/checkout');
            } else {
                Order::save_new();
                return redirect('shop');
            }
        }
    }
}
