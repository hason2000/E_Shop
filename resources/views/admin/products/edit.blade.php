@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="custom-product-img-admin">
            <img id="product-img-admin" src="{{ $product->img_link }}" alt="" style="width: 100%; height: 100%;">
            <label for="img-file-product-admin" class="avatar-product-admin-cus" id="label-change-avatar-product"><i
                    class="fa fa-camera" aria-hidden="true"></i></label>
        </div>
        <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="file" name="img_link" accept="image/*" id="img-file-product-admin"
                   style="position: absolute;
            left: -999px" multiple>
            <div class="admin-form-information row" style="margin-top: 20px">
                <div class="form-group col-sm-6">
                    <label for="name-product-admin">Name product:</label>
                    <input type="text" class="form-control" id="name-product-admin" name="name"
                           value="{{ $product->name }}">
                    @if ($errors->first('name'))
                        <span class="register-error-content">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="shop-product-admin">Shop:</label>
                    <select class="form-control" name="shop_id" id="shop-admin">
                        @foreach ($shops as $shop)
                            <option @if ($product->shop->id == $shop->id) selected @endif value="{{ $shop->id }}">
                                {{ $shop->id }} - {{ $shop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="category-product-admin">Category:</label>
                    <select class="form-control" name="category_id" id="category-admin">
                        @foreach ($categories as $category)
                            <option @if ($product->category->id == $category->id) selected
                                    @endif value="{{ $category->id }}">
                                {{ $category->id }} - {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="brand-product-admin">Brand:</label>
                    <select class="form-control" name="brand_id" id="brand-admin">
                        @foreach ($brands as $brand)
                            <option @if ($product->brand->id == $brand->id) selected @endif value="{{ $brand->id }}">
                                {{ $brand->id }} - {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="condition-product-admin">Condition:</label>
                    <select class="form-control" name="condition" id="condition-product-admin">
                        <option value="0" @if ($product->codition == 0) selected @endif>0-new</option>
                        <option value="1" @if ($product->codition == 1) selected @endif>1-sale</option>
                    </select>
                    @if ($errors->first('condition'))
                        <span class="register-error-content">{{ $errors->first('condition') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="price-product-admin">Price:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                        <span class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span>
                        @if ($errors->first('price'))
                            <span class="register-error-content">{{ $errors->first('price') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="detail-product-admin">Detail:</label>
                    <textarea class="form-control" name="detail" id="detail-product-admin" cols="30"
                              rows="10">{{ $product->detail }}</textarea>
                </div>
                <h3 class="col-sm-12">Size Amount Of Product</h3>
                @foreach ($sizes as $size)
                    <div class="form-group col-sm-6">
                        <label for="">Size {{ $size->name }}:</label>
                        <input type="number" min="0" class="form-control amount-size-admin"
                               name="size[{{ $size->id }}]"
                               value="{{ isset($sizesOfProduct[$size->name]) ? $sizesOfProduct[$size->name] : 0 }}">
                        @if ($errors->first('size.' . $size->id))
                            <span class="register-error-content">{{ $errors->first('size.' . $size->id) }}</span>
                        @endif
                    </div>
                @endforeach
                <div class="form-group col-sm-6">
                    <label for="sub-img">Sub Img</label>
                    @if (count($subImgs) == 0)
                        <p>No subImg result</p>
                    @endif
                    {{--                    style="width: 100%; height: 160px; display: flex; flex-wrap: wrap; margin-top: 20px"--}}
                    @if (count($subImgs) != 0)
                        <div id="sub-img-show" class="owl-carousel owl-theme"
                             style="width: 100%; height: 160px; display: flex; flex-wrap: wrap; margin-top: 20px">
                            @foreach ($subImgs as $subImg)
                                <div class="img-item item" style="margin-right: 15px">
                                    <label for="sub-img-{{ $subImg['id'] }}" class="label-change-subimg">
                                        <input class="form-control" type="file" name="sub_img[{{ $subImg['id'] }}]"
                                               accept="image/*" id="sub-img-{{ $subImg['id'] }}"
                                               style="position: absolute; left: -9999px;">
                                        @if (is_null($subImg['link']))
                                            <img id="sub-img-admin-{{ $subImg['id'] }}"
                                                 style="height: 100%; width: 136px;"
                                                 src="{{ asset('images/home/avatar_default.jpg') }}" alt="">
                                        @else
                                            <img id="sub-img-admin-{{ $subImg['id'] }}"
                                                 style="height: 100%; width: 136px;" src="{{ $subImg['link'] }}"
                                                 alt="">
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                            @endif
                        </div>
                </div>
                <div class="col-sm-12" style="margin-top: 40px;">
                    <div class="btn btn-info" id="btn-add-subimg">Add subImg</div>
                    <div style="display: flex; flex-wrap: wrap;" id="contain-subimg-add">
                    </div>
                </div>
            </div>
            <div style="text-align: right; padding: 10px 5px; display: flex; justify-content: end">
                <button class="btn btn-success" type="submit">Update</button>
                <button class="btn btn-default"><a href="{{ route('admin.product.in_stock') }}">Back</a></button>
            </div>
        </form>
    </div>
@endsection
