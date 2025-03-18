<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderMail;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItemHistory;
use App\Models\CartItems;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function showCheckout()
    {
        $total = Auth::user()->cart->getTotal();
        return view('checkout', compact('total'));
    }
   
    public function processPayment(CheckoutRequest $request)
    {
        try {
            // Set Stripe Secret Key
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            // Charge the customer
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment from Qoot Store',
            ]);
    
            if ($charge->status === 'succeeded') {
                $user = Auth::user();
                $cart = $user->cart;
    
                // Create Address
                $address = Address::create([
                    'user_id' => $user->id,
                    'street_name' => $request->street_name,
                    'building_number' => $request->building_number,
                    'floor_number' => $request->floor_number,
                    'appartment_number' => $request->appartment_number,
                    'phone_number' => $request->phone_number,
                ]);
    
                // Create Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'address_id' => $address->id,
                    'price' => $cart->getTotal(),
                    'status' => OrderStatus::Pending->value, // Fix enum usage
                    'note' => $request->note ?? null, // Ensure it's optional
                ]);
    
                // Move Cart Items to Order History
                foreach ($cart->items as $item) {
                    CartItemHistory::create([
                        'cart_id' => $cart->id,
                        'order_id' => $order->id,
                        'product_id' => $item->pivot->product_id,
                        'price' => $item->price,
                        'quantity' => $item->pivot->quantity,
                    ]);

                    $item->stock=  $item->stock - $item->pivot->quantity;
                    $item->save();
                    $dcart = CartItems::where('product_id',$item->id)->where('cart_id',$cart->id)->first();
                    $dcart->delete();
                }
                
                Mail::to($user->email)->send(new OrderMail($order));
                return back()->with('success', 'تم الدفع بنجاح!');
            }
    
            return back()->with('error', 'فشل الدفع، يرجى المحاولة مرة أخرى.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
    
}
