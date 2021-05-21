@extends('layouts.layout')

@section('title', 'Checkout')

@section('extra-css')
    <style>
        .mt-32 {
            margin-top: 32px;
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>

@endsection

@section('content')


 <div class="container">

        @if (session()->has('success_message'))
            <div class="spacer"></div>
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="spacer"></div>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        <div class="checkout-section">
            <div>
                <form action="{{route('checkout.store')}}" method="POST" id ="payment-form">
                  {{ csrf_field()}}
              <h2>Billing Details</h2>

              <div class="form-group">
                <label for="email">Email Address</label>
                @if (auth()->user())
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
                        @else
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @endif
              </div>

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
              </div>

              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
              </div>

              <div class="half-form">
                <div class="form-group">
                  <label for="city">City</label>
                  <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                </div>

                <div class="form-group">
                  <label for="province">Province</label>
                  <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}" required>
                </div>
              </div><!---end half-form-->


              <div class="half-form">
                <div class="form-group">
                  <label for="postalcode">Postal Code</label>
                  <input type="text" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode') }}" required>
                </div>

                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>
              </div><!---end half-form-->


              <div class="spacer"></div>

              <h2>Payment Details</h2>

              <div class="form-group">
                <label for="name_on_card">Name on Card</label>
                <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="">
              </div>

              <div class="form-group">
                <label for="card-element">
                    Credit or debit card
                  </label>
                  <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                  </div>

                  <!-- Used to display form errors. -->
                  <div id="card-errors" role="alert"></div>
              </div>

             <!-- <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="">
              </div>

              <div class="form-group">
                <label for="cc-number">Credit Card Number</label>
                <input type="text" class="form-control" id="cc-number" name="cc-number" value="">
              </div>

              <div class="half-form">
                <div class="form-group">
                  <label for="expiry">Expiry</label>
                  <input type="text" class="form-control" id="expiry" name="expiry" value="">
                </div>

                <div class="form-group">
                  <label for="cvc">CVC</label>
                  <input type="text" class="form-control" id="cvc" name="cvc" value="">
                </div>
              </div><end half-form-->

              <div class="spacer"></div>

              <button type="submit" id="Complete-order" class="button-primary full-width">Complete Order</button>
            </form> 


           
            <div class="mt-32">or</div>
                    @if ($paypalToken)
                    <div class="mt-32">or</div>
                    <div class="mt-32">
                        <h2>Pay with PayPal</h2>

                        <form method="post" id="paypal-payment-form" action="{{ route('checkout.paypal') }}">
                            @csrf
                            <section>
                                <div class="bt-drop-in-wrapper">
                                    <div id="bt-dropin"></div>
                                </div>
                            </section>

                            <input id="nonce" name="payment_method_nonce" type="hidden" />
                            <button class="button-primary" type="submit"><span>Pay with PayPal</span></button>
                        </form>
                    </div>
                @endif
                    
            </div>

           

            <div class="checkout-table-container">
              
                <h2>Your Order</h2>

                <div class="checkout-table">
                    @foreach (Cart::content() as $item)
                          <div class="checkout-table-row">
                        <div class="checkout-table-row-left">
                            <img src="{{asset('storage/'.$item->model->image)}}" alt="item" class="checkout-table-img">
                            <div class="checkout-item-details">
                                <div class="checkout-table-item">{{ $item->model->name}}</div>
                                <div class="checkout-table-description">{{ $item->model->details}}</div>
                                <div class="checkout-table-price">{{ $item->model->presentPrice()}}</div>
                            </div>
                        </div> <!-- end checkout-table -->

                        <div class="checkout-table-row-right">
                            <div class="checkout-table-quantity">{{ $item->qty}}</div>
                        </div>
                        </div> <!-- end checkout-table-row -->
                    @endforeach

                </div> <!-- end checkout-table -->

                <div class="checkout-totals">
                    <div class="checkout-totals-left">

                        Subtotal <br> 

                        @if (session()->has('coupon'))

                        Discount ({{ session()->get('coupon')['name']}}):
                        <br>
                        <hr>
                        New Subtotal <br>
                      @endif
                        
                        Tax ({{config('cart.tax')}}%)<br>
                        <span class="checkout-totals-total">Total</span>

                    </div>

                    <div class="checkout-totals-right">
                        {{Cart::subtotal()}} <br>

                          @if (session()->has('coupon'))

                        -{{ session()->get('coupon')['discount']}}<br>
                        <hr>
                        stuff<br>
                        @endif
                        
                         {{ Cart::tax()}}<br>
                       
                        <span class="checkout-totals-total">{{ Cart::total()}}</span>

                    </div>
                </div> <!-- end checkout-totals -->

                
              </div>
                
        </div> <!-- end checkout-section -->

    </div>
    
@include('partials.footer')

@endsection

@section('extra-js')
    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>

    <script>
        (function(){
            // Create a Stripe client.
var stripe = Stripe('pk_test_51HO8y5JFjRVtOMgk1quafQecqhlUCtHXJ3Bcezw33mORZn1BiKKb6HSEBDFO8PkO2IHXhRH89viIDYXzxBdQyqoq00paP0Y4zF');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}

// PayPal Stuff
            var form = document.querySelector('#paypal-payment-form');
            var client_token = "{{ $paypalToken }}";
            submitButton = document.querySelector('button');

            braintree.dropin.create({
              authorization: client_token,
              selector: '#bt-dropin',
              paypal: {
                flow: 'vault'
              }
            }, function (createErr, instance) {
              if (createErr) {
                console.log('Create Error', createErr);
                return;
              }

              // remove credit card option
             

              form.addEventListener('submit', function (event) {
                event.preventDefault();

                instance.requestPaymentMethod(function (err, payload) {
                  if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                  }

                  // Add the nonce to the form and submit
                  SubmitButton.disabled = true;
                  document.querySelector('#nonce').value = payload.nonce;
                  form.submit();
                });
              });
            });


        })();
    </script>
@endsection