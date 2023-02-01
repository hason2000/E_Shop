<?php

namespace App\Services;

use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductSize\ProductSizeRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(CartRepositoryInterface $cartRepository, UserRepositoryInterface $userRepository, ProductRepository $productRepository, SizeRepositoryInterface $sizeRepository, ProductSizeRepositoryInterface $productSizeRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->sizeRepository = $sizeRepository;
        $this->productSizeRepository = $productSizeRepository;
    }

    public function getCartByUser($userId)
    {
        $user = $this->userRepository->show($userId);
        is_null($user->cart) ? $result = null : $result = $user->cart;
        return $result;
    }

    public function createCart($data)
    {
        DB::beginTransaction();
        try {
            $dataNewCart = [
                'user_id' => auth()->id()
            ];
            $cart = $this->cartRepository->store($dataNewCart);
            $sizeId = $this->sizeRepository->getSizeByName($data['size'])->id;
            $productId = $data['product_id'];
            $productSize = $this->productSizeRepository->getByProductAndSize($productId, $sizeId);
            $cart->productSizes()->attach($productSize->id, [
                'amount' => $data['amount']
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function updateCart($cart, $data)
    {
        $productId = $data['product_id'];
        $sizeId = $this->sizeRepository->getSizeByName($data['size'])->id;
        $amount = $data['amount'];
        DB::beginTransaction();
        try {
            $productSize = $this->productSizeRepository->getByProductAndSize($productId, $sizeId);
            $amoutOldProductSizeCart = $this->productSizeRepository->getAmoutOfProductSizeInCart($productSize->id, $cart->id);
            $dataUpdate = [
                'amount' => $amoutOldProductSizeCart + $amount
            ];
            $cart->productSizes()->sync([$productSize->id => $dataUpdate], false);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function addProductsToCart($cart, $productId, $data)
    {
        DB::beginTransaction();
        try {
            $cart->products()->attach($productId, $data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function checkProductUnorderInCart($productId, $sizeId, $cartId)
    {
        $cart = $this->cartRepository->show($cartId);
        return $cart->productSizes()->count() > 0;
    }

    public function getItemsOfCart($cart_id)
    {
        $cart = $this->cartRepository->show($cart_id);
        $productsSizeCart = $cart->productSizes;
        $items = array();
        foreach ($productsSizeCart as $productSizeCart) {
            $product = $this->productRepository->show($productSizeCart['product_id']);
            $size = $this->sizeRepository->show($productSizeCart['size_id']);
            $maxAmountProductSize = $this->productSizeRepository->show($productSizeCart->id)->amount;
            $items[$productSizeCart->id] = [
                'product_id' => $product->id,
                'product_img' => $product->img_link,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'size_id' => $size->id,
                'size_name' => $size->name,
                'amount' => $productSizeCart->pivot->amount,
                'max_amount' => $maxAmountProductSize
            ];
        }

        return $items;
    }

    public function plusProductCart($cartId, $productSizeId, $amount)
    {
        DB::beginTransaction();
        try {
            $maxAmount = $this->productSizeRepository->show($productSizeId)->amount;
            if ($maxAmount == $amount || $maxAmount < $amount) {
                throw new Exception("can't add products anymore");
            }
            $dataUpdate = [
                'amount' => $amount + 1
            ];
            $cart = $this->cartRepository->show($cartId);
            $cart->productSizes()->sync([$productSizeId => $dataUpdate], false);
            DB::commit();
            return $dataUpdate;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function minusProductCart($cartId, $productSizeId, $amount)
    {
        DB::beginTransaction();
        try {
            if ($amount <= 1) {
                throw new Exception("can't minus products");
            }
            $dataUpdate = [
                'amount' => $amount - 1
            ];
            $cart = $this->cartRepository->show($cartId);
            $cart->productSizes()->sync([$productSizeId => $dataUpdate], false);
            DB::commit();
            return $dataUpdate;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function changeQuantityProductCart($cartId, $productSizeId, $amount)
    {
        DB::beginTransaction();
        try {
            $maxAmount = $this->productSizeRepository->show($productSizeId)->amount;
            if ($amount < 1 || $amount > $maxAmount) {

                throw new Exception("can't change Quantity products");
            }
            $dataUpdate = [
                'amount' => $amount,
            ];
            $cart = $this->cartRepository->show($cartId);
            $cart->productSizes()->sync([$productSizeId => $dataUpdate], false);
            DB::commit();
            return $dataUpdate;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function delteproductInCart($cartId, $productSizeId)
    {
        $cart = $this->cartRepository->show($cartId);
        $cart->productSizes()->detach($productSizeId);
    }
}
