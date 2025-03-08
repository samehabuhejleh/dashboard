@extends('layouts.dashboard')

@section('content')

@push('css')
<style>
    
</style>
@endpush
<h1>user index</h1>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
  create User
</button>
<table class="table  user-table" >
    <thead>
        <tr>
            <th>Id</th>
            <!-- <th>Image</th> -->
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>


@include('super-admin.users.components.create')
@include('super-admin.users.components.edit')

@push('js')
<script src="{{asset('asset/js/users/index.js')}}"></script>
@endpush
@endsection