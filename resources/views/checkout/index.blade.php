@extends('layouts.app')

@section('title', 'Checkout - Catering Services')

@section('content')
<section class="cat-page-title-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="cat-page-title-inner">
                    <h1>Checkout</h1>
                    <p><a href="{{ route('home') }}">Home</a> / Checkout</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cat-checkout-section cat-section-spacer">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('checkout.store') }}" method="POST"> <!-- Route to be defined later for processing -->
            @csrf
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cat-checkout-form mb-4">
                        <h3 class="cat-checkout-title">Event Details</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Which Event? <span class="required">*</span></label>
                                    <select name="event_type" class="form-control" required>
                                        <option value="">Select Event Type</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Corporate">Corporate Event</option>
                                        <option value="Party">Social Party</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Event Date <span class="required">*</span></label>
                                    <input type="date" name="event_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>What kinds of food require? (Specific Requirements)</label>
                                    <textarea name="food_requirements" class="form-control" placeholder="Tell us about your food preferences, dietary restrictions, etc." rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cat-checkout-form">
                        <h3 class="cat-checkout-title">Ordering Person Details</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>First Name <span class="required">*</span></label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Last Name <span class="required">*</span></label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Company Name (Optional)</label>
                                    <input type="text" name="company_name" class="form-control" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Country / Region <span class="required">*</span></label>
                                    <select class="form-control wide" name="country">
                                        <option value="United States">United States (US)</option>
                                        <option value="United Kingdom">United Kingdom (UK)</option>
                                        <option value="Canada">Canada</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Street Address <span class="required">*</span></label>
                                    <input type="text" name="address_1" class="form-control" placeholder="House number and street name" required>
                                    <input type="text" name="address_2" class="form-control mt-2" placeholder="Apartment, suite, unit, etc. (optional)">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Town / City <span class="required">*</span></label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>State / County <span class="required">*</span></label>
                                    <input type="text" name="state" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Postcode / ZIP <span class="required">*</span></label>
                                    <input type="text" name="zip" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Phone <span class="required">*</span></label>
                                    <input type="tel" name="phone" class="form-control" required>
                                </div>
                            </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Email Address <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Order Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <div class="cat-checkout-summary">
                        <h3 class="cat-checkout-title">Your Order</h3>
                        <div class="checkout-order-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}  <strong class="product-qty">× {{ $item['quantity'] }}</strong></td>
                                        @php $price = (float) preg_replace('/[^\d.]/', '', $item['price']); @endphp
                                        <td class="text-end">₹{{ number_format($price * $item['quantity'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="order-subtotal">
                                        <td>Subtotal</td>
                                        <td class="text-end">₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <tr class="order-total">
                                        <td>Total</td>
                                        <td class="text-end"><strong>₹{{ number_format($total, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="payment-methods mt-4">
                           <div class="form-check mb-2">
                              <input class="form-check-input" type="radio" name="payment_method" id="payment_check" value="check" checked>
                              <label class="form-check-label" for="payment_check">
                                Check Payments
                              </label>
                              <div class="payment-info text-muted small mt-1 pl-4">
                                  Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.
                              </div>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash">
                              <label class="form-check-label" for="payment_cash">
                                Cash on Delivery
                              </label>
                               <div class="payment-info text-muted small mt-1 pl-4">
                                  Pay with cash upon delivery.
                              </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="cat-btn w-100">Place Order</button>
                        </div>
                        
                        <div class="privacy-policy-text mt-3">
                            <p class="small text-muted">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#">privacy policy</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
