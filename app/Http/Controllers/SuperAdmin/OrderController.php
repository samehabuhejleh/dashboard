<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->data();
        }

        return view('super-admin.orders.index');
    }

    private function data()
    {
        $orders = Order::all();

        return DataTables::of($orders)
            ->addColumn('id', function ($order) {
                return $order->id;
            })
            ->addColumn('user', function ($order) {
                return $order->user->name;
            })
            ->addColumn('quantity', function ($order) {
                return $order->quantity;
            })
            ->addColumn('price', function ($order) {
                return $order->price;
            })
            ->addColumn('status', function ($order) {
                return $order->status;
            })
            ->addColumn('action', function ($order) {
                return 
                "<button class='btn btn-info btn_edit' id='btn_edit'  data-order-id='". $order->id ."'  data-bs-toggle='modal' data-bs-target='#editModal'  > edit</button>" 
                ;
            })

            ->make(true);
    }



    public function edit($id)
    {

        $order = Order::find($id);
        return response()->json(['status' => true, 'data' => $order]);
    }



    public function update(Request $request , $id){
       try{
        $order = Order::find($id);
        $order->update([
            'status'=>$request->status
        ]);
        $order->save();

        Mail::to($order->user->email)->send(new OrderStatusMail($order));

        return response()->json(['status'=>true, 'message'=>"order Updated Successfully !"]);

       }catch(\Exception $e){
        return response()->json(['status'=>false, 'message'=>$e->getMessage()]);

       }
    
    }
}
