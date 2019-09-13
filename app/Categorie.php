<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image, Session;

class Categorie extends Model
{
  static public function save_new($request)
  {
    $image_name = 'No_Image_Available.jpg';

    if ($request->hasFile('image') && $request->file('image')->isValid()) {

      $file = $request->file('image');

      $image_name = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

      $request->file('image')->move(public_path() . '/images/', $image_name);

      $img = Image::make(public_path() . '/images/' . $image_name);
      $img->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $img->save();
    }

    $category = new self();
    $category->title = $request['title'];
    $category->description = $request['description'];
    $category->url = $request['url'];
    $category->image = $image_name;
    $category->save();
    Session::flash('sm', 'Category created successfuly');
    Session::flash('smpos', 'toast-top-center');
  }

  static public function update_item($request, $id)
  {
    $image_name = '';

    if ($request->hasFile('image') && $request->file('image')->isValid()) {

      $file = $request->file('image');

      $image_name = date('Y.m.d.H.i.s') . '-' .  $file->getClientOriginalName();

      $request->file('image')->move(public_path() . '/images/', $image_name);

      $img = Image::make(public_path() . '/images/' . $image_name);
      $img->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $img->save();
    }

    $category = self::find($id);
    $category->title = $request['title'];
    $category->description = $request['description'];
    $category->url = $request['url'];

    if ($image_name) {
      $category->image = $image_name;
    };

    $category->save();
    Session::flash('sm', 'Category updated successfuly');
    Session::flash('smpos', 'toast-top-center');
  }
}
