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
        $email = $request->get('email');
        $password = $request->get('password');

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
    }
    else $id = "null";
    return Rep::toJson(
        data: $data,
        status: Status::Success,
        message: "Message received successfully!",
    );
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

