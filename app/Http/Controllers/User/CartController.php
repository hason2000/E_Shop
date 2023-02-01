<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\ProductService;
use App\Services\ProductSizeService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(CartService $cartService, ProductService $productService, ProductSizeService $productSizeService)
    {
        $this->middleware('auth');
        $this->cartService = $cartService;
        $this->productService = $productService;
        $this->productSizeService = $productSizeService;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function show($id)
    {
        $items = $this->cartService->getItemsOfCart($id);
        $cartId = $id;
        return view('user.cart.show', compact('items', 'cartId'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
        return $request->all();
    }

    public function destroy($id)
    {
        //
    }

    public function addToCart(CartRequest $request)
    {

        if (!$this->productService->checkProductInstock($request['product_id'], $request['size'], $request['amount'])) {
            Alert::error('Error Add', 'add invalid product');
            return redirect()->back();
        }

        $cart = $this->cartService->getCartByUser(auth()->guard('web')->id());
        if ($cart instanceof Cart) {
//            co card r
            $result = $this->cartService->updateCart($cart, $request->all());
        }else {
//            Chua co cart
            $result = $this->cartService->createCart($request->all());
        }

        $result instanceof \Exception ? Alert::error('Error', $result->getMessage()) : Alert::success('Success', 'Add successfully');
        return redirect()->back();
    }

    public function store(Request $request)
    {
    }

    public function plusProductCart(Request $request, $cartId, $productSizeId)
    {
        $result = $this->cartService->plusProductCart($cartId, $productSizeId, $request->amount);
        if ($result instanceof \Exception) {
            $oldAmount = $this->productSizeService->productSizeRepository->getAmoutOfProductSizeInCart($productSizeId, $cartId);
            return response([
                'message' => $result->getMessage(),
                'oldAmount' => $oldAmount
            ], 403);
        }
        return $result;
    }

    public function minusProductCart(Request $request, $cartId, $productSizeId)
    {
        $result = $this->cartService->minusProductCart($cartId, $productSizeId, $request->amount);
        if ($result instanceof \Exception) {
            $oldAmount = $this->productSizeService->productSizeRepository->getAmoutOfProductSizeInCart($productSizeId, $cartId);
            return response([
                'message' => $result->getMessage(),
                'oldAmount' => $oldAmount
            ], 403);
        }
        return $result;
    }

    public function changeQuantity(Request $request, $cartId, $productSizeId)
    {
        $result = $this->cartService->changeQuantityProductCart($cartId, $productSizeId, $request->amount);
        if ($result instanceof \Exception) {
            $oldAmount = $this->productSizeService->productSizeRepository->getAmoutOfProductSizeInCart($productSizeId, $cartId);
            return response([
                'message' => $result->getMessage(),
                'oldAmount' => $oldAmount
            ], 403);
        }
        return $result;
    }

    public function deleteProductInCart($cartId, $productSizeId)
    {
        $this->cartService->delteproductInCart($cartId, $productSizeId);
    }
}
