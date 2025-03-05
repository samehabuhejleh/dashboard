<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->data();
        }
        return view('super-admin.products.index');
    }

    private function data()
    {
        $products = Product::all();

        return DataTables::of($products)
            ->addColumn('name', function ($product) {
                return $product->name;
            })
            ->addColumn('description', function ($product) {
                return $product->description;
            })
            ->addColumn('stock', function ($product) {
                return $product->stock;
            })
            ->addColumn('price', function ($product) {
                return $product->price;
            })
            ->addColumn('action', function ($product) {
                return 
                "<button class='btn btn-info btn_edit' id='btn_edit'  data-product-id='". $product->id ."'  data-bs-toggle='modal' data-bs-target='#editModal'  > edit</button>" . 
               " <button class='btn btn-danger btn_delete' id='btn_delete'  data-product-id='". $product->id ."'> delete</button>"
                ;
            })

            ->make(true);
    }


    public function create(Request $request)
    {

        try {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'user_id' => Auth::user()->id,
            ]);


            if ($request->hasFile('main_image')) {

                $mainPath = $request->file('main_image')->store('public/main_images');
                $product->primaryImage()->create([
                    "path" =>  str_replace('public/', 'storage/',$mainPath),
                    'is_main' => true
                ]);
            }

            if ($request->images) {
                foreach ($request->images as $image) {
                    $path = $image->store('public/images');
                    $product->images()->create([
                        "path" => str_replace('public/', 'storage/',$path),
                        'is_main' => false
                    ]);
                }
            }


            return response()->json(['status' => true, 'message' => "Product created Successfuly"], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function edit($id)
    {

        $product = Product::find($id);
        return response()->json(['status' => true, 'data' => $product]);
    }

    public function update(Request $request , $id){
       try{
        $product = Product::find($id);
        $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock
        ]);

        if ($request->hasFile('main_image')) {
            Storage::delete(public_path($product->primaryImage()->first()->path));
            Storage::delete(storage_path($product->primaryImage()->first()->path));

            $product->primaryImage()->delete();
            $mainPath = $request->file('main_image')->store('main_images');
            $product->primaryImage()->create([
                "path" => $mainPath,
                'is_main' => true
            ]);
        }

        if ($request->images) {
            foreach ($product->images as $image){
            Storage::delete(public_path($image->path));
            Storage::delete(storage_path($image->path));
            }
            $product->images()->delete();
            foreach ($request->images as $image) {
                $path = $image->store('images');
                $product->images()->create([
                    "path" => $path,
                    'is_main' => false
                ]);
            }
        }
        return response()->json(['status'=>true, 'message'=>"Product Updated Successfully !"]);

       }catch(Exception $e){
        return response()->json(['status'=>false, 'message'=>$e->getMessage()]);

       }
    }


    public function delete($id){

        try{

        $product = Product::find($id);

        Storage::delete(public_path($product->primaryImage()->first()->path));
        $product->primaryImage()->delete();
        foreach ($product->images as $image){
            Storage::delete(public_path($image->path));
            }
        $product->images()->delete();

        $product->delete();

        return response()->json(['status'=>true, 'message'=>"Product Deleted Successfully"]);

    }catch(\Exception $e){
        return response()->json(['status'=>false, 'message'=>$e->getMessage()]);
    }
    }
}
