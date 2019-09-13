<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules(request $request)
  {
    $ignore = !empty($request['item_id']) ? ',' . $request['item_id'] : '';
    return [
      'categorie_id' => 'required',
      'ptitle' => 'required|min:2|max:100',
      'purl' => 'required|min:2|max:100|regex:/^[a-z\d-]+$/|unique:products,purl' . $ignore,
      'price' => 'required|numeric',
      'article' => 'required|min:2',
      'pimage' => 'image|max:5242880',
      'pimage2' => 'image|max:5242880',
      'pimage3' => 'image|max:5242880',
      'pimage4' => 'image|max:5242880',
      'pimage5' => 'image|max:5242880',
      'specification1' => 'required|min:2',
      'specification2' => 'required|min:2',
      'specification3' => 'required|min:2',
      'feedback1' => 'required|min:2|max:100',
      'feedback2' => 'required|min:2|max:100',
    ];
  }
}
