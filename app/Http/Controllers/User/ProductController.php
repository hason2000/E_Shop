<?php

namespace App\Http\Controllers\User;

use App\Events\UserOnline;
use App\Services\AddressShopService;
use App\Services\BrandService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\ImgService;
use App\Services\ProductService;
use App\Services\ProductSizeService;
use App\Services\ShopService;
use App\Services\SizeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(CategoryService $categoryService, ProductService $productService, BrandService $brandService, ImgService $imgService, SizeService $sizeService, ShopService $shopService, AddressShopService $addressShopService, UserService $userService, CartService $cartService, ProductSizeService $productSizeService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->imgService = $imgService;
        $this->sizeService = $sizeService;
        $this->shopService = $shopService;
        $this->addressShopService = $addressShopService;
        $this->userService = $userService;
        $this->cartService = $cartService;
        $this->productSizeService = $productSizeService;
    }

    public function index(Request $request)
    {
//        $tests = $this->productService->test();
//        foreach ($tests as $test) {
//            dump($test->price . "------" . $test->name);
//        }
//        die();
//        dd($request->input('key_word', 'okela'));
        $categories = $this->categoryService->categoryRepository->all();
        $brandsOfCategory = $this->brandService->getBrandsOfCategory($categories); // lay hang dua vao nhan
        $brands = $this->brandService->getBrandHome();
        $products = $this->productService->getProducts($request);
        $request = $request->all();
        auth()->guard('web')->check() ? $amountProductCart = $this->productSizeService->getAmountProductOfCart(auth()->id()) : $amountProductCart = null;
        $cartId = auth()->guard('web')->check() && !is_null($this->cartService->getCartByUser(auth()->guard('web')->id())) ? $this->cartService->getCartByUser(auth()->guard('web')->id()) : 0;
        return view('user.products.index', compact('categories', 'brandsOfCategory', 'brands', 'products', 'request', 'amountProductCart', 'cartId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        if (auth('web')->check()) {
//            broadcast(new UserOnline([
//                'userId' => auth('web')->id(),
//                'userName' => auth('web')->user()->name
//            ]));
//        }
        $categories = $this->categoryService->categoryRepository->all();
        $brandsOfCategory = $this->brandService->getBrandsOfCategory($categories); // lay hang dua vao nhan
        $brands = $this->brandService->getBrandHome();
        auth()->guard('web')->check() ? $amountProductCart = $this->productSizeService->getAmountProductOfCart(auth()->id()) : $amountProductCart = null;
        $product = $this->productService->productRepository->show($id);
        $imgsProduct = $this->imgService->getImgsByIdProduct($id);
        $brand = $this->brandService->getBrandByIdProduct($id);
        $rating = $this->productService->getRatingProduct($id);
        $sizesProduct = $this->sizeService->getSizesProduct($id);
        $shop = $this->shopService->getShopByIdProduct($id);
        $userIdOfShop = $this->userService->getuserOfShop($shop)->id;
        $usersReview = $this->userService->getUsersReviewByIdProduct($id);
        $reviews = $this->userService->getReviewsProduct($id);
        $address = $this->addressShopService->addressShopRepository->getAddressByShop($shop);
        $cartId = auth()->guard('web')->check() && !is_null($this->cartService->getCartByUser(auth()->guard('web')->id())) ? $this->cartService->getCartByUser(auth()->guard('web')->id()) : 0;
        return view('user.products.show', compact('categories', 'brandsOfCategory', 'brands', 'product', 'imgsProduct', 'brand', 'rating', 'sizesProduct', 'shop', 'address', 'usersReview', 'reviews', 'amountProductCart', 'cartId', 'userIdOfShop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
