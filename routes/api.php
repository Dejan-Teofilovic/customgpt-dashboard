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

Route::get('/analytics/total-query-count', [AnalyticsController::class, 'getTotalQueryCount']);
Route::get('/analytics/avg-response-end-time', [AnalyticsController::class, 'getAvgResponseEndTime']);
Route::get('/analytics/avg-response-start-time', [AnalyticsController::class, 'getAvgResponseStartTime']);
Route::get('/analytics/avg-query-input-word', [AnalyticsController::class, 'getAvgInputWords']);
Route::get('/analytics/avg-query-output-word', [AnalyticsController::class, 'getAvgOutputWords']);

Route::get('/analytics/total-conversation-count', [AnalyticsController::class, 'getTotalConversationCount']);
Route::get('/analytics/avg-query-per-conversation', [AnalyticsController::class, 'getAvgQueryPerConversation']);
Route::get('/analytics/avg-time-per-conversation', [AnalyticsController::class, 'getAvgTimePerConversation']);

Route::get('/analytics/daily-breakdown-query', [AnalyticsController::class, 'getDailyBreakdownQuery']);
Route::get('/analytics/daily-breakdown-response-start-time', [AnalyticsController::class, 'getDailyBreakdownResponseStartTime']);
Route::get('/analytics/daily-breakdown-response-end-time', [AnalyticsController::class, 'getDailyBreakdownResponseEndTime']);
Route::get('/analytics/daily-breakdown-input-word', [AnalyticsController::class, 'getDailyBreakdownInputWord']);
Route::get('/analytics/daily-breakdown-output-word', [AnalyticsController::class, 'getDailyBreakdownOutputWord']);
Route::get('/analytics/daily-breakdown-conversations', [AnalyticsController::class, 'getDailyBreakdownConversations']);
Route::get('/analytics/daily-breakdown-query-per-conversation', [AnalyticsController::class, 'getDailyBreakdownQueryPerConversation']);
Route::get('/analytics/daily-breakdown-conversation-time', [AnalyticsController::class, 'getDailyBreakdownConversationTime']);

Route::get('/analytics/userlocation', [AnalyticsController::class, 'getUserLocation']);

Route::get('/analytics/barchart-users', [AnalyticsController::class, 'getBarchartUsers']);
Route::get('/analytics/barchart-source', [AnalyticsController::class, 'getBarchartSource']);
Route::get('/analytics/barchart-browsers', [AnalyticsController::class, 'getBarchartBrowsers']);
Route::get('/analytics/barchart-query-status', [AnalyticsController::class, 'getBarchartQueryStatus']);

Route::get('/analytics/total-query-hourly', [AnalyticsController::class, 'getQueryByHourly']);
Route::get('/analytics/total-query-daily', [AnalyticsController::class, 'getQueryDaily']);


// Route::get('/analytics/queries', [AnalyticsController::class, 'queries']);
// Route::get('/analytics/queries', [AnalyticsController::class, 'queries']);
// Route::get('/analytics/conversations', [AnalyticsController::class, 'conversations']);
// Route::get('/analytics/daily-breakdown', [AnalyticsController::class, 'dailybreakdown']);
// Route::get('/analytics/user-location', [AnalyticsController::class, 'userlocation']);
// Route::get('/analytics/total-queries', [AnalyticsController::class, 'totalqueries']);
// Route::get('/analytics/metadata', [AnalyticsController::class, 'metadata']);
// Route::get('/analytics/setall', [AnalyticsController::class, 'setall']);
// Route::get('/analytics/all', [AnalyticsController::class, 'getall']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
