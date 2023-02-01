<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\User\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ImgService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Services\SizeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AdminProductController extends Controller
{
    public function __construct(ProductService $productService, ShopService $shopService, CategoryService $categoryService, BrandService $brandService, SizeService $sizeService, ImgService $imgService)
    {
        $this->middleware('role:admin');
        $this->productService = $productService;
        $this->shopService = $shopService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->sizeService = $sizeService;
        $this->imgService = $imgService;
    }

    public function instock(Request $request)
    {
        $productsInStock = $this->productService->getAllProductsInStockAdmin($request->all());
        if ($request->ajax()) {
//            return $productsInStock;
            return view('admin.products.product-instock', compact('productsInStock'));
        }
        return view('admin.products.instock', compact('productsInStock'));
    }

    public function outstock(Request $request)
    {
        $productsOutStock = $this->productService->getAllProductsOutStockAdmin($request->all());
        if ($request->ajax()) {
            return view('admin.products.product-outstock', compact('productsOutStock'));
        }
        return view('admin.products.outstock', compact('productsOutStock'));
    }

    public function edit(Request $request, $id)
    {
        if (Gate::denies('edit_product')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }
        $product = $this->productService->productRepository->show($id);
        $shops = $this->shopService->shopRepository->all();
        $categories = $this->categoryService->categoryRepository->all();
        $brands = $this->brandService->brandRepository->all();
        $sizes = $this->sizeService->sizeRepository->all();
        $sizesOfProduct = $this->sizeService->getSizesProduct($id);
        $subImgs = $this->imgService->getImgsByIdProduct($id);
        return view('admin.products.edit', compact('product', 'shops', 'categories', 'brands', 'sizes', 'sizesOfProduct', 'subImgs'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        if (Gate::denies('edit_product')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }
        if (!$this->shopService->shopRepository->checkShopExist($request->shop_id)) {
            Alert::error('Eror Update', 'Shop does not exist');
            return redirect()->back();
        }

        if (!$this->categoryService->categoryRepository->checkCategoryExist($request->category_id)) {
            Alert::error('Eror Update', 'Category does not exist');
            return redirect()->back();
        }

        if (!$this->brandService->brandRepository->checkBrandExist($request->brand_id)) {
            Alert::error('Eror Update', 'Brand does not exist');
            return redirect()->back();
        }

        if (!(isset($request->size) & $this->sizeService->sizeRepository->checkSizesExist($request->size))) {
            Alert::error('Eror Update', 'Size is error');
            return redirect()->back();
        }

        $result = $this->productService->updateProduct($id, $request);

        if ($result instanceof Exception) {
            Alert::error('Error Update', $result->gegetMessage());
            return redirect()->back();
        }

        Alert::success('Success Update', 'Update date Product Success');
        return redirect()->back();
    }

    public function create()
    {
        if (Gate::denies('create_product')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }
        $shops = $this->shopService->shopRepository->all();
        $categories = $this->categoryService->categoryRepository->all();
        $brands = $this->brandService->brandRepository->all();
        $sizes = $this->sizeService->sizeRepository->all();
        return view('admin.products.create', compact('shops', 'categories', 'brands', 'sizes'));
    }

    public function store(CreateProductRequest $request)
    {
        if (Gate::denies('create_product')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }
        if (!$this->shopService->shopRepository->checkShopExist($request->shop_id)) {
            Alert::error('Eror Update', 'Shop does not exist');
            return redirect()->back();
        }

        if (!$this->categoryService->categoryRepository->checkCategoryExist($request->category_id)) {
            Alert::error('Eror Update', 'Category does not exist');
            return redirect()->back();
        }

        if (!$this->brandService->brandRepository->checkBrandExist($request->brand_id)) {
            Alert::error('Eror Update', 'Brand does not exist');
            return redirect()->back();
        }

        if (!(isset($request->size) & $this->sizeService->sizeRepository->checkSizesExist($request->size))) {
            Alert::error('Eror Update', 'Size is error');
            return redirect()->back();
        }

        $model = $this->productService->createProduct($request);

        if ($model) {
            Alert::success('Create Successfully', 'Create product successful');
            return redirect()->route('admin.product.in_stock');
        }

        Alert::error('Create Fail', 'Create product Error');
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (Gate::denies('delete_product')) {
            Alert::error('Error', 'You have no role');
            return redirect()->back();
        }

        $result = $this->productService->productRepository->delete($id);

        if (!$result) {
            Alert::error('Error Delete', 'delete product failed');
        }

        Alert::success('Delete Success', 'delete product successfully');

        return redirect()->back();
    }
}

