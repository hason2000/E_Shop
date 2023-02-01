<?php

namespace App\Services;

use App\Repositories\Address\AddressRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class UserService
{
    public function __construct(UserRepositoryInterface $userRepository, ProductRepositoryInterface $productRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->addressRepository = $addressRepository;
    }

    public function getReviewsProduct($id)
    {
        $reviews = array();
        $users = $this->getUsersReviewByIdProduct($id);
        foreach ($users as $user) {
            $ratingContent ['rating'] = $user->pivot->rating;
            $ratingContent ['content'] = $user->pivot->content;
            $ratingContent ['time'] = $this->formatTime($user->pivot->updated_at);
            $ratingContent ['date'] = $this->formatDate($user->pivot->updated_at);
            $reviews[$user->id] = $ratingContent;
        }
        return $reviews;
    }

    public function getUsersReviewByIdProduct($id)
    {
        $product = $this->productRepository->show($id);
        return $this->userRepository->getUsersReviewByProduct($product);
    }

    public function formatTime($dateTime)
    {
        $dateTime = date_create($dateTime);
        return date_format($dateTime, "h:i A");
    }

    public function formatDate($dateTime)
    {
        $dateTime = date_create($dateTime);
        return date_format($dateTime, "d M Y");
    }

    public function getUsers()
    {
        $users = $this->userRepository->all();
        return $this->paginate($users, 5, null, []);
    }

    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function updateUser($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->show($id);
            $data = [
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address_default' => isset($request->address_default) ? $request->address_default : 0
            ];

            if (isset($request->password)) {
                $data['password'] = bcrypt($request->password);
            }

            if ($request->hasFile('avatar')) {
                $img = $request->file('avatar');
                $imgResize = Image::make($img)->resize(200, 200);
                Storage::put('public/users/' . $img->getClientOriginalName(), (string)$imgResize->encode());
                $data = array_merge($data, [
                    'avatar' => asset('storage/users/' . $img->getClientOriginalName())
                ]);
            }

            $this->userRepository->update($id, $data);
            if (isset($request->address)) {
                $arrayAddr = $request->address;
                foreach ($arrayAddr as $key => $address) {
                    $dataAddr = [
                        'number' => $address['number'],
                        'street' => $address['street'],
                        'ward' => $address['ward'],
                        'city' => $address['city'],
                        'procince' => $address['province']
                    ];
                    $this->addressRepository->update($key, $dataAddr);
                }
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function isLockUserByEmail($email)
    {
        return in_array($email, $this->userRepository->getEmailUserLock());
    }

    public function getUserOfShop($shop)
    {
        return $this->userRepository->getUserByShop($shop);
    }
}
