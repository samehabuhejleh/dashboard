@extends('layouts.dashboard')

@section('content')

@push('css')
<style>
    
</style>
@endpush
<h1>Orders</h1>

<table class="table  order-table" >
    <thead>
        <tr>
            <th>#id</th>
            <th>User Name</th>
            <th>quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>


@include('super-admin.orders.components.edit') 

@push('js')
<script src="{{asset('asset/js/orders/index.js')}}"></script>
@endpush
@endsection