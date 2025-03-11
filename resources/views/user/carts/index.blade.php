@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Your Shopping Cart</h2>

    @if ($cart->items->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->pivot->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->pivot->quantity * $item->price, 2) }}</td>
                        <td><button id="remove-item" class="btn btn-danger" data-item-id="{{$item->pivot->id}}"><i class="fa-solid fa-trash"></i></button></td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right">
            <h4>Total: ${{ number_format($cart->items->sum(fn($item) => $item->pivot->quantity * $item->price), 2) }}</h4>
            <a href="#" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @else
        <p>Your cart is empty.</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary">Continue Shopping</a>
    @endif
</div>
@endsection
@push('js')
<script src="{{asset('asset/js/cart/index.js')}}"></script>
@endpush