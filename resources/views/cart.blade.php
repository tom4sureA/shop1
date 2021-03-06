 @extends('layouts.layout')

@section('title', 'Cart')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

         
     @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Cart</span>
    @endcomponent
        
       
    
    <div class="cart-section container">
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Cart::count() > 0)

            <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>
       
        <div class="cart-table">
            @foreach (Cart::content() as $item)
            <div class="cart-table-row">
                <div class="cart-table-row-left">
                    <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{asset('storage/'.$item->model->image )}}" alt="item" class="cart-table-img"></a>
                    <div class="cart-item-details">
                        <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name}}</a></div>
                        <div class="cart-table-description">{{ $item->model->details}}</div>
                    </div>
                </div>

                <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                     <form action="{{route('cart.destroy', $item->rowId)}}" method="POST">
                         {{ csrf_field() }}
                         {{ method_field('DELETE') }}

                         <button type="submit" class="cart-options">Remove</button>
                     </form>

                        <!--<a href="#">Save for Later</a>--->
                     <form action="{{route('cart.switchToSaveForLater', $item->rowId)}}" method="POST">
                         {{ csrf_field() }}
                         
                         <button type="submit" class="cart-options">Save For Later</button>
                     </form>
                    </div>
                </div>

                <div>
                    <select class="quantity" data-id="{{ $item->rowId}}" data-productQuantity="{{ $item->model->quantity }}">
                        @for ($i = 1; $i < 5 + 1 ; $i++)
                         <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                         @endfor
                   
                    </select>
                   
                    <div>
                <div>{{ $item->model->presentPrice()}}</div>
                    </div>
                </div>
            </div><!--end cart-table-row-->
             @endforeach

            
        </div><!--end cart-table-->

        @if (! session()->has('coupon'))

                <a href="#" class="have-code">Have a Code?</a>

                <div class="have-code-container">

                 <form action="{{ route('coupon.store')}}" method="POST">
                  {{csrf_field()}}
                  <input type="text" name="coupon_code" id="coupon_code">

                  <button type="submit" class="button button-plian">Apply</button>
                </form>
              </div><!--end have-code-container-->

             @endif

            <div class="cart-totals">
    
            <div class="cart-totals-left">
            shopping is free because we're awesome like that. Also because that's additional stuff I don't feel like figuring out :).
            </div>

        <div class="cart-totals-right">
       <div>

        Subtotal <br>
            @if (session()->has('coupon'))

                        Code ({{ session()->get('coupon')['name']}})
                        <form action="{{ route('coupon.destroy')}}" method="POST" style="display:inline">
                          {{ csrf_field()}}
                          {{ method_field('delete')}}
                          
                          <button type="submit" style="font-size:14px;">Remove</button>   
                        </form>
                        <br>
                        <hr>
                        New Subtotal <br>
                      @endif
                    Tax ({{config('cart.tax')}}%)<br>
        <span class="cart-totals-total">Total</span>

        </div>

        <div class="cart-totals-subtotal">
            {{ Cart::subtotal()}} <br>
            @if (session()->has('coupon'))

             -{{ session()->get('coupon')['discount']}}<br>&nbsp;<br>
                <hr>
                stuff<br>
                @endif
            {{ Cart::tax()}} <br>
            <span class="cart-totals-total">{{ Cart::total()}}</span>
         </div>
            </div>

            </div><!--end cart-totals-->

           <!-- <div class="checkout-totals-left">

                        Subtotal <br> 

                        @if (session()->has('coupon'))

                        Discount ({{ session()->get('coupon')['name']}}):
                        <form action="{{ route('coupon.destroy')}}" method="POST" style="display:inline">
                          {{ csrf_field()}}
                          {{ method_field('delete')}}
                          
                          <button type="submit" style="font-size: 14px ">Remove</button>   
                        </form>
                        <br>
                        <hr>
                        New Subtotal <br>
                      @endif
                        
                        Tax (13%)<br>
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

                    </div><--->


            <div class="cart-buttons">
                <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>
                <a href="{{route('checkout.index')}}" class="button-primary">Proceed to Checkout</a>
            </div>

            @else

                <h3>No items in Cart!</h3>
                <div class="spacer"></div>
                 <a href="{{ route('shop.index')}}" class="button">Continue Shopping</a>
                <div class="spacer"></div>     

            @endif


            @if (Cart::instance('saveForLater')->count() > 0)

            <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>


            <div class="Saved-for-later cart-table">
                @foreach (Cart::instance('saveForLater')->content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show', $item->model->slug)}}"><img src="{{ asset('img/products/'.$item->model->slug.'.jpg')}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug)}}">{{ $item->model->name}}</a></div>
                            <div class="cart-table-description">{{ $item->model->details}}</div>
                        </div>
                    </div>

                 <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                        <!--<a href="#">Remove</a><br>
                        <a href="#">Move To Cart</a>--->
                    <form action="{{route('saveForLater.destroy', $item->rowId)}}" method="POST">
                         {{ csrf_field() }}
                         {{ method_field('DELETE') }}

                         <button type="submit" class="cart-options">Remove</button>
                     </form>

                        <!--<a href="#">Save for Later</a>--->
                     <form action="{{route('saveForLater.switchToCart', $item->rowId)}}" method="POST">
                         {{ csrf_field() }}
                         
                         <button type="submit" class="cart-options">Move to Cart</button>
                     </form>

                    </div>
                </div>

                    <div class="cart-select">
                    <select class="quantity">
                    <option selected="">1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                   
                    <div>
                <div>{{ $item->model->presentPrice() }}</div>
                    </div>
                </div>

                </div><!--end cart-table-row-->
                @endforeach

            </div><!-- end cart-table-row -->

        </div><!-- end saved-for-later -->

        @else

            <h3>You have no items Saved for Later.</h3>


            @endif
        </div>

    </div><!--end cart-section-->
       
      @include('partials.might-like')
      @include('partials.footer')

@endsection



@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')
            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                     const id = element.getAttribute('data-id')
                     const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })

                    .then(function (response) {
                        // console.log(response);
                        window.location.href = '{{ route('cart.index') }}'
                       
                    })
                    .catch(function (error) {
                        // console.log(error);
                       window.location.href = '{{ route('cart.index') }}'
                    });
                    

                    
                })
            })

        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection







        