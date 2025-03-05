@extends('layouts.dashboard')

@section('content')

<h1>Hey Super Admin {{Auth::user()->name}}</h1>
@endsection