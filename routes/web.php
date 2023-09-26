<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use League\Csv\Reader;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Redirect::route('login');
});

Route::get('update/user/{id}/{level}', function (string $id, string $level){
    $failed = true;
    if($id != null && $level != null ){
        $user = User::find($id);
        $user->access = $level;
        $user->save();

        $failed =  false;
    }
    return Redirect::route('dashboard', ['user' => $id, 'updated' => !$failed]);
})->where([
    'id' => '[0-9]+',
    'level' => '[0-9]+',
])->name('update.user.level');

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');

Route::get('/customers', function () {
    return view('customer');
})->middleware(['auth', 'verified'])->name('customer');

Route::get('/transactions', function () {
    return view('transaction');
})->middleware(['auth', 'verified'])->name('transaction');

//Route::get('/products/manager', function () {return view('product');})->name();
Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/manager', function () {
            return view('product');
        })->name('manager');
})->middleware(['auth', 'verified']);

Route::get('/error/{code}', function (string $code) {
    abort($code);
})->middleware(['auth', 'verified'])->name('error');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//-----------------------------------------------------------

Route::prefix('/x/blog')->name('blog.')
    ->group(function () {

        Route::get('/', function (Request $request) {
            return [
                "id" => $request->input("id", "0"),
                "title" => "Nom titre",
                "contents" => "Bonjour contents",
            ];
        })->name("index");

        Route::get('/{title}-{id}', function (string $title, string $id) {
            return [
                "id" => $id,
                "title" => $title,
                "contents" => "Bonjour contents",
            ];
        })->where([
            'id' => '[0-9]+',
            'title' => '[a-z0-9\-]+',
        ])->name("compose ");

    });





Route::prefix('/xapi')->name('api.')->group(function () {
    Route::get('/users/{id}', function (int $id) {
        return response()->json([
            "status" => "success",
            "id" => $id,
            "data" => User::findOrFail($id)
        ]);
    });

    Route::get('/users', function (Request $request) {
        if($request->has('id')){
            $id = $request->get('id');
            return response()->json([
                "status" => "success",
                "data" => DB::table('users')->where('id', '=', $id)->get()
            ]);
        }
        return response()->json([
            "status" => "success",
            "data" => User::all()
        ]);
    });

    Route::get('/produits/{name}-{no}',
        function (string $name, string $no, Request $request) {
            return [
                "id" => $request->input("id", "0"),
                "product_name" => $name,
                "pno" => $no,
                "contents" => "Bonjour contents",
            ];
        })->where([
        'no' => '[0-9]+',
        'name' => '[a-z0-9\-]+',
    ])->name("ventes");



    Route::get('/customers', function () {
        return response()->json([
            "status" => "success",
            "data" => App\Models\Customer::all()
        ]);
    });

    Route::get('/transac/csv/{nopro}-{nocli}-{q}', function (int $nopro, int $nocli, int $q) {

        $failed = 0;

        $product = \App\Models\Product::find($nopro);
        $transaction = new \App\Models\Transaction();
        $transaction->customerId = $nocli;
        $transaction->productId = $nopro;
        $transaction->quantity = $q;
        $transaction->amount = $q * $product->salePrice;
        $transaction->purchaseDate = date('Y-m-d H:i:s', time());

        $transaction->save();

        //$transactions[] = $transaction;


        //DB::table('customers')->where('id', '=', $nocli)->get(),
        return response()->json([
            "failed" => $failed,
            "client" => \App\Models\Customer::find($nocli),
            "product" => $product,
            "data" => \App\Models\Transaction::all(),
        ]);

    })->where([
        'nopro' => '[0-9]+',
        'nocli' => '[0-9]+',
        'q' => '[0-9]+',

    ]);

    Route::get('/doctor/csv/save-', function () {
        //data_doctor
        ///doctor-sample-data1
        $csv = Reader::createFromPath(storage_path('app/data_doctor.csv'));
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $data = array();
        foreach ($records as $record) {
            $data[] = $record;
        }
        $failed = 0;
        for($i = 11; $i < 20; $i++){
            $customer = new \App\Models\Customer() ;
            $customer->name = replaceEmpty($data[$i]["first_name"]).replaceEmpty($data[$i]["name"]).replaceEmpty($data[$i]["last_name"]);
            //$customer->email = ($data[$i]["first_name"]).($data[$i]["name"]).($data[$i]["last_name"])."@hbusiness.com";
            $customer->phoneNumber = $data[$i]["mob_number1"];
            $customer->locationId = 1;
            //$customer->save();

        }

        return response()->json([
            "failed" => $failed,
            "data" => App\Models\Customer::all()
        ]);

    });


});

function replaceEmpty(string $str) : string
{
    return empty($str) ? "" : $str." ";
}




