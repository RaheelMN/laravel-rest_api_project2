<?php


use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['prefix'=>'v1'],function(){
//     Route::apiResource('skills',SkillController::class);
// });

Route::group(['prefix'=> 'v1','middleware'=>'auth:sanctum'],function(){
    Route::apiResource('/customers',CustomerController::class);
    Route::apiResource('/invoices',InvoiceController::class);
    Route::post('/bulk',[InvoiceController::class,'BulkStore']);
});


// Route::get('/user', function (Request $request) {
//     return $request->user();});