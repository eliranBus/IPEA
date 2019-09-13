<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }


  public function rules(request $request)
  {
    $ignore = !empty($request['item_id']) ? ',' . $request['item_id'] : '';
    return [
      'title' => 'required|min:2|max:100',
      'url' => 'required|min:2|max:100|regex:/^[a-z\d-]+$/|unique:categories,url' . $ignore,
      'description' => 'required|min:2',
      'image' => 'image|max:5242880',
    ];
  }
}
