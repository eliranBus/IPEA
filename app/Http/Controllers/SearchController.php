<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function __construct()
    { }

    public function searchProducts(Request $request)
    {
        $term = $request->get('term');
        $data = DB::table('products')
            ->where("ptitle", "LIKE", "%$term%")
            ->get();
        foreach ($data as $result) {
            $results[] = ['value' => $result->ptitle, 'link' => url('shop/' . $result->categorie_url . '/' . $result->purl)];
        }
        return response()->json($results);
    }
}
