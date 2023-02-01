@extends('user.layouts.app')

@section('content')
    <section id="slider">
        <!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>Free E-Commerce Template</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. </p>
                                    <button type="button" class="btn btn-default get">Get it now</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ asset('images/home/girl1.jpg') }}" class="girl img-responsive"
                                        alt="" />
                                    <img src="{{ asset('images/home/pricing.png') }}" class="pricing" alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>100% Responsive Design</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. </p>
                                    <button type="button" class="btn btn-default get">Get it now</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ asset('images/home/girl2.jpg') }}" class="girl img-responsive"
                                        alt="" />
                                    <img src="{{ asset('images/home/pricing.png') }}" class="pricing" alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>Free Ecommerce Template</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. </p>
                                    <button type="button" class="btn btn-default get">Get it now</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ asset('images/home/girl3.jpg') }}" class="girl img-responsive"
                                        alt="" />
                                    <img src="{{ asset('images/home/pricing.png') }}" class="pricing" alt="" />
                                </div>
                            </div>

                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--/slider-->

    <section>
        <div class="container">
            <div class="row home-content">
                @include('user.layouts.tool')
                <div class="col-sm-9 home-content-right">
                    <div class="">
                        <!--features_items-->
                        <h2 class="title text-center">Features Items</h2>
                        @if (count($productsFeature) == 0)
                            <div class="result-search">No result product</div>
                        @else
                            @foreach ($productsFeature as $key => $product)
                                <div class="col-sm-4" style="margin-bottom: 20px">
                                    <div class="card item-product" data-link="{{ route('products.show', $product->id) }}">
                                        {{--                                        <a href="{{ route('products.show', $product->id) }}" style="display: block"> --}}
                                        <div>
                                            <img src="{{ $product['img_link'] }}" class="card-img-top"
                                                style="width: 100%; height: 250px">
                                        </div>
                                        <div class="card-body text-center">
                                            <h3 class="card-title text-center item-product-price">
                                                ${{ $product['price'] }}</h3>
                                            <p class="card-text text-center">{{ $product['name'] }}</p>
                                        </div>
                                        <div class="item-product-tool">
                                            <a href="#"><i class="fa fa-plus-square" aria-hidden="true"></i> Add to
                                                wish
                                            </a>
                                            <a href="{{ route('products.show', $product->id) }}"><i class="fa fa-eye"
                                                    aria-hidden="true"></i> View product</a>
                                        </div>
                                        {{--                                        </a> --}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </>
                        {{ $productsFeature->links('user.layouts.pagination') }}
                        <!--features_items-->
                        @if (count($categories) != 0)
                            <div class="category-tab">
                                <!--category-tab-->
                                <div class="col-sm-12">
                                    <ul class="nav nav-tabs">
                                        <?php $countCategory = 0; ?>
                                        @foreach ($productsOfCategory as $categorieName => $productOfCategory)
                                            <li class="{{ $countCategory == 0 ? 'active' : '' }}"><a
                                                    href="#{{ $categorieName }}"
                                                    data-toggle="tab">{{ $categorieName }}</a>
                                            </li>
                                            <?php $countCategory++; ?>
                                            @if ($countCategory === 5)
                                            @break
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-content">
                                <?php $countCategory = 0; ?>
                                @foreach ($productsOfCategory as $categorieName => $productOfCategory)
                                    <div class="tab-pane fade{{ $countCategory == 0 ? ' active in' : '' }}"
                                        id="{{ $categorieName }}">
                                        <?php $countCategory++; ?>
                                        @if (count($productsOfCategory[$categorieName]) != 0)
                                            @foreach ($productsOfCategory[$categorieName] as $product)
                                                <div class="col-sm-3">
                                                    <a href="{{ route('products.show', $product->id) }}">
                                                        <div class="card item-product">
                                                            <div>
                                                                <img src="{{ $product['img_link'] }}"
                                                                    class="card-img-top"
                                                                    style="width: 100%; height: 125px">
                                                            </div>
                                                            <div class="card-body text-center">
                                                                <h3 class="card-title text-center item-product-price">
                                                                    ${{ $product['price'] }}</h3>
                                                                <p class="card-text text-center">{{ $product['name'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="col-sm-6"
                                                style="font-size: 24px; font-style: italic; font-weight: bold; opacity: 50%">
                                                No result of category</p>
                                        @endif
                                    </div>
                                    @if ($countCategory === 5)
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                <!--/category-tab-->
                <!--recommended_items-->
                <h2 class="title text-center">recommended items</h2>
                <div class="owl-carousel owl-theme">
                    @foreach ($productsRecommend as $key => $product)
                        <a href="{{ route('products.show', $product['id']) }}">
                            <div class="item card item-product">
                                <div>
                                    <img src="{{ $product['img_link'] }}" class="card-img-top"
                                        style="width: 100%; height: 250px">
                                </div>
                                <div class="card-body text-center">
                                    <h3 class="card-title text-center item-product-price">
                                        ${{ $product['price'] }}</h3>
                                    <p class="card-text text-center">{{ $product['name'] }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
