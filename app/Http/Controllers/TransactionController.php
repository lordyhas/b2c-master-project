<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        //
        return response()->json([
            'status' => true,
            'message' => "Connection work successfully!",
            'data' => Transaction::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        //

        if(!$request->has('data') && $request->has('auth')) return response()->json([
            "success" => false,
            "message"=> "failed : no data received",
        ]);
        $data = $request->input('data');

        //$this->add_doctor($data);

        return response()->json([
            "success" => true,
            "message"=> "Doctor saved successfully",
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): \Illuminate\Http\JsonResponse
    {
        //

        return response()->json([
            'status' => true,
            'message' => "Connection work successfully!",
            'data' => [],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
