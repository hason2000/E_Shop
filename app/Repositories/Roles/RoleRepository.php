<?php

namespace App\Repositories\Roles;


use App\Repositories\AbstractRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function createRole($name)
    {
        return $this->model->create(['name' => $name]);;
    }

    public function allRolesWithPermission()
    {
        return $this->model->with('permissions')->get();
    }

    public function getRoleByName($name)
    {
        return Role::findByName($name);
    }
}
