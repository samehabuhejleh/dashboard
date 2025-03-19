@extends('layouts.user')

@section('content')
<style>
    /* General Styling */
    body {
        font-family: Arial, sans-serif;
    }
    h2 {
        font-weight: bold;
    }

    /* Hero Section */
    .hero {
        background: url('{{ asset("images/hero-bg.jpg") }}') no-repeat center center/cover;
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
    }
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }

    /* Product Cards */
    .product-card {
        transition: transform 0.3s ease-in-out;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }

    /* Testimonials */
    .testimonials {
        background: #f8f9fa;
        padding: 40px 20px;
        border-radius: 10px;
        text-align: center;
    }

    /* Contact Form */
    .contact {
        background: #343a40;
        color: white;
        padding: 40px;
    }
    .contact input, .contact textarea {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
    }
</style>

{{-- Hero Section --}}
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="display-4">Welcome to Our Store</h1>
        <p class="lead">Find the best products at unbeatable prices.</p>
        <a href="#products" class="btn btn-light btn-lg">Shop Now</a>
    </div>
</section>

{{-- About Section --}}
<section class="about py-5 text-center">
    <div class="container">
        <h2>About Us</h2>
        <p class="text-muted">We provide top-quality products at affordable prices.</p>
    </div>
</section>

{{-- Products Section --}}
<section id="products" class="products py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Our Products</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card shadow">
                    <img src="{{asset($product->primaryImage()->first()->path)}}" class="card-img-top" alt="{{$product->name}}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{$product->description}}</p>
                        <p class="card-text"><strong>$ {{$product->price}}</strong></p>
                        <p class="card-text">Stock: {{$product->stock}}</p>
                        <a href="{{route('products.show', $product->id)}}" class="btn btn-primary">Show Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials Section --}}
<section class="testimonials py-5 text-center">
    <div class="container">
        <h2>What Our Customers Say</h2>
        <p class="lead">"Absolutely love these products! The quality is outstanding!"</p>
        <p class="text-muted">- Happy Customer</p>
    </div>
</section>

{{-- Contact Section --}}
<section id="contact" class="contact py-5">
    <div class="container">
        <h2 class="text-center mb-4">Get in Touch</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Your Name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Your Email">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
            </div>
            <button type="submit" class="btn btn-light">Send Message</button>
        </form>
    </div>
</section>

@endsection
