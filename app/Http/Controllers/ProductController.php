<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Rep;
use App\Status;
use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return Rep::toJson(
            data : Product::all(),
            status : Status::Success,
            message : null,
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreProductRequest $request): JsonResponse
    {
        if ($request->has('id') && $request->has('data') ){
            $id = $request->get('id');
            //$email = $request->get('email');
            //$password = $request->get('password');

            $data = array();
            $data = $request->get('data');

            $item = 0;
            for($i = 0; $i < count($data); $i++){
                $product = new Product();
                $product->name = $data[$i]["product"] ;
                $product->model = $data[$i]["model"];
                $product->salePrice = (double) $data[$i]["price"];
                $product->purchasePrice = (double)  $data[$i]["price"] + ((double) $data[$i]["price"] * 0.2);
                //$product->promotionalPrice;
                //$product->promotionalOutdated;
                $product->stock = (int) $data[$i]["stock"];
                $product->threshold = (int) $data[$i]["threshold"];
                //$product->address;
                $product->productType = $data[$i]["type"] ;
                //$product->description;
                $product->employeeId = 1;
                //$product->canReserve;
                //$product->images;
                //$product->isTendency;

                //$product->save();
                $item ++;
            }
            return Rep::toJson(
                data : [],
                status : Status::Success,
                message : "Products saved",
                info : [
                    "added item" => $item,
                ],
            );
        }

        return Rep::denied();


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request): JsonResponse
    {
        return Rep::unimplemented();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Product $product): JsonResponse
    {
        return Rep::unimplemented();
    }
}
