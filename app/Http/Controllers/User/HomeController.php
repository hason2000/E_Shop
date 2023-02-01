<?php

namespace App\Http\Controllers\User;

use App\Services\BrandService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\ProductSizeService;

class HomeController extends Controller
{
    // private $categoryRepository;
    // private $productRepository;

    public function __construct(CategoryService $categoryService, ProductService $productService, BrandService $brandService, CartService $cartService, ProductSizeService $productSizeService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->cartService = $cartService;
        $this->productSizeService = $productSizeService;
    }

    public function index()
    {
        $categories = $this->categoryService->categoryRepository->all();
        $brandsOfCategory = $this->brandService->getBrandsOfCategory($categories); // lay hang dua vao nhan
        $productsOfCategory = $this->productService->getProductsOfCategories($categories);
        $productsFeature = $this->productService->getProductOfEachCategories(); // sp theo tinh nang
        $brands = $this->brandService->getBrandHome();
        $productsRecommend = $this->productService->getRecommendProducts();
        $cartId = auth()->guard('web')->check() && !is_null($this->cartService->getCartByUser(auth()->guard('web')->id())) ? $this->cartService->getCartByUser(auth()->guard('web')->id()) : 0;
        auth()->guard('web')->check() ? $amountProductCart = $this->productSizeService->getAmountProductOfCart(auth()->id()) : $amountProductCart = null;
        return view('index', compact('categories', 'productsFeature', 'brands', 'brandsOfCategory', 'productsOfCategory', 'productsRecommend', 'amountProductCart', 'cartId'));
    }
}