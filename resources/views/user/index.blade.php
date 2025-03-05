@extends('layouts.dashboard')

@section('content')
<h1>Hey User {{Auth::user()->name}}</h1>

@endsection