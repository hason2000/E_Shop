<?php

namespace App\Services;

use App\Repositories\Roles\RoleRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function createRole($name)
    {
        $role = $this->roleRepository->createRole($name);
        return $role instanceof Role;
    }

    public function updatePermissionsOfRoles($data)
    {
        DB::beginTransaction();
        try {
            $nameRoles = $this->roleRepository->all()->pluck('name')->toArray();
            foreach ($nameRoles as $nameRole) {
                $role = $this->roleRepository->getRoleByName($nameRole);
                if (in_array($nameRole, array_keys($data))) {
                    $role->syncPermissions($data[$nameRole]);
                } else {
                    $role->syncPermissions([]);
                }
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
