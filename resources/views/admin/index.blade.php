@extends('layouts.dashboard')

@section('content')

<h1>Hey Admin {{Auth::user()->name}}</h1>

@endsection