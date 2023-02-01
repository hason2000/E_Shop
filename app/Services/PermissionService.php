<?php

namespace App\Services;

use App\Repositories\Permission\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function createPermission($name)
    {
        $permission = $this->permissionRepository->createPermission($name);
        return $permission instanceof Permission;
    }
}
