<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\CreateAddressUserRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAddressUserController extends Controller
{
    public function __construct(AddressService $addressService)
    {
        $this->middleware('role:admin');
        $this->addressService = $addressService;
    }

    public function store(CreateAddressUserRequest $request)
    {
        if (Gate::denies('edit_user')) {
            Alert::error('Error', 'you have no permission');
            return redirect()->back();
        }
        $result = $this->addressService->addressRepository->store($request->all());
        if (!$result instanceof Address) {
            Alert::error('Error Create', 'Create Address Error');
            return redirect()->back();
        }
        Alert::success('Success Create', 'Create Address Success');
        return redirect()->back();
    }
}
