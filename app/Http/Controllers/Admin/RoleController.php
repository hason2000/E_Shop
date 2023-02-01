<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $roles = $this->roleService->roleRepository->all();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(RoleRequest $request)
    {
        $result = $this->roleService->createRole($request->name);

        if (!$result) {
            Alert::error('Create Error');
            return redirect()->back();
        }

        Alert::success('Create Success');
        return redirect()->back();
    }

    public function update(RoleRequest $request, $id)
    {
        $data = [
          'name' => $request['name-update']
        ];
        $result = $this->roleService->roleRepository->update($id, $data);

        if (!$result) {
            Alert::error('Update Error', 'role update error');
            return redirect()->back();
        }

        Alert::success('Update Success', 'role update successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $result = $this->roleService->roleRepository->delete($id);
        if (!$result) {
            Alert::error('Delete error', 'role delete fail');
            return redirect()->back();
        }
        Alert::success('Delete success');
        return redirect()->back();
    }

    public function showAuthorizeRole()
    {
        $roles = $this->roleService->roleRepository->allRolesWithPermission();
        $permissions = $this->permissionService->permissionRepository->all();
        return view('admin.roles.authorize', compact('roles', 'permissions'));
    }

    public function updatePermissionsOfRoles(Request $request)
    {
        $data = $request->all();
        unset($data['_token'], $data['_method']);
        $result = $this->roleService->updatePermissionsOfRoles($data);
        if ($result instanceof Exception) {
            Alert::error('Update Fail', $result->getMessage());
            return redirect()->back();
        }

        Alert::success('Update Successfull', 'role update successful');
        return redirect()->back();
    }
}
