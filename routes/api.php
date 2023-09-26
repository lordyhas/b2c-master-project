<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Rep;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/user', function (Request $request) {
    if(!$request->has('id')) return Rep::denied();
    if($request->has('email')&& $request->has('password')){
        $email = $request->input('email');
        $password = $request->input('password');

        $user = DB::table('users')->where('email', '=', $email)->get();
        //return $user[0]->password;
        if(!Hash::check($password, $user[0]->password)) return Rep::failed("email or password incorrect");
        return Rep::toJson(
            data: [$user[0]],
            status: Status::Success,
            message: "User({$user[0]->email}) logged successfully",
        );
    }
    return Rep::failed();
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'show')->name("product.show");
    //Route::get('/products/{id}', 'showOnly')->name("doctor.show_only");

    Route::post('/products', 'create')->name("product.create");
    //Route::post('/doctor_create', 'create')->name("doctor.create");
    Route::put('/products', 'store')->name("product.store");
    Route::delete('/products', 'delete')->name("product.delete");
});

Route::get('/transactions', function (Request $request) {
    if(!$request->has('id')) return Rep::denied();
    return Rep::failed();
});
Route::post('/transactions', function (Request $request) {
    if(!$request->has('id')) return Rep::denied();
    if(!$request->has('data')) return Rep::failed('No data found');
    //isset();
    $data = $request->input('data');
    if(isset($data['product_id']) && isset($data['customer_id']) && isset($data['quantity'])){
        $no_pro = $data->get('product_id');
        $no_cli = $data->get('customer_id');
        $quantity = $data->get('quantity');
        $product = \App\Models\Product::find($no_pro);
        $transaction = new \App\Models\Transaction();
        $transaction->customerId = $no_cli;
        $transaction->productId = $no_pro;
        $transaction->quantity = $quantity;
        $transaction->amount =  $product->salePrice * $quantity;
        $transaction->purchaseDate = date('Y-m-d H:i:s', time());

        //$transaction->save();

        return Rep::toJson(
            data: [$transaction],
            status: Status::Success,
            message: "Transctions write successfully",
        );
    }
    return Rep::failed();

});
Route::post('/connect', function () {
    return Rep::toJson(
        data: [],
        status: Status::Success,
        message: "Message received successfully!",
    );
});


Route::post('/test_post', function (Request $request) {
    $data = array();
    if ($request->has('id')){
        $id = $request->get('id');
        $email = $request->get('email');
        $password = $request->get('password');

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        return Rep::toJson(
            data: $data,
            status: Status::Success,
            message: "Message received successfully!",
        );
    }
    return Rep::denied();
});

Route::get('/test_get', function () {
    return response()->json([
        'status' => true,
        'message' => "Connection work successfully!",
        'data' => [],
    ]);
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name("product.index");
    //Route::get('/products/{id}', 'showOnly')->name("doctor.show_only");

    Route::post('/products', 'create')->name("product.create");
    //Route::post('/doctor_create', 'create')->name("doctor.create");
    Route::put('/products', 'update')->name("product.update");
    //Route::put('/products', 'store')->name("product.store");
    Route::delete('/products', 'delete')->name("product.delete");
});

