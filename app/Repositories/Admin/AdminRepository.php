<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\AbstractRepository;

class AdminRepository extends AbstractRepository implements AdminRepositoryInterface
{
    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function getUsernameAdminLock()
    {
        return Admin::where('lock', 1)->get()->pluck('username')->toArray();
    }

    public function getAdminsWithPermission()
    {
        return Admin::with('permissions')->get();
    }
}
