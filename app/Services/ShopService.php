<?php

namespace App\Services;

use App\Repositories\Address\AddressShopRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Shop\ShopRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class ShopService
{
    public function __construct(ShopRepositoryInterface $shopRepository, ProductRepositoryInterface $productRepository, AddressShopRepositoryInterface $addressShopRepository)
    {
        $this->shopRepository = $shopRepository;
        $this->productRepository = $productRepository;
        $this->addressShopRepository = $addressShopRepository;
    }

    public function getShopByIdProduct($id)
    {
        $product = $this->productRepository->show($id);
        return $this->shopRepository->getShopByProduct($product);
    }

    public function getShops($request)
    {
        $shops = $this->shopRepository->all();
        return $this->paginate($shops, 5, null, []);
    }

    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function updateShop($request, $id)
    {
        DB::beginTransaction();
        try {
            $shop = $this->shopRepository->show($id);
            $data = [
                'name' => $request->name,
                'web_site' => $request->web_site,
                'detail' => $request->detail
            ];

            if ($request->hasFile('img_shop')) {
                $img = $request->file('img_shop');
                $imgResize = Image::make($img)->resize(320, 380);
                Storage::put('public/shops/' . $img->getClientOriginalName(), (string)$imgResize->encode());
                $data = array_merge($data, [
                    'img_shop' => asset('storage/shops/' . $img->getClientOriginalName())
                ]);
            }

            $this->shopRepository->update($id, $data);

            $addressId = $shop->address->id;
            $requestAddr = $request->address;
            $dataAddress = [
                'number' => $requestAddr['number'],
                'street' => $requestAddr['street'],
                'ward' => $requestAddr['ward'],
                'city' => $requestAddr['city'],
                'province' => $requestAddr['province']
            ];
            $this->addressShopRepository->update($addressId, $dataAddress);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
