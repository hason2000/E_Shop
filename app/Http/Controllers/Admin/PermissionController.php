<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->permissionRepository->all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(PermissionRequest $request)
    {
        $result = $this->permissionService->createPermission($request->name);

        if (!$result) {
            Alert::error('Create Error');
            return redirect()->back();
        }

        Alert::success('Create Success');
        return redirect()->back();
    }

    public function update(PermissionRequest $request, $id)
    {
        $data = [
            'name' => $request['name-update']
        ];
        $result = $this->permissionService->permissionRepository->update($id, $data);

        if (!$result) {
            Alert::error('Update Error', 'permission update error');
            return redirect()->back();
        }

        Alert::success('Update Success', 'permission update successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $result = $this->permissionService->permissionRepository->delete($id);
        if (!$result) {
            Alert::error('Delete error', 'permission delete fail');
            return redirect()->back();
        }
        Alert::success('Delete success');
        return redirect()->back();
    }
}
