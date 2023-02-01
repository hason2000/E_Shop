<?php

namespace App\Repositories\Product;

use App\Models\Img;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use App\Repositories\AbstractRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Image;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProduct(Request $request)
    {
        return Product::filter($request->all());
    }

    public function getProductsByCart($cart)
    {
        return $cart->products;
    }

    public function getProductWithCount()
    {
        return Product::withSum('sizes', 'product_size.amount')->orderByDesc('id')->limit(500)->get();
    }

    public function checkProductInstock($product, $size, $amount)
    {
        $productSize = ProductSize::where('product_id', $product->id)->where('size_id', $size->id)->where('amount', '>=', $amount)->get();
        return count($productSize) > 0;
    }

    public function getAllProductsInStock()
    {
        $product_id = ProductSize::groupBy('product_id')->selectRaw('product_id, sum(amount) as sum')->get();
        $product_id = $product_id->where('sum', '>', '0')->pluck('product_id')->toArray();
        return Product::with('brand')->with('shop')->whereIn('id', $product_id);
    }

    public function getAllProductsOutStock()
    {
        $product_id = DB::table('product_size')->groupBy('product_id')->selectRaw('product_id, sum(amount) as sum')->get();
        $product_id = $product_id->where('sum', '>', '0')->pluck('product_id')->toArray();
        return Product::with('brand')->with('shop')->whereNotIn('id', $product_id);
    }

    public function test()
    {
        $test = [];
//        dd(Product::find(1));
//        return Product::with('images')->addSelect([Img::select('link')->whereColumn('product_id', 'products.id')->limit(1)])->orderBy('price', 'ASC')->orderBy('name', 'ASC')->get()->toArray();
//        $p = Product::query();
//        $imgId = 1001;
//        dd($p->addSelect(['test' => Img::select('link')->whereColumn('product_id', 'products.id')->limit(1)])->limit(10)->get()->toArray());
//        $test = $p->when($imgId, function ($query, $imgId)
//        {
//            return $query->whereHas('images', function ($subquery) use ($imgId) {
//                $subquery->where('id', $imgId);
//            });
//        })->get();
//        $test = $p->with('images')->whereHas('images', function ($query) {
//            $query->where('id', 1001);
//        })->get();
//        $test = $p->find(1007)->toArray();
//        dd($test);
//        dd(Product::withCount('images')->limit(10)->get());
//        return Product::find(1007)->images;
//        return Product::find(1);
//        $this->show(490);

//        $test = User::whereHas('carts', function ($query) {
//            $query->with('cartsProduct')->whereHas('cartsProduct', function ($subquery) {
//                $subquery->where('size_id', 1);
//            });
//        })->get();
        $test = User::join('carts', 'users.id', '=', 'carts.user_id')->join('cart_product', 'cart_product.cart_id', 'carts.id')->select('users.*', DB::raw('sum(amount) as sum'))->groupBy('users.id')->orderByDesc('sum')->orderByDesc('name')->get();
//        $test = User::
        dd($test);
    }
}
