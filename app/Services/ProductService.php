<?php

namespace App\Services;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Img\ImgRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class ProductService
{
    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, BrandRepositoryInterface $brandRepository, CartRepositoryInterface $cartRepository, SizeRepositoryInterface $sizeRepository, ImgRepositoryInterface $imgRepository, UserRepositoryInterface $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->cartRepository = $cartRepository;
        $this->sizeRepository = $sizeRepository;
        $this->imgRepository = $imgRepository;
        $this->userRepository = $userRepository;
    }

    public function getProductOfEachCategories()
    {
        $categories = $this->categoryRepository->all();
        $products = array();
        foreach ($categories as $category) {
            if ($category->products->count() == 0) {
                continue;
            } else {
                foreach ($category->products as $product) {
                    if ($this->isProductInstock($product->id)) {
                        $products[] = $product;
                        break;
                    }
                }
            }
        }
        $products = $this->paginate($products, 6);
        return $products->withQueryString();
    }

    public function isProductInstock($id) // kiem tra xem san pham con trong kho khong
    {
        $product = $this->productRepository->show($id);
        $total = 0;
        foreach ($product->sizes as $size) {
            $total += $size->pivot->amount;
        }
        return $total > 0 ? true : false;
    }

    public function paginate($items, $perPage = 6, $page = null, $options = [])
    {
        // dd($page ?: (Paginator::resolveCurrentPage() ?: 1));
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage;
        $itemstoshow = array_slice($items, $offset, $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage, null, $options);
    }

    public function getProductsOfCategories(Collection $collection)
    {
        $products = array();
        foreach ($collection as $item) {
            $keyName = $item->name;
            $collectionProduct = collect();
            $count = 0;
            foreach ($item->products as $product) {
                if ($this->isProductInstock($product->id)) {
                    $collectionProduct->push($product);
                    $count++;
                }
                if ($count == 4) break;
            }
            if ($collectionProduct->count() > 0) {
//                dump("key duuoc them la :" . $key);
                $products[$keyName] = $collectionProduct;
            }
        }
        return $products;
    }

    public function getRecommendProducts()
    {
        if (!auth()->check() || (auth()->check() && is_null(auth()->user()->carts))) {
            $carts = $this->cartRepository->getCarts();
        } else {
            $carts = auth()->user()->carts;
        }
        $array = array();
        $productsId = array();
        foreach ($carts as $cart) {
            foreach ($cart->products as $product) {
                if (array_key_exists($product->brand->id, $array)) {
                    $array[$product->brand->id] += 1;
                } else {
                    $array[$product->brand->id] = 1;
                }
                if (in_array($product->id, $productsId)) {
                    continue;
                } else {
                    $productsId[] = $product->id;
                }
            }
        }
        // dd($productsId);
        arsort($array); // sắp xếp theo value(số lần xuất hiện của brand) để đưa ra brand phổi biến nhất
        $idBrandRecommend = key($array);
        if (!is_null($idBrandRecommend)) {
            $brand = $this->brandRepository->show($idBrandRecommend);
            $products = $brand->products;
            // dd($products);
            foreach ($products as $key => $product) {
                if (in_array($product->id, $productsId) || !$this->isProductInstock($product->id)) {
                    unset($products[$key]);
                }
            }
        } else {
            $products = collect();
        }

        if (count($products) >= 6) {
            return $products->take(6);
        }
        // neu so luong sp recommend < 6
        $productInstock = $this->getProductInStock();
        $count = 6 - count($products);
        foreach ($productInstock as $product) {
            if ($count == 0) break;
            if (in_array($product['id'], $productsId) || in_array($product['id'], array_change_key_case($products->toArray()))) continue; // kiem tra san pham da nam trong muc san pham da mua chua, hoac san pham do da nam trong san pham recommend trc do chua, neu r thi khong them vao mang products
            $products[$product['id']] = $product;
            $count -= 1;
        }

        return $products;
    }

    public function getProductInStock()
    {
        $products = $this->productRepository->getProductWithCount()->toArray();
        foreach ($products as $key => $product) {
            if (!$product['sizes_sum_product_sizeamount'] > 0) unset($products[$key]);
        }
        return $products;
    }

    public function getProducts(Request $request)
    {
        return $this->paginate($this->getProductInStock(), 12, null, ['path' => url($request->getRequestUri())])->withQueryString();
    }

    public function getRatingProduct($id)
    {
        $product = $this->productRepository->show($id);
        $rating = 0;
        $users = $product->reviews;
        if ($users->count() == 0) return $rating;
        foreach ($users as $user) {
            $rating += $user->pivot->rating; // lay du lieu tu bang trung gian (Pivot)
        }
        return round($rating / $users->count(), 1);
    }

    public function checkProductInstock($product_id, $size, $amount)
    {
        $product = $this->productRepository->show($product_id);
        $size = $this->sizeRepository->getSizeByName($size);
        return $this->productRepository->checkProductInstock($product, $size, $amount);
    }

    public function getAllProductsInStockAdmin($data)
    {
        $productInstock = $this->productRepository->getAllProductsInStock();
        if (isset($data['key-name'])) {
            $productInstock->where("name", 'LIKE', '%' . $data['key-name'] . '%');
        }
//        dd($productInstock->get());
        return $productInstock->paginate(5);
//        return $productInstock;
    }

    public function getAllProductsOutStockAdmin($data)
    {
        $productOutstock = $this->productRepository->getAllProductsOutStock();
        if (isset($data['key-name'])) {
            $productOutstock->where("name", 'LIKE', '%' . $data['key-name'] . '%');
        }
        return $productOutstock->paginate(5);
    }

    public function updateProduct($productId, $request)
    {
        DB::beginTransaction();
        try {
            // update info of product
            $data = [
                'name' => $request->name,
                'shop_id' => $request->shop_id,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'condition' => $request->condition,
                'price' => $request->price,
                'detail' => isset($request->detail) ? $request->detail : ''
            ];
            if ($request->hasFile('img_link')) {
                $img = $request->file('img_link');
                $imgResize = Image::make($img)->resize(320, 380);
                Storage::put('public/products/' . $img->getClientOriginalName(), (string)$imgResize->encode());
                $data = array_merge($data, [
                    'img_link' => asset('storage/products/' . $img->getClientOriginalName())
                ]);
            }
            $this->productRepository->update($productId, $data);

            // update size of product
            $sizes = $request->size;
            $product = $this->productRepository->show($productId);
            foreach ($sizes as $sizeId => $amount) {
                $product->sizes()->syncWithoutDetaching([$sizeId => ['amount' => $amount]]);
            }

            // dd($product->imgs->toArray());
            // update sub img
            if (isset($request->sub_img)) {
                $subImgs = $request->sub_img;
                foreach ($subImgs as $id => $img) {
                    if (!$this->imgRepository->checkImgExist($id)) {
                        $imgSubResize = Image::make($img)->resize(136, 160);
                        Storage::put('public/subimgs/' . $img->getClientOriginalName(), (string)$imgSubResize->encode());
                        $dataImg = [
                            'product_id' => $product->id,
                            'link' => asset('storage/subimgs/' . $img->getClientOriginalName())
                        ];
                        $imgModel = $this->imgRepository->store($dataImg);
//                            !isset($imgModel) ?? throw new Exception('can update');
                            !isset($imgModel) ?? abort(404);
                    } else if (!in_array($id, $product->imgs->pluck('id')->toArray())) {
                        throw new Exception("This product does not have the right to update photos that are not mine");
                    } else {
                        $imgSubResize = Image::make($img)->resize(136, 160);
                        Storage::put('public/subimgs/' . $img->getClientOriginalName(), (string)$imgSubResize->encode());
                        $dataImg = [
                            'product_id' => $product->id,
                            'link' => asset('storage/subimgs/' . $img->getClientOriginalName())
                        ];
                        $result = $this->imgRepository->update($id, $dataImg);
//                            !$result ?? throw new Exception("Can't update the sub Img");
                            !$result ?? abort(404);
                    }
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function createProduct($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'shop_id' => $request->shop_id,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'condition' => $request->condition,
                'price' => $request->price,
                'detail' => isset($request->detail) ? $request->detail : ''
            ];
            if ($request->hasFile('img_link')) {
                $img = $request->file('img_link');
                $imgResize = Image::make($img)->resize(320, 380);
                Storage::put('public/products/' . $img->getClientOriginalName(), (string)$imgResize->encode());
                $data = array_merge($data, [
                    'img_link' => asset('storage/products/' . $img->getClientOriginalName())
                ]);
            }

            $product = $this->productRepository->store($data);

//                !isset($product) ?? throw new Exception("Can't create product");
                !isset($product) ?? abort(404);

            $sizes = $request->size;
            foreach ($sizes as $sizeId => $amount) {
                $product->sizes()->syncWithoutDetaching([$sizeId => ['amount' => $amount]]);
            }

            if (isset($request->sub_img)) {
                $subImgs = $request->sub_img;
                foreach ($subImgs as $id => $img) {
                    $imgSubResize = Image::make($img)->resize(136, 160);
                    Storage::put('public/subimgs/' . $img->getClientOriginalName(), (string)$imgSubResize->encode());
                    $dataImg = [
                        'product_id' => $product->id,
                        'link' => asset('storage/subimgs/' . $img->getClientOriginalName())
                    ];
                    $imgModel = $this->imgRepository->store($dataImg);
//                        !isset($imgModel) ?? throw new Exception("Can't store the sub Img");
                    !isset($imgModel) ?? abort(404);
                }
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }


    ////////////////////////////////////////////
    public function getAll()
    {
        return $this->productRepository->all();
    }

    public function test()
    {
        return $this->productRepository->test();
    }
}
