<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Session;

class ProductsController extends MainController
{

  public function index()
  {
    self::$data['products'] = Product::all()->toArray();
    return view('cms.products', self::$data);
  }

  public function create()
  {
    self::$data['categories'] = Categorie::all()->toArray();
    return view('cms.add_product', self::$data);
  }

  public function store(ProductRequest $request)
  {
    Product::save_new($request);
    return redirect('cms/products');
  }

  public function show($id)
  {
    self::$data['item_id'] = $id;
    return view('cms.delete_product', self::$data);
  }

  public function edit($id)
  {
    self::$data['categories'] = Categorie::all()->toArray();
    self::$data['product_item'] = Product::find($id)->toArray();
    return view('cms.edit_product', self::$data);
  }

  public function update(ProductRequest $request, $id)
  {
    Product::update_item($request, $id);
    return redirect('cms/products');
  }

  public function destroy($id)
  {
    Product::destroy($id);
    Session::flash('sm', 'Item has been deleted');
    Session::flash('smpos', 'toast-top-center');
    return redirect('cms/products');
  }
}
