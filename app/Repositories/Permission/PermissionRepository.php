<?php

namespace App\Repositories\Permission;

use App\Repositories\AbstractRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function createPermission($name)
    {
        return $this->model->create(['name' => $name]);;
    }
}
