@extends('layouts.dashboard')

@section('content')

@push('css')
<style>
    
</style>
@endpush
<h1>product index</h1>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
  create product
</button>
<table class="table  product-table" >
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>


@include('super-admin.products.components.create')
@include('super-admin.products.components.edit')

@push('js')
<script src="{{asset('asset/js/products/index.js')}}"></script>
@endpush
@endsection