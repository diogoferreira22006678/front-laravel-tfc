<?php

use App\Api\CoreApi;
use Illuminate\Http\Request;
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

Route::post('/admin/table/containers', 'TableController_api@containers');
Route::post('/admin/table/arduinos', 'TableController_api@arduinos');
Route::post('/admin/table/sensors', 'TableController_api@sensors');

Route::post('/sendTest', function () {
    $coreApi = new CoreApi();
    $response = $coreApi->sendTest();

    // json response
    return response()->json($response);
});