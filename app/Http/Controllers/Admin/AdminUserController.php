<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\AddressService;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
{
    public function __construct(UserService $userService, AddressService $addressService, AdminService $adminService)
    {
        $this->middleware('role:admin');
        $this->userService = $userService;
        $this->addressService = $addressService;
        $this->adminService = $adminService;
    }

    public function index(Request $request)
    {
        if ($request->ajax() || 'NULL') {
            $users = $this->userService->getUsers($request);
            return view('admin.users.index', compact('users'));
        }
    }

    public function edit($id)
    {
        if (Gate::denies('edit_user')) {
            Alert::error('Error', 'you have no permission');
            return redirect()->back();
        }
        $user = $this->userService->userRepository->show($id);
        $addresses = $this->addressService->getAddressesByUser($user);
        return view('admin.users.edit', compact('user', 'addresses'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        if (Gate::denies('edit_user')) {
            Alert::error('Error', 'you have no permission');
            return redirect()->back();
        }

        if ($this->addressService->getIdAddressByUser($id) != array_keys($request->address)) {
            Alert::error('Error Update', 'AddressId is not valid');
            return redirect()->back();
        }

        $result = $this->userService->updateUser($request, $id);
        if (!$result) {
            Alert::error('Error Update', 'Update user error');
            return redirect()->back();
        }

        Alert::success('Success Update', 'Update user successfully');
        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $result = $this->adminService->changeStatusUser($id);
        if ($result instanceof \Exception) {
            Alert::error('Error', $result->getMessage());
            return redirect()->back();
        }
        Alert::success('Success', 'change successfully');
        return redirect()->back();
    }
}
