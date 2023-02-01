<div class="col-sm-3" style="background-color: white">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            @foreach ($categories as $key => $category)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="{{ isset($request['category_id']) && $request['category_id'] == $category->id ? 'category-selected-cus' : '' }}"
                               data-toggle="collapse" data-parent="#accordian"
                               href="#{{ $category->name . '-' . $category->id }}">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                {{ $category->name }}
                            </a>
                        </h4>
                    </div>
                    @if (!is_null($brandsOfCategory[$key]))
                        <div id="{{ $category->name . '-' . $category->id }}"
                             class="panel-collapse {{ isset($request['category_id']) && $request['category_id'] == $category->id ? 'in' : 'collapse' }}">
                            <div class="panel-body panel-body-custom">
                                <ul>
                                    @foreach ($brandsOfCategory[$key] as $key => $brand)
                                        <li>
                                            <a class="queryhome {{ isset($request['category_id']) && $request['category_id'] == $category->id && isset($request['brand_id']) && $request['brand_id'] == $brand->id ? 'brand-selected-cus' : '' }}"
                                               href="{{ route('products.index', ['category_id' => $category->id, 'brand_id' => $brand->id]) }}">{{ $brand->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <!--/category-products-->

        <div class="brands_products">
            <!--brands_products-->
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    @foreach ($brands as $brand)
                        <li>
                            <a class="queryhome {{ isset($request['brand_id']) && $request['brand_id'] == $brand->id ? 'brand-selected-cus' : '' }}"
                               href="{{ route('products.index', ['brand_id' => $brand->id]) }}">{{ $brand->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--/brands_products-->

        <div class="price-range">
            <!--price-range-->
            <h2>Price Range</h2>
            <div class="well text-center">
                <input type="text" class="span2" value="" data-slider-min="0"
                       data-slider-max="600" data-slider-step="5"
                       data-slider-value="{{ isset($request['price_start']) && isset($request['price_finish']) ? '[' . $request['price_start'] . ',' . $request['price_finish'] . ']' : '[0,600]' }}"
                       id="sl2"><br/>
                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div>
        <!--/price-range-->
    </div>
</div>
