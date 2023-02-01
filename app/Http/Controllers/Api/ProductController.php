<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\User\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();
        return response()->json([
            'data' => $products,
            'message' => "",
            'status' => '1'
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test(Request $request, $mall_id) {
//        $products = $this->productService->getAll();
//        $products = Product::with(['tags'])->get();
        dd($this->productService->productRepository->test());
        $product = Product::with('tags')->findOrFail($mall_id);
//        dd($product);
//        dd($products);
//        dd($this->productService->productRepository->show($mall_id)->tags);
//        dd($mall_id);
//        return response()->json([
//            'mall_id' => $mall_id,
//            'data' => ['post' => $products->toArray()],
//            'message' => 'Thành công'
//        ], Response::HTTP_OK);

//        return new ProductResource($this->productService->productRepository->show($mall_id));
        ProductResource::withoutWrapping();
//        return ProductResource::collection($products);
        return new ProductResource($product);
    }
}
