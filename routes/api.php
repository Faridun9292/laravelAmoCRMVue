<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    LeadsController,
    ContactController,
    HistoryController
};

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

Route::get('/leads',LeadsController::class);
Route::post('/contacts',ContactController::class);
Route::get('/history', HistoryController::class);
