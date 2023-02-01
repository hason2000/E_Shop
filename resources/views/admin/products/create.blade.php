@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="custom-product-img-admin">
            <img id="product-img-admin" src="{{ asset('images/product-details/add_image.jpg') }}" alt=""
                 style="width: 100%; height: 100%;">
            <label for="img-file-product-admin" class="avatar-product-admin-cus" id="label-change-avatar-product"><i
                    class="fa fa-camera" aria-hidden="true"></i></label>
            @if ($errors->first('img_link'))
                <span class="register-error-content">{{ $errors->first('img_link') }}</span>
            @endif
        </div>
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="img_link" accept="image/*" id="img-file-product-admin"
                   style="position: absolute; left: -999px">
            <div class="admin-form-information row" style="margin-top: 20px">
                <div class="form-group col-sm-6">
                    <label for="name-product-admin">Name product:</label>
                    <input type="text" class="form-control" id="name-product-admin" name="name"
                           value="{{ old('name') }}"
                           placeholder="name product" required>
                    @if ($errors->first('name'))
                        <span class="register-error-content">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="shop-product-admin">Shop:</label>
                    <select class="form-control" name="shop_id" id="shop-admin" required>
                        <option value="{{ null }}" selected>Choose shop</option>
                        @foreach ($shops as $shop)
                            <option value="{{ $shop->id }}"
                                    @if($shop->id == old('shop_id')) selected @endif>{{ $shop->id }}
                                - {{ $shop->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('shop_id'))
                        <span class="register-error-content">{{ $errors->first('shop_id') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="category-product-admin">Category:</label>
                    <select class="form-control" name="category_id" id="category-admin" required>
                        <option value="{{ null }}" selected>Choose category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                    @if($category->id == old('category_id')) selected @endif>{{ $category->id }}
                                - {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('category_id'))
                        <span class="register-error-content">{{ $errors->first('category_id') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="brand-product-admin">Brand:</label>
                    <select class="form-control" name="brand_id" id="brand-admin" required>
                        <option value="{{ null }}" selected>Choose brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                    @if($brand->id == old('brand_id')) selected @endif>{{ $brand->id }}
                                - {{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('brand_id'))
                        <span class="register-error-content">{{ $errors->first('brand_id') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="condition-product-admin">Condition:</label>
                    <select class="form-control" name="condition" id="condition-product-admin" required>
                        <option value="{{ null }}" selected>Choose condition</option>
                        <option value="0" @if(old('shop_id') == 0) selected @endif>0-new</option>
                        <option value="1" @if(old('shop_id') == 1) selected @endif>1-sale</option>
                    </select>
                    @if ($errors->first('condition'))
                        <span class="register-error-content">{{ $errors->first('condition') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="price-product-admin">Price:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="price" value="{{ old('price') }}"
                               placeholder="price">
                        <span class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span>
                        @if ($errors->first('price'))
                            <span class="register-error-content">{{ $errors->first('price') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="detail-product-admin">Detail:</label>
                    <textarea class="form-control" name="detail" id="detail-product-admin" cols="30" rows="10"
                              placeholder="detail product">{{ old('detail') }}</textarea>
                </div>
                <h3 class="col-sm-12">Size Amount Of Product</h3>
                @foreach ($sizes as $size)
                    {{-- @dd(old('size.' .$size->id)) --}}
                    {{-- @dump(is_null(old("'size['.{{ $size->id }}.']'"))) --}}
                    <div class="form-group col-sm-6">
                        <label for="">Size {{ $size->name }}:</label>
                        <input type="number" min="0" class="form-control amount-size-admin"
                               name="size[{{ $size->id }}]"
                               value="{{ !is_null(old('size.' .$size->id)) ? old('size.' .$size->id) : 0 }}"
                               placeholder="amout size {{ $size->name }}" required>
                        @if ($errors->first('size.' . $size->id))
                            <span class="register-error-content">{{ $errors->first('size.' . $size->id) }}</span>
                        @endif
                    </div>
                @endforeach
                <div class="form-group col-sm-12">
                    @if ($errors->first('size'))
                        <span class="register-error-content">{{ $errors->first('size') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="sub-img">Sub Img</label>
                    <div class="col-sm-12" style="margin-bottom:10px;">
                        <div class="btn btn-info" id="btn-add-subimg">Add subImg</div>
                        <div style="display: flex; flex-wrap: wrap; margin-top: 20px;" id="contain-subimg-add">
                        </div>
                    </div>
{{--                    <div style="width: 100%; height: 160px; display: flex; flex-wrap: wrap; margin-top: 20px"--}}
{{--                         id="sub-img-show">--}}
{{--                        @for ($i = 0; $i < 3; $i++)--}}
{{--                            <div class="img-item" style="margin-right: 15px; cursor: pointer;">--}}
{{--                                <label for="sub-img-no-{{ $i }}" class="label-change-subimg">--}}
{{--                                    <input class="form-control" type="file" name="sub_img[no{{ $i }}]"--}}
{{--                                           accept="image/*" id="sub-img-no-{{ $i }}"--}}
{{--                                           style="position: absolute; left: -9999px;">--}}
{{--                                    <img id="sub-img-admin-no-{{ $i }}"--}}
{{--                                         style="height: 100%; width: 136px; cursor: pointer;"--}}
{{--                                         src="{{ asset('images/product-details/add_image.jpg') }}" alt="">--}}
{{--                                </label>--}}
{{--                                @if ($errors->first('sub_img.' . 'no'.$i))--}}
{{--                                    <span--}}
{{--                                        class="register-error-content">{{ $errors->first('sub_img.' . 'no'.$i) }}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        @endfor--}}
{{--                    </div>--}}
                </div>
            </div>
            <div style="text-align: right; padding-right: 5px; display: flex; align-items: center">
                <button class="btn btn-success" type="submit">Create</button>
                <button class="btn btn-default"><a href="{{ route('admin.index') }}">Home</a></button>
            </div>
        </form>
    </div>
@endsection
