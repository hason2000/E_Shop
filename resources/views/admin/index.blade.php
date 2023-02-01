@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            {{-- top --}}
            <div class="col-sm-3">
                <div class="admin-avatar-img">
                    <img id="avatar-admin-id" src="{{ auth()->guard('admin')->user()->avatar }}" alt=""
                         style="width: 100%; height: 100%;">
                    <label for="avatar-admin" class="avatar-admin-cus" id="label-change-avatar"><i class="fa fa-camera"
                                                                                                   aria-hidden="true"></i></label>
                    <div class="cancel-avatar"><i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
                @if ($errors->first('avatar'))
                    <span class="register-error-content">{{ $errors->first('avatar') }}</span>
                @endif
            </div>
            <div class="col-sm-9">
                <h1 style="margin-left: 209px; margin-top: 65px">
                    Welcome {{ auth()->guard('admin')->user()->username }}</h1>
            </div>
            {{-- end top --}}
            <form action="{{ route('admin.update', ['id' => auth()->guard('admin')->id()]) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="file" name="avatar" accept="image/*" id="avatar-admin">
                <div class="admin-form-information col-sm-12" style="margin-top: 20px">
                    @can('is-super-admin')
                        <div class="form-group col-sm-6">
                            <label for="email-admin">Email:</label>
                            <input type="email" class="form-control" id="email-admin" name="email"
                                   value="{{ old('email') ? old('email') : auth()->guard('admin')->user()->email }}">
                            @if($errors->first('email'))
                                <span class="register-error-content">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="username-admin">Username:</label>
                            <input type="text" class="form-control" id="username-admin" name="username"
                                   value="{{ old('username') ? old('username') : auth()->guard('admin')->user()->username }}">
                            @if($errors->first('username'))
                                <span class="register-error-content">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    @else
                        <div class="form-group col-sm-6">
                            <label for="email-admin">Email:</label>
                            <input type="email" class="form-control" id="email-admin" name="email"
                                   value="{{ auth()->guard('admin')->user()->email }}" readonly disabled='disabled'>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Username:</label>
                            <input type="text" class="form-control" name="username"
                                   value="{{ auth()->guard('admin')->user()->username }}" readonly disabled='disabled'>
                        </div>
                    @endcan

                    <div class="form-group col-sm-6">
                        <label for="phonenumber-admin">Phone number:</label>
                        <input type="text"
                               class="form-control {{ $errors->first('phone_number') ? 'register-error-input' : '' }}"
                               id="phonenumber-admin" name="phone_number" placeholder="phone number"
                               value="{{ auth()->guard('admin')->user()->phone_number }}">
                        @if ($errors->first('phone_number'))
                            <span class="register-error-content">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Password:</label>
                        <input type="password"
                               class="form-control {{ $errors->first('password') ? 'register-error-input' : '' }}"
                               name="password" placeholder="password">
                        @if ($errors->first('password'))
                            <span class="register-error-content">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    @can('is-super-admin')
                        <div class="form-group col-sm-6">
                            <label for="role-admin">Role:</label>
                            <select class="form-control select-custom" name="role-admin[]" multiple="multiple">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if (in_array($role->id, $rolesAdmin)) selected="selected" @endif>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Lock:</label>
                            <select class="form-control select-custom" name="lock">
                                <option value="0" {{ auth()->guard('admin')->user()->lock ==0 ??'selected' }}>Unlock
                                </option>
                                <option value="1" {{ auth()->guard('admin')->user()->lock ==1 ??'selected' }}>Locked
                                </option>
                            </select>
                        </div>
                    @else
                        <div class="form-group col-sm-6">
                            <label for="role-admin">Role:</label>
                            <select class="form-control select-custom" name="role-admin[]" multiple="multiple" disabled>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if (in_array($role->id, $rolesAdmin)) selected="selected" @endif>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Lock:</label>
                            <select class="form-control select-custom" name="lock" disabled>
                                <option value="0" {{ auth()->guard('admin')->user()->lock ==0 ??'selected' }}>Unlock
                                </option>
                                <option value="1" {{ auth()->guard('admin')->user()->lock ==1 ??'selected' }}>Locked
                                </option>
                            </select>
                        </div>
                    @endcan
                    <div style="text-align: right; padding-right: 5px;">
                        <button class="btn btn-success" style="margin-top: 10px" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
