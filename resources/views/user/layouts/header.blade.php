<header id="header">
    <!--header-->
    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{ route('index') }}"><img src="{{ asset('images/home/logo(139x59).png') }}" alt=""/></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>
                            <li class="cart-home">
                                @if(auth()->guard('web')->check())
                                    <a href="{{ route('cart.show', $cartId) }}"><i class="fa fa-shopping-cart"></i> Cart</a>
                                @else
                                    <a href="{{ route('login') }}"><i class="fa fa-shopping-cart"></i> Cart</a>
                                @endif
                                @if (isset($amountProductCart) && $amountProductCart != 0)
                                    <div class="amount-product-cart">
                                        {{ $amountProductCart }}</div>
                                @endif
                            </li>
                            @if (!auth()->check())
                                <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> Login</a></li>
                            @else
                                <li>
                                    <a href="">
                                        <div class="account-home">
                                            <div class="avata-img-home">
                                                <img src="{{ auth()->user()->avatar }}" alt=""
                                                     style="width: 100%;height: 100%;">
                                            </div>
                                            <span>{{ auth()->user()->name }}</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="logout-header">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-middle-->

    <div class="header-bottom">
        <!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ route('index') }}"
                                   class="@if (Request::route()->getName() == 'index') active @endif">Home</a></li>
                            <li><a href="{{ route('products.index') }}"
                                   class="@if (Request::route()->getName() == 'products.index') active @endif">Products</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <form id="myformhome-custom" action="{{ route('products.index') }}" method="get">
                            <input id="key-word-home" type="text" name="key_word"
                                   value="{{ isset($request['key_word']) ? $request['key_word'] : '' }}"
                                   placeholder="Search"/>
                            <button class="button-search-cus" id="button-search-home"><i class="fa fa-search"
                                                                                         aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-bottom-->
</header>
<!--/header-->
