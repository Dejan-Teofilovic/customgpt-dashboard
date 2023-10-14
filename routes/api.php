<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;

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

Route::get('/analytics/queries', [AnalyticsController::class, 'queries']);
Route::get('/analytics/conversations', [AnalyticsController::class, 'conversations']);
Route::get('/analytics/daily-breakdown', [AnalyticsController::class, 'dailybreakdown']);
Route::get('/analytics/user-location', [AnalyticsController::class, 'userlocation']);
Route::get('/analytics/total-queries', [AnalyticsController::class, 'totalqueries']);
Route::get('/analytics/metadata', [AnalyticsController::class, 'metadata']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

