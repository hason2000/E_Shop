@extends('user.layouts.app')

@section('content')
    <div class="container">
        <div class="row product-detail">
            <div class="padding-right">
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="{{ $product->img_link }}" alt=""/>
                        </div>
                        <div id="similar-product">
                            <!-- Wrapper for slides -->
                            @if (!empty($imgsProduct))
                                <div class="owl-carousel owl-theme owl-cus-carousel">
                                    @foreach ($imgsProduct as $key => $imgProduct)
                                        <div class="item">
                                            <a href="">
                                                <div class="img-cus">
                                                    <a href=""><img src="{{ $imgProduct['link'] }}" alt=""></a>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="product-information">
                            <!--/product-information-->
                            @if ($product->condition == 0)
                                <img src="{{ asset('images/product-details/new.jpg') }}" class="newarrival"
                                     alt=""/>
                            @elseif($product->condition == 1)
                                <img src="{{ asset('images/product-details/sale.png') }}" class="newarrival"
                                     alt=""/>
                            @endif
                            <h2>{{ $product->name }}</h2>
                            <p>Web ID: {{ $product->id }}</p>
                            @if ($rating != 0)
                                <div class="star-cus-outer">
                                    <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                    <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                    <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                    <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                    <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                    <div class="star-cus-inner"
                                         style="width: {{ round((($rating / 5) * 100) / 10) * 10 }}%">
                                        <i class="fa fa-star star-inner" aria-hidden="true"></i>
                                        <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                        <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                        <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                        <i class="fa fa-star star-outer" aria-hidden="true"></i>
                                    </div>
                                </div>
                            @else
                                <span style="font-style: italic">No review for this product</span>
                            @endif
                            @if (empty($sizesProduct))
                                <p class="availability-cus">
                                    <b>Availability:</b> "Out Of Stock"
                                </p>
                            @else
                                <span>
                                    <span class="d-block">{{ $product->price }}$</span>
                                    <button id="btn-add-to-cart" type="button" class="btn btn-fefault cart"
                                        {{ empty($sizesProduct) ? 'disabled' : '' }}>
                                        <i class="fa fa-shopping-cart"></i>
                                        Add to cart
                                    </button>
                                </span>
                                <form id="form-add-to-cart" action="{{ route('add_to_cart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="size-cus">
                                        @foreach ($sizesProduct as $size => $amount)
                                            @if($amount != 0)
                                                <label class="size-custom-label" class=""
                                                       for="size-{{ $size }}">
                                                    <input type="radio" required id="size-{{ $size }}"
                                                           name="size" value="{{ $size }}">
                                                    <i class="custom-radio-size">{{ $size }}</i>
                                                    <span class="amount" id="amount-{{ $size }}">{{ $amount }}</span>
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if($errors->first('size'))
                                        <span class="eror-mess-cus">{{ $errors->first('size') }}</span>
                                    @endif
                                    <div class="quantity-cus" id="quantity-product-detail-custom">
                                        <label>Quantity:</label>
                                        <input id="quantity-size" type="number" name="amount" min="1"
                                               max="" value="1"/>
                                        @if ($errors->first('amount'))
                                            <span class="eror-mess-cus">{{ $errors->first('amount') }}</span>
                                        @endif
                                    </div>
                                </form>
                            @endif
                            <p><b>Brand:</b> {{ $brand->name }}</p>
                        </div>
                        <!--/product-information-->
                    </div>
                </div>
                <!--/product-details-->

                <div class="category-tab shop-details-tab">
                    <div id="id-user-of-shop" data-key="{{ $userIdOfShop }}" class="d-flex"></div>
                    <!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li><a href="#details" data-toggle="tab">Details</a></li>
                            <li class="active"><a href="#shopprofile" data-toggle="tab">Shop</a></li>
                            <li><a href="#reviews"
                                   data-toggle="tab">Reviews{{ count($usersReview) != 0 ? ' (' . count($usersReview) . ')' : '' }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade product-detail" id="details">
                            {{ $product->detail }}
                        </div>
                        <div class="tab-pane fade shop-profile active in" id="shopprofile">
                            <div class="shop-avata col-sm-12">
                                <a href="#" class="shop-img">
                                    <div class="shop-avata-cus"><img style="width: 100%; height: 100%;"
                                                                     src="{{ $shop->img_shop }}" alt="" id="shop-avatar-{{ $userIdOfShop }}"></div>
                                    <div class="shop-name" id="area-contain-btn-shop">
                                        <p id="shop-name-{{ $userIdOfShop }}">{{ $shop->name }}</p>
                                        @if ($userIdOfShop != auth()->id())
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#chatShop" id="button-chat-user-shop" data-user-shop="{{ $userIdOfShop }}">Chat Now</button>
                                        @endif
                                    </div>

                                </a>
                            </div>
                            <div class="shop-site">
                                <a href="{{ $shop->web_site }}">{{ $shop->web_site }}</a>
                            </div>
                            <div class="shop-adrress">
                                <p>Address:</p>
                                <span>{{ $address->number }} , {{ $address->street }} , {{ $address->ward }} ,
                                    {{ $address->city }} , {{ $address->province }}</span>
                            </div>
                            <div class="shop-detail">
                                <p>{{ $shop->detail }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews">
                            @if (count($usersReview) == 0)
                                <div class="no-review">
                                    Be the first to comment
                                </div>
                            @else
                                @foreach ($usersReview as $userReview)
                                    <div class="col-sm-12">
                                        <ul>
                                            <li><a href=""><i class="fa fa-user"></i>{{ $userReview->name }}</a>
                                            </li>
                                            <li><a href=""><i
                                                        class="fa fa-clock-o"></i>{{ $reviews[$userReview->id]['time'] }}
                                                </a>
                                            </li>
                                            <li><a href=""><i
                                                        class="fa fa-calendar-o"></i>{{ $reviews[$userReview->id]['date'] }}
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="rating-user">
                                            @for ($i = 0; $i < $reviews[$userReview->id]['rating']; $i++)
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            @endfor
                                        </div>
                                        <p class="">
                                            {{ $reviews[$userReview->id]['content'] }}
                                        </p>
                                    </div>
                                    <hr style="width: 100%;">
                                @endforeach
                            @endif

                            <div class="col-sm-12 user-comment">
                                <p class="user-comment-title"><b>Write Your Review</b></p>
                                <form action="" method="get">
                                    <textarea name="content"></textarea>
                                    <div class="star-vote d-flex align-items-center">
                                        <span class="star-vote-title">Vote</span>
                                        <div class="star-vote-rating">
                                            <label for="one-star" class="star-container">
                                                <i class="fa fa-star fa-star-cus" data-index="1"></i>
                                            </label>
                                            <input required type="radio" id="one-star" name="star_rating"
                                                   value="1">
                                            <label for="two-star" class="star-container">
                                                <i class="fa fa-star fa-star-cus" data-index="2"></i>
                                            </label>
                                            <input required type="radio" id="two-star" name="star_rating"
                                                   value="2">
                                            <label for="three-star" class="star-container">
                                                <i class="fa fa-star fa-star-cus" data-index="3"></i>
                                            </label>
                                            <input required type="radio" id="three-star" name="star_rating"
                                                   value="3">
                                            <label for="four-star" class="star-container">
                                                <i class="fa fa-star fa-star-cus" data-index="4"></i>
                                            </label>
                                            <input required type="radio" id="four-star" name="star_rating"
                                                   value="4">
                                            <label for="five-star" class="star-container">
                                                <i class="fa fa-star fa-star-cus" data-index="5"></i>
                                            </label>
                                            <input required type="radio" id="five-star" name="star_rating"
                                                   value="5">
                                        </div>
                                        <button type="submit" class="btn btn-default pull-right">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @if((auth('web')->check() && $userIdOfShop != auth()->id()))
        @include('user.layouts.chat')
    @endif
@endsection
