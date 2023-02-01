@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div style="position: relative">
            <div class="custom-user-img-admin"
                 style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden;">
                <img id="user-img-admin" src="{{ $user->avatar }}" alt="" style="width: 100%; height: 100%;">
                <label for="img-file-user-admin" class="avatar-user-admin-cus" id="label-change-avatar-user"
                       style="position: absolute; bottom: -20%; left: 2px;"><i class="fa fa-camera"
                                                                               aria-hidden="true"></i></label>
            </div>
        </div>
        <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="file" name="avatar" accept="image/*" id="img-file-user-admin"
                   style="position: absolute;
            left: -999px" multiple>
            <div class="admin-form-information row" style="margin-top: 20px">
                <div class="form-group col-sm-6">
                    <label for="email-admin">Email:</label>
                    <input type="email" class="form-control" id="email-admin" name="email" value="{{ $user->email }}"
                           readonly disabled='disabled'>
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Name:</label>
                    <input type="text" class="form-control" id="name-user-admin" name="name"
                           value="{{ old('name') ? old('name') : $user->name }}">
                    @if ($errors->first('name'))
                        <span class="register-error-content">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Date of birth:</label>
                    <input class="form-control" type="date"
                           value="{{ old('date_of_birth') ? old('date_of_birth') : $user->date_of_birth }}"
                           name="date_of_birth">
                    @if ($errors->first('date_of_birth'))
                        <span class="register-error-content">{{ $errors->first('date_of_birth') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Phone number:</label>
                    <input class="form-control" type="text"
                           value="{{ old('phone_number') ? old('phone_number') : $user->phone_number }}"
                           name="phone_number">
                    @if ($errors->first('phone_number'))
                        <span class="register-error-content">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>
                <div class="form-group col-sm-6">
                    <label>Address default:</label>
                    <select class="form-control" name="address_default">
                        <option value="">Chose address default</option>
                        @foreach ($addresses as $address)
                            <option @if ($user->address_default == $address->id) selected
                                    @endif value="{{ $address->id }}">
                                {{ $address->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-6">
                    <label for="">Password:</label>
                    <input class="form-control" type="password" name="password">
                    @if ($errors->first('password'))
                        <span class="register-error-content">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <h3 class="col-sm-12">Address</h3>
                @foreach ($addresses as $address)
                    <a href="#">
                        <div class="col-sm-12 custom-row-address" style="">
                            <div class="form-group col-sm-1">
                                <label for="">id-{{ $address->id }}</label>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="number-address-shop">Number</label>
                                <input type="text" class="form-control"
                                       value="{{ old('address.number') ? old('address.number') : $address->number }}"
                                       name="address[{{ $address->id }}][number]">
                                @if ($errors->first('address.number'))
                                    <span class="register-error-content">{{ $errors->first('address.number') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="">Street</label>
                                <input type="text" class="form-control"
                                       value="{{ old('address.street') ? old('address.street') : $address->street }}"
                                       name="address[{{ $address->id }}][street]">
                                @if ($errors->first('address.street'))
                                    <span class="register-error-content">{{ $errors->first('address.street') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="">Ward</label>
                                <input type="text" class="form-control"
                                       value="{{ old('address.ward') ? old('address.ward') : $address->ward }}"
                                       name="address[{{ $address->id }}][ward]">
                                @if ($errors->first('address.ward'))
                                    <span class="register-error-content">{{ $errors->first('address.ward') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="">City</label>
                                <input type="text" class="form-control"
                                       value="{{ old('address.city') ? old('address.city') : $address->city }}"
                                       name="address[{{ $address->id }}][city]">
                                @if ($errors->first('address.city'))
                                    <span class="register-error-content">{{ $errors->first('address.city') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="number-address-shop">Province</label>
                                <input type="text" class="form-control"
                                       value="{{ old('province') ? old('province') : $address->province }}"
                                       name="address[{{ $address->id }}][province]">
                                @if ($errors->first('address.province'))
                                    <span class="register-error-content">{{ $errors->first('address.province') }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="text-align: right; padding-right: 5px; display: flex">
                <button class="btn btn-success" style="margin-top: 10px" type="submit">Update</button>
                <button type="button" class="btn btn-info" style="margin-top: 10px" data-toggle="modal"
                        data-target="#modal-add-address"><i class="fa fa-plus" aria-hidden="true"></i>Add Address
                </button>
            </div>
        </form>
        <div id="modal-add-address"
             class="modal fade @if($errors->first('number') || $errors->first('street') || $errors->first('ward') || $errors->first('city') || $errors->first('province'))message-error @endif"
             role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form action="{{ route('admin.address.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Address</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Number</label>
                                    <input type="text" class="form-control"
                                           value="{{ old('address.number') ?? old('address.number') }}"
                                           name="number">
                                    @if ($errors->first('number'))
                                        <span class="register-error-content">{{ $errors->first('number') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="">Street</label>
                                    <input type="text" class="form-control"
                                           value="{{ old('street') ?? old('street') }}"
                                           name="street">
                                    @if ($errors->first('street'))
                                        <span class="register-error-content">{{ $errors->first('street') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="">Ward</label>
                                    <input type="text" class="form-control"
                                           value="{{ old('ward') ?? old('ward') }}"
                                           name="ward">
                                    @if ($errors->first('ward'))
                                        <span class="register-error-content">{{ $errors->first('ward') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="">City</label>
                                    <input type="text" class="form-control"
                                           value="{{ old('city') ?? old('city') }}"
                                           name="city">
                                    @if ($errors->first('city'))
                                        <span class="register-error-content">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Province</label>
                                    <input type="text" class="form-control"
                                           value="{{ old('province') ?? old('province') }}"
                                           name="province">
                                    @if ($errors->first('province'))
                                        <span
                                            class="register-error-content">{{ $errors->first('province') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
