<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Services\RoleService;

class HomeController extends Controller
{
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->roleRepository->all();
        $rolesAdmin = auth()->user()->roles->pluck('id')->toArray();
        return view('admin.index', compact('roles', 'rolesAdmin'));
    }
}
