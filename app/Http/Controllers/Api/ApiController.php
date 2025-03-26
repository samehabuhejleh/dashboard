<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApiController extends Controller
{
    public function index(){

        $product = Product::all();
        
        try{

            return response()->json(['status' => true, 'product' => $product ], 200);

        }catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
