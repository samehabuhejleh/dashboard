@extends('layouts.user')
@section('content')
<div class="container">
    <div class="row">
        @foreach($products as $product)
        <div class="card" style="width: 18rem;">
            <img src="{{asset($product->primaryImage()->first()->path)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$product->name}}</h5>
                <p class="card-text">{{$product->description}}</p>
                <p class="card-text">$ {{$product->price}}</p>
                <p class="card-text">{{$product->stock}}</p>
                <a href="{{route('show',$product->id)}}" class="btn btn-primary">show details</details></a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection