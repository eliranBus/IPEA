<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB, Cart, Session, Image;
use Illuminate\Http\Request;

class Product extends Model
{
    static public function getProducts($curl, &$data, Request $request)
    {
        $products = DB::table('products AS p')
            ->join('categories AS c', 'c.id', '=', 'p.categorie_id')
            ->select('p.*', 'c.url', 'c.title')
            ->where('c.url', '=', $curl);
        if (isset($request['sort'])) {
            if ($request['sort'] == 'asc') {
                $products = DB::table('products AS p')
                    ->join('categories AS c', 'c.id', '=', 'p.categorie_id')
                    ->select('p.*', 'c.url', 'c.title')
                    ->where('c.url', '=', $curl)
                    ->orderBy('price', 'asc');
            } elseif ($request['sort'] == 'desc') {
                $products = DB::table('products AS p')
                    ->join('categories AS c', 'c.id', '=', 'p.categorie_id')
                    ->select('p.*', 'c.url', 'c.title')
                    ->where('c.url', '=', $curl)
                    ->orderBy('price', 'desc');
            }
        }
        if ($data['total_count'] = $products->count()) {
            $products = $products->paginate(2);
            $data['products'] = $products;
            $data['title'] = $products[0]->title . ' Products';
        } else {
            abort(404);
        }
    }

    static public function getItem($purl, &$data)
    {
        if ($item = self::where('purl', '=', $purl)->first()) {
            $data['product'] = $item->toArray();
            $data['title'] = $data['product']['ptitle'];
        } else {
            abort(404);
        }
    }

    static public function addToCart($pid)
    {
        if (!empty($pid) && Is_numeric($pid)) {
            if ($product =  self::find($pid)) {
                $product = $product->toArray();
                if (!Cart::get($pid)) {
                    Cart::add($pid, $product['ptitle'], $product['price'], 1, []);
                    Session::flash('sm',  $product['ptitle'] . ' added to cart');
                    Session::flash('smpos', 'toast-bottom-center');
                }
            }
        }
    }

    static public function updateCart($request)
    {
        if (!empty($request['pid']) && is_numeric($request['pid'])) {

            if (!empty($request['op'])) {

                if ($product = Cart::get($request['pid'])) {

                    $product = $product->toArray();

                    if ($request['op'] == 'plus') {

                        Cart::update($request['pid'], ['quantity' => 1]);
                    } elseif ($request['op'] == 'minus') {

                        Cart::update($request['pid'], ['quantity' => -1]);
                    }
                }
            }
        }
    }

    static public function save_new($request)
    {
        $image_name = 'No_Image_Available.jpg';
        $image_name2 = 'No_Image_Available.jpg';
        $image_name3 = 'No_Image_Available.jpg';
        $image_name4 = 'No_Image_Available.jpg';
        $image_name5 = 'No_Image_Available.jpg';

        if ($request->hasFile('pimage') && $request->file('pimage')->isValid()) {

            $file = $request->file('pimage');

            $image_name = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage')->move(public_path() . '/images/', $image_name);

            $img = Image::make(public_path() . '/images/' . $image_name);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }
        if ($request->hasFile('pimage2') && $request->file('pimage2')->isValid()) {

            $file = $request->file('pimage2');

            $image_name2 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage2')->move(public_path() . '/images/', $image_name2);

            $img2 = Image::make(public_path() . '/images/' . $image_name2);
            $img2->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img2->save();
        }
        if ($request->hasFile('pimage3') && $request->file('pimage3')->isValid()) {

            $file = $request->file('pimage3');

            $image_name3 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage3')->move(public_path() . '/images/', $image_name3);

            $img3 = Image::make(public_path() . '/images/' . $image_name3);
            $img3->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img3->save();
        }
        if ($request->hasFile('pimage4') && $request->file('pimage4')->isValid()) {

            $file = $request->file('pimage4');

            $image_name4 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage4')->move(public_path() . '/images/', $image_name4);

            $img4 = Image::make(public_path() . '/images/' . $image_name4);
            $img4->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img4->save();
        }
        if ($request->hasFile('pimage5') && $request->file('pimage5')->isValid()) {

            $file = $request->file('pimage5');

            $image_name5 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage5')->move(public_path() . '/images/', $image_name5);

            $img5 = Image::make(public_path() . '/images/' . $image_name5);
            $img5->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img5->save();
        }

        $product = new self();
        $product->categorie_id = $request['categorie_id'];
        $product->ptitle = $request['ptitle'];
        $product->article = $request['article'];
        $product->purl = $request['purl'];
        $product->pimage =  $image_name;
        $product->pimage2 =  $image_name2;
        $product->pimage3 =  $image_name3;
        $product->pimage4 =  $image_name4;
        $product->pimage5 =  $image_name5;
        $product->price = $request['price'];
        $product->specification1 = $request['specification1'];
        $product->specification2 = $request['specification2'];
        $product->specification3 = $request['specification3'];
        $product->feedback1 = $request['feedback1'];
        $product->feedback2 = $request['feedback2'];
        $product->save();
        Session::flash('sm', 'Product created successfuly');
        Session::flash('smpos', 'toast-top-center');
    }

    static public function update_item($request, $id)
    {
        $image_name = '';
        $image_name2 = '';
        $image_name3 = '';
        $image_name4 = '';
        $image_name5 = '';

        if ($request->hasFile('pimage') && $request->file('pimage')->isValid()) {

            $file = $request->file('pimage');

            $image_name = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage')->move(public_path() . '/images/', $image_name);

            $img = Image::make(public_path() . '/images/' . $image_name);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }
        if ($request->hasFile('pimage2') && $request->file('pimage2')->isValid()) {

            $file = $request->file('pimage2');

            $image_name2 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage2')->move(public_path() . '/images/', $image_name2);

            $img2 = Image::make(public_path() . '/images/' . $image_name2);
            $img2->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img2->save();
        }
        if ($request->hasFile('pimage3') && $request->file('pimage3')->isValid()) {

            $file = $request->file('pimage3');

            $image_name3 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage3')->move(public_path() . '/images/', $image_name3);

            $img3 = Image::make(public_path() . '/images/' . $image_name3);
            $img3->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img3->save();
        }
        if ($request->hasFile('pimage4') && $request->file('pimage4')->isValid()) {

            $file = $request->file('pimage4');

            $image_name4 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage4')->move(public_path() . '/images/', $image_name4);

            $img4 = Image::make(public_path() . '/images/' . $image_name4);
            $img4->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img4->save();
        }
        if ($request->hasFile('pimage5') && $request->file('pimage5')->isValid()) {

            $file = $request->file('pimage5');

            $image_name5 = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

            $request->file('pimage5')->move(public_path() . '/images/', $image_name5);

            $img5 = Image::make(public_path() . '/images/' . $image_name5);
            $img5->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img5->save();
        }

        $product = self::find($id);
        $product->categorie_id = $request['categorie_id'];
        $product->ptitle = $request['ptitle'];
        $product->article = $request['article'];
        $product->purl = $request['purl'];

        if ($image_name) {
            $product->pimage = $image_name;
        }
        if ($image_name2) {
            $product->pimage2 = $image_name2;
        }
        if ($image_name3) {
            $product->pimage3 = $image_name3;
        }
        if ($image_name4) {
            $product->pimage4 = $image_name4;
        }
        if ($image_name5) {
            $product->pimage5 = $image_name5;
        }

        $product->price = $request['price'];
        $product->specification1 = $request['specification1'];
        $product->specification2 = $request['specification2'];
        $product->specification3 = $request['specification3'];
        $product->feedback1 = $request['feedback1'];
        $product->feedback2 = $request['feedback2'];
        $product->save();
        Session::flash('sm', 'Product updated successfuly');
        Session::flash('smpos', 'toast-top-center');
    }

    static public function searchProducts(&$data)
    {
        $term = $data['term'];
        $data = DB::table('products')
            ->where("ptitle", "LIKE", "%$term%")
            ->get();
        foreach ($data as $result) {
            $results[] = ['value' => $result->ptitle, 'link' => url('shop/' . $result->categorie_url . '/' . $result->purl)];
        }
        return response()->json($results);
    }
}
