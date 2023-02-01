@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div style="position: relative">
            <div class="custom-shop-img-admin"
                 style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                <img id="shop-img-admin" src="{{ $shop->img_shop }}" alt="" style="width: 100%; height: 100%;">
                <label for="img-file-shop-admin" class="avatar-shop-admin-cus" id="label-change-avatar-shop"
                       style="position: absolute; bottom: -20%; left: 2px;"><i class="fa fa-camera"
                                                                               aria-hidden="true"></i></label>
            </div>
        </div>
        <form action="{{ route('admin.shop.update', ['id' => $shop->id]) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="file" name="img_shop" accept="image/*" id="img-file-shop-admin"
                   style="position: absolute;
            left: -999px" multiple>
            <div class="admin-form-information row" style="margin-top: 20px">
                <div class="form-group col-sm-6">
                    <label for="name-shop-admin">Name shop:</label>
                    <input type="text" class="form-control" id="name-shop-admin" name="name"
                           value="{{ old('name') ? old('name') : $shop->name }}">
                    @if ($errors->first('name'))
                        <span class="register-error-content">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="web-shop-admin">Website:</label>
                    <input class="form-control" type="text"
                           value="{{ old('web_site') ? old('web_site') : $shop->web_site }}" name="web_site">
                    @if ($errors->first('web_site'))
                        <span class="register-error-content">{{ $errors->first('web_site') }}</span>
                    @endif
                </div>
                <h3 class="col-sm-12">Address</h3>
                <div class="form-group col-sm-2">
                    <label for="number-address-shop">Number</label>
                    <input type="text" class="form-control"
                           value="{{ old('address.number') ? old('address.number') : $address->number }}"
                           name="address[number]">
                    @if ($errors->first('address.number'))
                        <span class="register-error-content">{{ $errors->first('address.number') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-2">
                    <label for="">Street</label>
                    <input type="text" class="form-control"
                           value="{{ old('address.street') ? old('address.street') : $address->street }}"
                           name="address[street]">
                    @if ($errors->first('address.street'))
                        <span class="register-error-content">{{ $errors->first('address.street') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-2">
                    <label for="">Ward</label>
                    <input type="text" class="form-control"
                           value="{{ old('address.ward') ? old('address.ward') : $address->ward }}"
                           name="address[ward]">
                    @if ($errors->first('address.ward'))
                        <span class="register-error-content">{{ $errors->first('address.ward') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-2">
                    <label for="">City</label>
                    <input type="text" class="form-control"
                           value="{{ old('address.city') ? old('address.city') : $address->city }}"
                           name="address[city]">
                    @if ($errors->first('address.city'))
                        <span class="register-error-content">{{ $errors->first('address.city') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-2">
                    <label for="number-address-shop">Province</label>
                    <input type="text" class="form-control"
                           value="{{ old('province') ? old('province') : $address->province }}"
                           name="address[province]">
                    @if ($errors->first('address.province'))
                        <span class="register-error-content">{{ $errors->first('address.province') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-12">
                    <label for="comment">Detail:</label>
                    <textarea class="form-control" rows="5" id="comment" name="detail">{{ $shop->detail }}</textarea>
                    @if ($errors->first('detail'))
                        <span class="register-error-content">{{ $errors->first('detail') }}</span>
                    @endif
                </div>
            </div>
            <div style="text-align: right; padding-right: 5px;">
                <button type="submit" class="btn btn-success" style="margin-top: 10px" type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection
