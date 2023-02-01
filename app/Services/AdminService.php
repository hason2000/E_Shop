<?php

namespace App\Services;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class AdminService
{
    public function __construct(AdminRepositoryInterface $adminRepository, UserRepositoryInterface $userRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
    }

    public function updateAdmin($id, $data)
    {
        DB::beginTransaction();
        try {
            $dataUpdate = [
                'phone_number' => $data['phone_number']
            ];

            if (isset($data['email'])) {
                $dataUpdate['email'] = $data['email'];
            }

            if (isset($data['username'])) {
                $dataUpdate['username'] = $data['username'];
            }

            if (isset($data['lock'])) {
                $dataUpdate['lock'] = $data['lock'];
            }

            if (!is_null($data['password'])) {
                $dataUpdate['password'] = $data['password'];
            }

            if ($data->hasFile('avatar')) {
                $img = $data->file('avatar');
                $imgResize = Image::make($img)->resize(200, 200);
                Storage::put('public/images/' . $img->getClientOriginalName(), (string)$imgResize->encode());
                $dataUpdate = array_merge($dataUpdate, [
                    'avatar' => asset('storage/images/' . $img->getClientOriginalName())
                ]);
            }

            $result = $this->adminRepository->update($id, $dataUpdate);

            if (!$result) {
                throw new Exception('Update info admin fail');
            }
            if (!auth()->user()->hasRole('super_admin')) {

            } else if (auth()->user()->hasRole('super_admin') && isset($data['role-admin']) && !empty($data['role-admin'])) {
                auth()->user()->syncRoles($data['role-admin']);
            } else {
                auth()->user()->syncRoles([]);
            }

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function isLockAdminByUsername($username)
    {
        return in_array($username, $this->adminRepository->getUsernameAdminLock());
    }

    public function getAllAdmin()
    {
        $admins = $this->adminRepository->all();
        return $this->paginate($admins, 5, null, []);
    }

    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function changeStatus($adminId)
    {
        DB::beginTransaction();
        try {
            $admin = $this->adminRepository->show($adminId);
            if ($admin->lock == 0) {
                $this->adminRepository->update($adminId, ['lock' => 1]);
            } else {
                $this->adminRepository->update($adminId, ['lock' => 0]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateRolesAdmins($data)
    {
        DB::beginTransaction();
        try {
            $admins = $this->adminRepository->all();
            foreach ($admins as $admin) {
                if (!empty($data) && in_array($admin->id, array_keys($data['roles-admin']))) {
                    $admin->syncRoles($data['roles-admin'][$admin->id]);
                } else {
                    $admin->syncRoles([]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

    }

    public function updatePermissionsAdmins($data)
    {
        DB::beginTransaction();
        try {
            $admins = $this->adminRepository->all();
            foreach ($admins as $admin) {
                if (!empty($data) && in_array($admin->id, array_keys($data['admin-permission']))) {
                    $admin->syncPermissions($data['admin-permission'][$admin->id]);
                } else {
                    $admin->syncPermissions([]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function changeStatusUser($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->show($id);
            if ($user->lock == 0) {
                $this->userRepository->update($id, ['lock' => 1]);
            } else {
                $this->userRepository->update($id, ['lock' => 0]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

}
