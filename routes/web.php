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


Route::get('/doctor/csv', function () {
    //data_doctor
    ///doctor-sample-data1
    $csv = Reader::createFromPath(storage_path('app/data_doctor.csv'));
    $csv->setHeaderOffset(0);
    $records = $csv->getRecords();
    $data = array();
    foreach ($records as $record) {
        $data[] = $record;
    }
    return response()->json(["data" => $data]);

});

function replaceEmpty(String $str) : String
{
    return empty($str) ? " " : $str." ";
}

Route::get('/doctor/csv/save', function () {
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
    for($i = 0; $i < 20; $i++){
        if(!empty($data[$i]["email1"]) && !empty($data[$i]["mob_number1"])){
            $customer = new \App\Models\Customer() ;
            $customer->name = replaceEmpty($data[$i]["first_name"]).replaceEmpty($data[$i]["name"]).replaceEmpty($data[$i]["last_name"]);
            $customer->email = $data[$i]["email1"];
            $customer->phoneNumber = $data[$i]["mob_number1"];
            //$customer->address = "";
            $customer->locationId = 1;
        }else{
            $failed++;
        }
    }

    return response()->json([
        "failed" => $failed,
        "data" => App\Models\Customer::all()
    ]);

});


