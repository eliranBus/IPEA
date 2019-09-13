<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules(request $request)
    {
        $ignore = !empty($request['item_id']) ? ',' . $request['item_id'] : '';
        return [
            'link' => 'required|min:2|max:50',
            'url' => 'required|min:2|max:100|regex:/^[a-z\d-]+$/|unique:menus,url' . $ignore,
            'title' => 'required|min:2|max:100',
        ];
    }
}
