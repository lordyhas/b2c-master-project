<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/manager', function () {
            return view('product');
        })->name('manager');
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');
});

Route::get('/error/{code}', function (string $code) {
    abort($code);
})->name('error');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




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



Route::prefix('/api')->name('api.')->group(function () {
    Route::get('/users/{id}', function (int $id) {
        return response()->json([
            "status" => "success",
            "id" => $id,
            "data" => \App\Models\User::findOrFail($id)
        ]);
    });

    Route::get('/users', function () {
        return response()->json([
            "status" => "success",
            "data" => \App\Models\User::all()
        ]);
    });

    Route::get('/products', function () {
        return response()->json([
            "status" => "success",
            "data" => \App\Models\Product::all(),
        ]);
    });

    Route::get('/customers', function () {
        return response()->json([
            "status" => "success",
            "data" => App\Models\Customer::all()
        ]);
    });

});

function replaceEmpty(string $str) : string
{
    return empty($str) ? "" : $str." ";
}



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
        $customer->email = ($data[$i]["first_name"]).($data[$i]["name"]).($data[$i]["last_name"])."@hbusiness.com";
        $customer->phoneNumber = $data[$i]["mob_number1"];
        $customer->locationId = 1;
        //$customer->save();

    }

    return response()->json([
        "failed" => $failed,
        "data" => App\Models\Customer::all()
    ]);

});





Route::get('/products/data/save', function () {
    //data_doctor
    ///doctor-sample-data1
    $csv = Reader::createFromPath(storage_path('app/sales.csv'));
    $csv->setHeaderOffset(0);
    $records = $csv->getRecords();

    $data = array();
    foreach ($records as $record) {
        $data[] = $record;
    }

    $failed = 0;
    for($i = 0; $i < count($data); $i++){
        $product = new \App\Models\Product() ;
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

        $product->save();
        $failed ++;

    }

    return response()->json([
        "added" => $failed,
        "status" => "success",
        "data" => $data
    ]);

});


$data_prod = [
    [
        "name" => "Stylo",
        "employeeId" => "",
        "model" => "Stylo bic",
        "purchasePrice" => "",
        "salePrice" => "",
        "stock" => "",
        "threshold" => "",
        "address" => "",
        "productType" => "",
        "description" => "",
        "canReserve" => "",
        "images" => "",
        "promotionalOutdated" => "",
        "promotionalPrice" => "",

    ],
    [
        "name" => "",
        "employeeId" => "",
        "model" => "",
        "purchasePrice" => "",
        "salePrice" => "",
        "stock" => "",
        "threshold" => "",
        "address" => "",
        "productType" => "",
        "description" => "",
        "canReserve" => "",
        "images" => "",
        "promotionalOutdated" => "",
        "promotionalPrice" => "",

    ],

];

