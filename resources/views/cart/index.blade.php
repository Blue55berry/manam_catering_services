@extends('layouts.app')

@section('title', 'Shopping Cart - Catering Services')

@section('content')
<section class="cat-page-title-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="cat-page-title-inner">
                    <h1>Shopping Cart</h1>
                    <p><a href="{{ route('home') }}">Home</a> / Cart</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cat-cart-section cat-section-spacer">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cat-cart-items-wrapper">
                    @if(session('cart') && count(session('cart')) > 0)
                        @foreach(session('cart') as $id => $details)
                            <div class="cat-cart-item-card" data-id="{{ $id }}">
                                <div class="row align-items-center">
                                    <div class="col-md-3 col-4">
                                        <div class="cat-cart-img">
                                            <img src="{{ asset($details['image']) }}" alt="{{ $details['name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-8">
                                        <div class="cat-cart-info">
                                            <h4>{{ $details['name'] }}</h4>
                                            @php $price = (float) preg_replace('/[^\d.]/', '', $details['price']); @endphp
                                            <span class="cat-cart-price">₹{{ number_format($price, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mt-3 mt-md-0">
                                        <div class="cat-cart-qty">
                                            <div class="quantity-control">
                                                <button type="button" class="qty-btn minus"><i class="fa fa-minus"></i></button>
                                                <input type="text" class="qty-input" value="{{ $details['quantity'] }}" readonly>
                                                <button type="button" class="qty-btn plus"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-6 mt-3 mt-md-0 text-end">
                                        <button class="remove-from-cart-btn" data-id="{{ $id }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h3>Your Cart is Empty</h3>
                            <p class="mb-4">Looks like you haven't added anything to your cart yet.</p>
                            <a href="{{ route('menu') }}" class="cat-btn">Browse Menu</a>
                        </div>
                    @endif
                </div>
                
                @if(session('cart') && count(session('cart')) > 0)
                <div class="cat-cart-actions mt-4">
                    <a href="{{ route('menu') }}" class="cat-btn btn-outline"><i class="fa fa-arrow-left"></i> Continue Shopping</a>
                </div>
                @endif
            </div>
            
            @if(session('cart') && count(session('cart')) > 0)
            <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
                <div class="cat-cart-summary">
                    <h3>Cart Summary</h3>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span class="summary-price" id="cart-subtotal">
                            @php $total = 0 @endphp
                            @foreach((array) session('cart') as $id => $details)
                                @php 
                                    $price = (float) preg_replace('/[^\d.]/', '', $details['price']);
                                    $total += $price * $details['quantity']; 
                                @endphp
                            @endforeach
                            ₹{{ number_format($total, 2) }}
                        </span>
                    </div>
                    <div class="summary-item">
                        <span>Tax (5%)</span> <!-- Example tax -->
                        <span class="summary-price" id="cart-tax">
                            ₹{{ number_format($total * 0.05, 2) }}
                        </span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="total-price" id="cart-total">
                            ₹{{ number_format($total * 1.05, 2) }}
                        </span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="cat-btn w-100 mt-3 checkout-btn">Proceed to Checkout</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
