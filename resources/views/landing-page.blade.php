<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <link  href="/img/favicon.ico" rel="SHORTCUT ICON">

       <!-- Fonts -->
        <title>Laravel Ecommerce | @yield('title', '')</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

        @yield('extra-css')
    </head>
    <body class="@yield('body-class','')">
           
           <div id="app">
        <header class="with-background">

            <div class="top-nav container">

                 <div class="top-nav-left">
                        <div class="logo">Mimi Ecommerce</div>

                        {{ menu('main', 'partials.menus.main') }}
                    </div>

                    <div class="top-nav-right">
                        @include('partials.menus.main-right')
                    </div>
    
                </div><!---end top-nav--->

            <div class="hero container">
                <div class="hero-copy">
                    <h1>Mimi Ecommerce</h1>
                    <p>This is an online selling system where buying and selling are made easy and quick for you within an hour no distance barria..hurry now and make your transactions a fast one.</p>

                    <div class="hero-buttons">
                        <a href="#" class="button button-white">Download</a>
                        <a href="#" class="button button-white">button 2</a>
                    </div>
                </div><!--end hero-copy-->

                <div class="hero-image">
                    <img src="img/macbook-pro-laravel.png" alt="hero image">
                </div>
                
            </div> <!---end hero--->
        </header>

        <div class="featured-section">
            <div class="container">
                <h1 class="text-center">Laravel Ecommerce</h1>

                <p class="section-description">Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem.</p>

            <div class="text-center button-container">
                
                <a href="#" class="button">Featured</a>
                <a href="#" class="button">On Sale</a>
            </div>
            


            <div class="products text-center">
            @foreach( $products as $product)
                <div class="product">
                    <a href="{{ route('shop.show', $product->slug) }}"><img src="{{asset('storage/'.$product->image)}}"></a>
                    <a href="{{ route('shop.show', $product->slug) }}"><span class="product-name">{{ $product->name}}</span></a>
                    <div class="product-price">{{ $product->presentPrice ()}}</div>
                </div>
                @endforeach
                
            </div><!--end products--->



            <div class="text-center button-container">
                
                <a href="{{ route('shop.index') }}" class="button">View More Products</a>
            </div>
            </div><!--end container--->

        </div><!--end featured-section--->


        <div class="blog-section">
            <div class="container">
                <h1 class="text-center">From Our Blog</h1>

                <p class="section-description">
                    Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem.</p>

                <div class="blog-posts">
                    <div class="blog-post">
                        <a href="#"><img src="img/blog1.png" alt="blog image"></a>
                        <a href="#"><h2 class="blog-title">Blog Post Title 1</h2></a>
                        <div class="blog-description">Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem
                        Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem </div>
                    </div>

                    <div class="blog-post">
                        <a href="#"><img src="img/blog2.png" alt="blog image"></a>
                        <a href="#"><h2 class="blog-title">Blog Post Title 1</h2></a>
                        <div class="blog-description">Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem
                        Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem </div>
                    </div>

                    <div class="blog-post">
                        <a href="#"><img src="img/blog3.png" alt="blog image"></a>
                        <a href="#"><h2 class="blog-title">Blog Post Title 1</h2></a>
                        <div class="blog-description">Lorem Lorem Lorem Lorem Lorem Lorem Lorem LoremLorem
                        Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem </div>
                    </div>

                </div><!--end blog posts--->
            </div><!--end container--->
         </div><!--end blog-section--->

         @include('partials.footer')

         <script src="js/app.js"></script>

        </div><!--end app--->
    </body>
</html>
