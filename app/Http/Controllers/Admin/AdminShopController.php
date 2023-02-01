<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\UpdateShopRequest;
use App\Services\AddressShopService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AdminShopController extends Controller
{
    public function __construct(ShopService $shopService, AddressShopService $addressShopService)
    {
        $this->middleware('role:admin');
        $this->shopService = $shopService;
        $this->addressShopService = $addressShopService;
    }

    public function index(Request $request)
    {
        if ($request->ajax() || 'NULL') {
            $shops = $this->shopService->getShops($request);
            return view('admin.shops.index', compact('shops'));
        }
    }

    public function edit($id)
    {
        if (Gate::denies('edit_shop')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }
        $shop = $this->shopService->shopRepository->show($id);
        $address = $this->addressShopService->getAddressByShop($shop);
        return view('admin.shops.edit', compact('shop', 'address'));
    }

    public function update(UpdateShopRequest $request, $id)
    {
        if (Gate::denies('edit_shop')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }
        $result = $this->shopService->updateShop($request, $id);

        if (!$result) {
            Alert::error('Error Update', 'update shop fail');
            return redirect()->back();
        }

        Alert::success('Success Update', 'update shop successfully');
        return redirect()->route('admin.shops.index');
    }
}
