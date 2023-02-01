<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\UpdateAdminRequest;
use App\Services\AdminService;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{

    public function __construct(AdminService $adminService, RoleService $roleService, PermissionService $permissionService)
    {
        $this->middleware(['role:admin']);
        $this->middleware(['role:super_admin'])->except(['update',
            'showAll',
            'edit',]);
        $this->adminService = $adminService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        if (Gate::denies('can-update', $id)) {
            Alert::error('Error');
            return redirect()->back();
        }

        if ((isset($request['role-admin']) || isset($request['lock'])) && !auth()->user()->hasRole('super_admin')) {
            Alert::error('Error');
            return redirect()->back();
        }

        $result = $this->adminService->updateAdmin($id, $request);
        if ($result instanceof \Exception) {
            Alert::error('Error Update', $result->getMessage());
            return redirect()->back();
        }

        Alert::success('Success Update', 'Successfully update admin');
        return redirect()->back();
    }

    public function showAll(Request $request)
    {
        if ($request->ajax() || 'NULL') {
            $admins = $this->adminService->getAllAdmin();
            return view('admin.admins.showall', compact('admins'));
        }
    }

    public function changeStatus(Request $request)
    {
        $adminId = $request['id'];
        $result = $this->adminService->changeStatus($adminId);

        if (!$result) {
            Alert::error('Error Change', 'change status fail');
            return redirect()->back();
        }

        Alert::success('Success Change', 'change status success');
        return redirect()->back();
    }

    public function edit($id)
    {
        $admin = $this->adminService->adminRepository->show($id);
        return view('admin.admins.edit', compact('admin'));
    }

    public function authorizeAdmin(Request $request)
    {
        $admins = $this->adminService->getAllAdmin();
        $roles = $this->roleService->roleRepository->all();
        return view('admin.admins.authorize', compact('admins', 'roles'));
    }

    public function updateRoles(Request $request)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $result = $this->adminService->updateRolesAdmins($data);

        if ($result instanceof Exception) {
            Alert::error('Update Fail', $result->getMessage());
            return redirect()->back();
        }

        Alert::success('Update Successfull', 'role update successful');
        return redirect()->back();
    }

    public function permissionAdmin(Request $request)
    {
        $admins = $this->adminService->adminRepository->getAdminsWithPermission();
        $permissions = $this->permissionService->permissionRepository->all();
        return view('admin.admins.permission', compact('admins', 'permissions'));
    }

    public function updatePermissions(Request $request)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $result = $this->adminService->updatePermissionsAdmins($data);

        if ($result instanceof Exception) {
            Alert::error('Update Fail', $result->getMessage());
            return redirect()->back();
        }

        Alert::success('Update Successfull', 'permission update successful');
        return redirect()->back();

    }
}
