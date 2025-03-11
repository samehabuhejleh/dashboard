@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if ($product->primaryImage)
                <img src="{{ asset($product->primaryImage->path) }}" alt="{{ $product->name }}" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <h4>${{ number_format($product->price, 2) }}</h4>

            <form id="add-cart-form" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" class="form-control" min="1" value="1">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('asset/js/cart/index.js')}}"></script>
@endpush