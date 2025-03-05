<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasRole('super_admin') ){
            return redirect()->route('super.index');
        }
        elseif(Auth::user()->hasRole('admin')){
            return redirect()->route('admin.index');
        }
        else{
            return redirect()->route('user.index');

        }
    }

    public function welcome(){
        $products = Product::with('primaryImage','images')->get();
        return view('welcome',compact('products'));
    }


    public function showProduct($id){
        $product = Product::with('images','primaryImage')->find($id);
        return view('products.show',compact('product'));
    }
}
