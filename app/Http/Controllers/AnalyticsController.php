<?php

namespace App\Http\Controllers;

use App\Events\testevent;
use App\Events\MyEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\conversation_debug_info;
use App\Models\prompt_histories;
use App\Models\prompts_metadata;
use App\Models\conversations;
use App\Models\dashboard;

use App\Jobs\AnalyticsTotalQueryCountJob;
use App\Jobs\GetAvgInputWordsJob;
use App\Jobs\GetAvgOutputWordsJob;
use App\Jobs\GetAvgQueryPerConversationJob;
use App\Jobs\GetAvgResponseEndTimeJob;
use App\Jobs\GetAvgResponseStartTimeJob;
use App\Jobs\GetAvgTimePerConversationJob;
use App\Jobs\GetBarchartBrowsersJob;
use App\Jobs\GetBarchartQueryStatusJob;
use App\Jobs\GetBarchartSourceJob;
use App\Jobs\GetBarchartUsersJob;
use App\Jobs\GetDailyBreakdownConversationsJob;
use App\Jobs\GetDailyBreakdownConversationTimeJob;
use App\Jobs\GetDailyBreakdownInputWordJob;
use App\Jobs\GetDailyBreakdownOutputWordJob;
use App\Jobs\GetDailyBreakdownQueryJob;
use App\Jobs\GetDailyBreakdownQueryPerConversationJob;
use App\Jobs\GetDailyBreakdownResponseEndTimeJob;
use App\Jobs\GetDailyBreakdownResponseStartTimeJob;
use App\Jobs\GetQueryByHourlyJob;
use App\Jobs\GetQueryDailyJob;
use App\Jobs\GetTotalConversationCountJob;
use App\Jobs\GetTotalQueryCountJob;
use App\Jobs\GetUserLocationJob;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;


class AnalyticsController extends Controller
{
    // Default method to display the index page
    public $glcurrentDate;

    public function __construct()
    {
        $this->glcurrentDate = Carbon::parse("2023-09-15");
    }
    public function index()
    {
        echo 'choego';
    }

    // /**
    //  * Calculate the average word count based on the specified type ('input' or 'output').
    //  * This function retrieves text data from the database and computes the average word count.
    //  *
    //  * @param string $type The type of data to calculate word count for (either 'input' or 'output').
    //  * @return int The calculated average word count as an integer.
    //  */
    // public function calculateAverageWordCount($type)
    // {
    //     if ($type === 'input') {
    //         $column = 'user_query';
    //     } elseif ($type === 'output') {
    //         $column = 'openai_response';
    //     } else {
    //         // Handle invalid type, such as throwing an exception or setting a default
    //         return 0;
    //     }

    //     // Use the query builder to select the specified column
    //     $content = prompt_histories::pluck($column);

    //     // Initialize variables to store total word count and the number of records
    //     $totalWordCount = 0;
    //     $recordCount = $content->count();

    //     // Loop through the values and calculate word count
    //     foreach ($content as $text) {
    //         $wordCount = str_word_count($text);
    //         $totalWordCount += $wordCount;
    //     }

    //     // Calculate the average word count and cast it to an integer
    //     $averageWordCount = $recordCount > 0 ? intval($totalWordCount / $recordCount) : 0;
    //     return $averageWordCount;
    // }
    // /**
    //  * Calculate the average word count based on the specified type ('input' or 'output').
    //  * This function retrieves text data from the database and computes the average word count.
    //  *
    //  * @param string $type The type of data to calculate word count for (either 'input' or 'output').
    //  * @return int The calculated average word count as an integer.
    //  */
    // public function calculateAverageResponseEndTime()
    // {
    //     return prompts_metadata::average('response_time');
    // }

    // /**
    //  * Endpoint for retrieving analytics related to queries.
    //  * This function returns query count, response end time, response start time, input words, and output words.
    //  * It is used for the queries card on the dashboard.
    //  *
    //  * @return \Illuminate\Http\JsonResponse JSON response containing query-related analytics.
    //  */

    // /**
    //  * Calculate and return the time span in minutes between the first and last 'prompt_histories' for a conversation.
    //  *
    //  * @param int $conversationId The ID of the conversation for which to calculate the time span.
    //  * @return int|null The time span in minutes, or null if no records are found.
    //  */
    // public function calculateTimeSpan($conversationId)
    // {
    //     // Get the conversation by ID
    //     $conversation = conversations::orderBy('created_by')->find($conversationId);
    //     // Check if the conversation exists
    //     if (!$conversation) {
    //         return null; // Conversation not found
    //     }

    //     // Get the 'prompt_histories' related to the conversation
    //     $promptHistories = $conversation->promptHistories;

    //     // Check if there are 'prompt_histories' records
    //     if ($promptHistories->isEmpty()) {
    //         return null; // No 'prompt_histories' found
    //     }

    //     // Find the timestamps of the first and last 'prompt_histories'
    //     $firstTimestamp = $promptHistories->first()->created_at;
    //     $lastTimestamp = $promptHistories->last()->created_at;

    //     // Calculate the time span in minutes
    //     $timeSpanInMinutes = $firstTimestamp->diffInMinutes($lastTimestamp);
    //     return $timeSpanInMinutes;
    // }

    // /**
    //  * Calculate and return the average time span in minutes for all conversations.
    //  *
    //  * @return float|null The average time span in minutes, or null if no conversations are found.
    //  */
    // public function calculateAverageTimeSpan()
    // {
    //     // Get all conversations
    //     $conversations = conversations::all();

    //     // Check if there are conversations
    //     if ($conversations->isEmpty()) {
    //         return null; // No conversations found
    //     }

    //     $totalTimeSpanInMinutes = 0;

    //     // Calculate the total time span for all conversations
    //     foreach ($conversations as $conversation) {
    //         $timeSpan = $this->calculateTimeSpan($conversation->id);

    //         // Skip conversations with no 'prompt_histories'
    //         if ($timeSpan !== null) {
    //             $totalTimeSpanInMinutes += $timeSpan;
    //         }
    //     }

    //     // Calculate the average time span
    //     $averageTimeSpan = $totalTimeSpanInMinutes / $conversations->count();

    //     return $averageTimeSpan;
    // }


    // /**
    //  * Generate a report for 'prompt_histories' for the last 7 days.
    //  * Calculate the row count for each day.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function generateQueryReportLast7Days()
    // {
    //     // Get the current date and time
    //     $currentDateTime = $this->glcurrentDate->copy();

    //     // Calculate the date and time 7 days ago
    //     $sevenDaysAgo = $currentDateTime->copy()->subDays(7);

    //     // Perform the query to count rows for each day
    //     $result = prompt_histories::whereBetween('created_at', [$sevenDaysAgo, $currentDateTime])
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
    //         ->get();

    //     // Convert the results to an associative array for JSON response
    //     $report = $result->pluck('count', 'date')->all();

    //     return $report;
    // }

    // /**
    //  * Generate a report for 'prompt_histories' for the last 7 days.
    //  * Calculate the row count for each day.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function generateConversationReportLast7Days()
    // {
    //     // Get the current date and time
    //     $currentDateTime = $this->glcurrentDate->copy();

    //     // Calculate the date and time 7 days ago
    //     $sevenDaysAgo = $currentDateTime->copy()->subDays(7);

    //     // Perform the query to count rows for each day
    //     $result = conversations::whereBetween('created_at', [$sevenDaysAgo, $currentDateTime])
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
    //         ->get();

    //     // Convert the results to an associative array for JSON response
    //     $report = $result->pluck('count', 'date')->all();

    //     return $report;
    // }

    // /**
    //  * Calculate and return the average word count of 'user_query' for each day in the last 7 days.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function calculateAverageInputWordCountLast7Days()
    // {
    //     // Get the current date and time
    //     $currentDateTime = $this->glcurrentDate->copy();

    //     // Calculate the date and time 7 days ago
    //     $sevenDaysAgo = $currentDateTime->copy()->subDays(7);

    //     // Perform the query to calculate average word count for 'user_query' for each day
    //     $result = prompt_histories::whereBetween('created_at', [$sevenDaysAgo, $currentDateTime])
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count'))
    //         ->get();

    //     $report = $result->pluck('average_word_count', 'date')->all();
    //     return $report;
    // }

    // /**
    //  * Calculate and return the average word count of 'user_query' for each day in the last 7 days.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function calculateAverageOutputWordCountLast7Days()
    // {
    //     // Get the current date and time
    //     $currentDateTime = $this->glcurrentDate->copy();

    //     // Calculate the date and time 7 days ago
    //     $sevenDaysAgo = $currentDateTime->copy()->subDays(7);

    //     // Perform the query to calculate average word count for 'user_query' for each day
    //     $result = prompt_histories::whereBetween('created_at', [$sevenDaysAgo, $currentDateTime])
    //         ->groupBy(DB::raw('DATE(created_at)'))
    //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(openai_response) - LENGTH(REPLACE(openai_response, " ", "")) + 1) as average_word_count'))
    //         ->get();

    //     $report = $result->pluck('average_word_count', 'date')->all();
    //     return $report;
    // }

    // /**
    //  * Calculate the average count of recent 'prompt_histories' records per unique 'conversation_id' values.
    //  *
    //  * This function retrieves 'prompt_histories' records created in the past 7 days, counts the number of
    //  * unique 'conversation_id' values, and calculates the average count of records per unique conversation.
    //  *
    //  * @return float The average count of recent 'prompt_histories' records per unique 'conversation_id' values.
    //  */
    // function calculateAverageCountOfRecentPromptHistories()
    // {
    //     // Get the current date and time
    //     $currentDateTime = $this->glcurrentDate->copy();

    //     // Calculate the date and time 7 days ago
    //     $sevenDaysAgo = $currentDateTime->copy()->subDays(7);

    //     $recentPromptHistories = prompt_histories::whereBetween('created_at', [$sevenDaysAgo, $currentDateTime])->get();

    //     // Use the distinct method to retrieve unique conversation_id values
    //     $uniqueConversationIds = $recentPromptHistories->pluck('conversation_id')->unique();
    //     $uniqueConversationCount = $uniqueConversationIds->count();

    //     // Calculate the average count
    //     $averageCount = $recentPromptHistories->count() / $uniqueConversationCount;

    //     return $averageCount;
    // }

    // public function calculateAverageTimeSpanForlast7days()
    // {
    //     // Get the current date and time
    //     $currentDateTime = $this->glcurrentDate->copy();

    //     // Calculate the date and time 7 days ago
    //     $sevenDaysAgo = $currentDateTime->copy()->subDays(7);
    //     $conversations = conversations::whereBetween('created_at', [$sevenDaysAgo, $currentDateTime])->get();;

    //     // Check if there are conversations
    //     if ($conversations->isEmpty()) {
    //         return null; // No conversations found
    //     }

    //     $totalTimeSpanInMinutes = 0;

    //     // Calculate the total time span for all conversations
    //     foreach ($conversations as $conversation) {
    //         $timeSpan = $this->calculateTimeSpan($conversation->id);

    //         // Skip conversations with no 'prompt_histories'
    //         if ($timeSpan !== null) {
    //             $totalTimeSpanInMinutes += $timeSpan;
    //         }
    //     }

    //     // Calculate the average time span
    //     $averageTimeSpan = $totalTimeSpanInMinutes / $conversations->count();

    //     return $averageTimeSpan;
    // }






    // function countRowsInTimeRanges()
    // {
    //     // Define the time ranges
    //     $timeRanges = [
    //         ['start' => 0, 'end' => 6],
    //         ['start' => 6, 'end' => 9],
    //         ['start' => 9, 'end' => 12],
    //         ['start' => 12, 'end' => 15],
    //         ['start' => 15, 'end' => 18],
    //         ['start' => 18, 'end' => 23],
    //         ['start' => 23, 'end' => 24], // Note that this range includes 23:00 to 00:00
    //     ];

    //     // Get the current time
    //     //$currentTime = Carbon::now();
    //     // Set the current time to October 1, 2023
    //     //$currentTime = Carbon::parse('2023-10-01');
    //     $currentTime = $this->glcurrentDate;
    //     // Create an array to store the counts for each time range
    //     $countResults = [];

    //     // Loop through the time ranges and count the rows in each range
    //     foreach ($timeRanges as $range) {
    //         $startTime = $currentTime->copy()->subHours(24)->addHours($range['start']);
    //         $endTime = $currentTime->copy()->addHours($range['end']);

    //         $count = prompt_histories::whereBetween('created_at', [$startTime, $endTime])->count();

    //         $countResults[$range['start'] . '~' . $range['end']] = $count;
    //     }

    //     return $countResults;
    // }

    // function countRowsDaily()
    // {

    //     // Get the current time
    //     //$currentTime = Carbon::now();
    //     // Set the current time to October 1, 2023
    //     // $currentDate = Carbon::parse('2023-10-01');
    //     $currentDate = $this->glcurrentDate;
    //     $startDate = $currentDate->subDay(7);
    //     // Create an array to store the counts for each time range
    //     $countResults = [];
    //     // Loop through the time ranges and count the rows in each range
    //     for ($i = 0; $i < 7; $i++) {
    //         # code...
    //         $startTime = $startDate->copy()->addDay($i);
    //         $endTime = $startDate->copy()->addDay($i + 1);
    //         $count = prompt_histories::whereBetween('created_at', [$startTime, $endTime])->count();
    //         $countResults[$startTime->format('D')] = $count;
    //     }
    //     return $countResults;
    // }

    // public function calculateAverageTimeSpanNew()
    // {
    //     // Use eager loading to fetch conversations with related promptHistories
    //     $conversations = conversations::select('id')
    //         ->with(['prompthistories' => function ($query) {
    //             $query->orderBy('created_at', 'desc');
    //         }])
    //         ->get();
    //     if ($conversations->isEmpty()) {
    //         return null;
    //     }

    //     $totalTimeSpanInMinutes = 0;
    //     $conversationCount = 0;

    //     foreach ($conversations as $conversation) {
    //         // Use the loaded relationship to avoid additional queries
    //         $promptHistories = $conversation->prompthistories;

    //         if ($promptHistories->isEmpty()) {
    //             continue; // Skip conversations with no promptHistories
    //         }

    //         $firstTimestamp = $promptHistories->first()->created_at;
    //         $lastTimestamp = $promptHistories->last()->created_at;
    //         $timeSpan = $firstTimestamp->diffInMinutes($lastTimestamp);

    //         $totalTimeSpanInMinutes += $timeSpan;
    //         $conversationCount++;
    //     }

    //     $averageTimeSpan = $conversationCount > 0 ? $totalTimeSpanInMinutes / $conversationCount : 0;

    //     return $averageTimeSpan;
    // }

    // /**
    //  * The URL is api/analytics/total-queries
    //  * This function returns the statistics of the users, source, browser, query status.
    //  * For the user piechart cards in the dashboard. 
    //  */
    // public function metadata()
    // {
    //     // This is the part of calculating the statistics of user_agent
    //     $start_time  = microtime(true);
    //     $totalCount = prompts_metadata::distinct()->select('user_ip')->count();
    //     $chromeCount = prompts_metadata::where('user_agent', 'like', '%chrome%')
    //         ->distinct('user_ip')
    //         ->count();
    //     $windowsCount = prompts_metadata::where('user_agent', 'like', '%windows%')
    //         ->distinct('user_ip')
    //         ->count();
    //     $safariCount = prompts_metadata::where('user_agent', 'like', '%safari%')
    //         ->distinct('user_ip')
    //         ->count();
    //     $unknownCount = $totalCount - $chromeCount - $windowsCount - $safariCount;
    //     $agentReport = [
    //         'chrome' => (100 * $chromeCount) / $totalCount, 'windows' => (100 * $windowsCount) / $totalCount, 'safari' => (100 * $safariCount) / $totalCount,
    //         'unknown' => (100 * $unknownCount) / $totalCount
    //     ];

    //     // This is the part for calculating the query status
    //     $totalQueryStatus = conversation_debug_info::count();
    //     $successCount = conversation_debug_info::where('status', 'success')->count();
    //     $failCount = $totalQueryStatus - $successCount;
    //     $end_time  = microtime(true);
    //     $elapsed_time = $end_time - $start_time;
    //     $statusReport = ['success' => (100 * $successCount) / $totalQueryStatus, 'fail' => (100 * $failCount) / $totalQueryStatus];
    //     return ['browsers' => $agentReport, 'queryStatus' => $statusReport, 'timeConsumed' => $elapsed_time];
    // }

    // public function totalqueries()
    // {
    //     $start_time  = microtime(true);
    //     $dataInTimeRange = $this->countRowsInTimeRanges();
    //     // $dataInTimeRange = '$this->countRowsInTimeRanges();';
    //     $dataDaily = $this->countRowsDaily();
    //     $end_time  = microtime(true);
    //     // Calculate the elapsed time
    //     $elapsed_time = $end_time - $start_time;
    //     return ['dataInTimeRange' => $dataInTimeRange, 'dataDaily' => $dataDaily, 'timeConsumed' => $elapsed_time];
    // }

    // /**
    //  * The URL is api/analytics/user-location
    //  * This function returns the count of users in USA, ....
    //  * For the user location card in the dashboard. 
    //  */


    // /**
    //  * The URL is api/analytics/daily-breakdown
    //  * This function returns the queries, response end time, reponse start time, input words, output words, conversations,
    //  * queries per conversation, and conversation time.
    //  * For the daily breakdown card in the dashboard. 
    //  */
    // public function dailybreakdown()
    // {
    //     $start_time  = microtime(true);
    //     $queryReport = $this->generateQueryReportLast7Days();
    //     $inputWordCount = $this->calculateAverageInputWordCountLast7Days();
    //     $outputWordCount = $this->calculateAverageOutputWordCountLast7Days();
    //     $conversationsReport = $this->generateConversationReportLast7Days();
    //     $queriesPerConversation = $this->calculateAverageCountOfRecentPromptHistories();
    //     $averageConversationTime = $this->calculateAverageTimeSpanForlast7days();
    //     $end_time  = microtime(true);
    //     // Calculate the elapsed time
    //     $elapsed_time = $end_time - $start_time;
    //     return [
    //         'queryReport' => $queryReport, 'responseStartTimeReport' => '3.2s', 'responseEndTimeReport' => '42s', 'inputWordReport' => $inputWordCount, 'outputWordReport' => $outputWordCount, 'conversationReport' => $conversationsReport,
    //         'queriesPerConversation' => $queriesPerConversation, 'averageConversationTime' => $averageConversationTime,
    //         'timeConsumed' => $elapsed_time
    //     ];
    // }

    // /**
    //  * The URL is api/analytics/conversations
    //  * This function returns the conversations count, queries per conversation, conversatoin time.
    //  * For the conversation card in the dashboard. 
    //  */
    // public function conversations()
    // {
    //     $start_time  = microtime(true);
    //     $conversationCount = conversations::count(); // Use the corrected model name
    //     $queryCount = prompt_histories::count();
    //     $averageCount = $conversationCount > 0 ?  $queryCount / $conversationCount : 0;
    //     $averageTimeSpan = $this->calculateAverageTimeSpanNew();
    //     $end_time  = microtime(true);
    //     // Calculate the elapsed time
    //     $elapsed_time = $end_time - $start_time;
    //     return ['conversationCount' => $conversationCount, 'averageCount' => $averageCount, 'averageTimeSpan' => $averageTimeSpan, 'timeConsumed' => $elapsed_time];
    // }

    // public function queries()
    // {
    //     $start_time  = microtime(true);
    //     // Calculate the elapsed time
    //     $queryCount = prompt_histories::count();
    //     $queryResponseEndTime = $this->calculateAverageResponseEndTime(); // Placeholder value, replace with actual data
    //     $queryResponseStartTime = 3.2; // Placeholder value, replace with actual data
    //     $queryInputWords = $this->calculateAverageWordCount('input');
    //     $end_time  = microtime(true);
    //     $queryOutputWords = $this->calculateAverageWordCount('output');

    //     $elapsed_time = $end_time - $start_time;
    //     return Response()->json([
    //         'querycount' => $queryCount,
    //         'queryResponseEndTime' => $queryResponseEndTime,
    //         'queryResponseStartTime' => $queryResponseStartTime,
    //         'queryInputWords' => $queryInputWords,
    //         'queryOutputWords' => $queryOutputWords,
    //         'elapsedTime' => $elapsed_time
    //     ]);
    // }

    // public function setall()
    // {
    //     $start_time  = microtime(true);
    //     $queries = $this->queries();
    //     $conversations = $this->conversations();
    //     $dailyBreakdown = $this->dailybreakdown();
    //     $userLocation = $this->userlocation();
    //     $metaData = $this->metadata();
    //     $totalQueries = $this->totalqueries();
    //     $end_time  = microtime(true);
    //     // Calculate the elapsed time
    //     $elapsed_time = $end_time - $start_time;
    //     $dashboard = new dashboard;
    //     $dashboard->data = json_encode([
    //         'queries' => $queries,
    //         'conversations' => $conversations,
    //         'dailyBreakdown' => $dailyBreakdown,
    //         'userLocation' => $userLocation,
    //         'metaData' => $metaData,
    //         'totalQueries' => $totalQueries,
    //         'timeConsumed' => $elapsed_time,
    //     ]);

    //     $dashboard->save();

    //     // Return a response as needed
    //     return response()->json(['message' => 'Data saved to dashboard table']);
    // }

    // public function getall()
    // {
    //     $lastRowId = dashboard::max('id'); // Get the maximum 'id' value

    //     if ($lastRowId) {
    //         $lastRow = Dashboard::find($lastRowId); // Find the last row by 'id'
    //         $data = json_decode($lastRow->data, true);
    //         // Check if the JSON decoding was successful
    //         if (json_last_error() === JSON_ERROR_NONE) {
    //             // Now, $data contains the JSON data as a PHP array
    //             return response()->json($data);
    //         } else {
    //             return response()->json(['message' => 'No data found']);
    //         }
    //     }
    // }

    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // // Query section.
    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getTotalQueryCount(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetTotalQueryCountJob($startDateTime, $endDateTime, $showAll));

        return 'Dispatcher has been started!';
    }

    public function getAvgResponseEndTime(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetAvgResponseEndTimeJob($startDateTime, $endDateTime, $showAll));
        // if ($showAll) {
        //     $avgResponseEnd = prompts_metadata::average('response_time');
        // } elseif ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $avgResponseEnd = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])->average('response_time');
        // } else {
        //     return Response()->json(['result' => "Parameter verification failed"]);
        // }

        // return Response()->json(['avgResponseEnd' => $avgResponseEnd]);
        return 'dispatcher has been started!';
    }

    public function getAvgResponseStartTime(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetAvgResponseStartTimeJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // if ($showAll) {
        //     $avgResponseEnd = prompts_metadata::average('response_time');
        //     return Response()->json(['avgResponseEnd' => 1.2]);
        // }
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $avgResponseEnd = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])->avg('response_time');
        //     return Response()->json(['avgResponseEnd' => 1.3]);
        // }
        // return Response()->json(['result' => "Parameter verification failed"]);
    }

    public function getAvgInputWords(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetAvgInputWordsJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // if ($showAll) {
        //     // Use the query builder to select the specified column and calculate the average word count
        //     $averageWordCount = prompt_histories::select(
        //         DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count')
        //     )->first()->average_word_count;

        //     // Handle cases where there are no records
        //     $averageWordCount = $averageWordCount ?: 0;
        //     return Response()->json(['result' => intval($averageWordCount)]);
        // }

        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     // Perform the query to calculate average word count for 'user_query' for each day
        //     $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count'))
        //         ->get();

        //     // Calculate the overall average word count
        //     $totalWordCount = 0;
        //     $recordCount = $result->count();
        //     foreach ($result as $row) {
        //         $totalWordCount += $row->average_word_count;
        //     }
        //     $averageWordCount = $recordCount > 0 ? ($totalWordCount / $recordCount) : 0;
        //     return Response()->json(['result' => $averageWordCount]);
        // }

        // return Response()->json(['result' => "Parameter verification failed"]);
    }

    public function getAvgOutputWords(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetAvgOutputWordsJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // if ($showAll) {
        //     // Use the query builder to select the specified column and calculate the average word count
        //     $averageWordCount = prompt_histories::select(
        //         DB::raw('AVG(LENGTH(openai_response) - LENGTH(REPLACE(openai_response, " ", "")) + 1) as average_word_count')
        //     )->first()->average_word_count;

        //     // Handle cases where there are no records
        //     $averageWordCount = $averageWordCount ?: 0;
        //     return Response()->json(['result' => intval($averageWordCount)]);
        // }

        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     // Perform the query to calculate average word count for 'openai_response' for each day
        //     $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(openai_response) - LENGTH(REPLACE(openai_response, " ", "")) + 1) as average_word_count'))
        //         ->get();

        //     // Calculate the overall average word count
        //     $totalWordCount = 0;
        //     $recordCount = $result->count();
        //     foreach ($result as $row) {
        //         $totalWordCount += $row->average_word_count;
        //     }
        //     $averageWordCount = $recordCount > 0 ? ($totalWordCount / $recordCount) : 0;
        //     return Response()->json(['result' => $averageWordCount]);
        // }

        // return Response()->json(['result' => "Parameter verification failed"]);
    }


    public function getTotalConversationCount(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetTotalConversationCountJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // if ($showAll) {
        //     $conversationCount = conversations::count();
        //     return Response()->json(['result' => $conversationCount]);
        // }
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $conversationCount = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        //     return Response()->json(['result' => $conversationCount]);
        // }
        // return Response()->json(['result' => "Parameter verification failed"]);
    }

    public function getAvgQueryPerConversation(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetAvgQueryPerConversationJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // if ($showAll) {
        //     $conversationCount = conversations::count();
        //     $queryCount = prompt_histories::count();
        //     return Response()->json(['result' => $queryCount / $conversationCount]);
        // }
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $conversationCount = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        //     $queryCount = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        //     return Response()->json(['result' => $queryCount / $conversationCount]);
        // }
        // return Response()->json(['result' => "Parameter verification failed"]);
    }

    public function getAvgTimePerConversation(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetAvgTimePerConversationJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // $conversationIds = null;
        //     $isValid = false;
        //     if ($showAll) {
        //         $query = "
        //     SELECT
        //         ROUND(TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(AVG(start_time)), FROM_UNIXTIME(AVG(end_time)))/60, 2) AS span_time_in_minutes
        //     FROM
        //         (SELECT conversation_id, UNIX_TIMESTAMP(MIN(created_at)) AS start_time, UNIX_TIMESTAMP(MAX(created_at)) AS end_time FROM prompt_histories GROUP BY conversation_id) AS subquery;
        // ";

        //         $result = DB::select($query);

        //         // Access the result as an array of objects
        //         $spanTimeInMinutes = $result[0]->span_time_in_minutes;
        //         return Response()->json(['result' => floatval($spanTimeInMinutes)]);
        //     }
        //     if ($startDateTime && $endDateTime) {
        //         $startDateTime = Carbon::parse($startDateTime);
        //         $endDateTime = Carbon::parse($endDateTime);
        //         $conversationIds = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //             ->distinct()
        //             ->pluck('conversation_id');
        //         $isValid = true;
        //     }

        //     if (!$isValid)
        //         return Response()->json(['result' => "Parameter verification failed"]);

        //     $totalSpan = 0;

        //     foreach ($conversationIds as $conversationId) {
        //         $oldestTimestamp = prompt_histories::where('conversation_id', $conversationId)
        //             ->min('created_at');
        //         $latestTimestamp = prompt_histories::where('conversation_id', $conversationId)
        //             ->max('created_at');

        //         $oldestDate = Carbon::parse($oldestTimestamp);
        //         $latestDate = Carbon::parse($latestTimestamp);

        //         $minuteSpan = $latestDate->diffInMinutes($oldestDate);
        //         $totalSpan += $minuteSpan;
        //     }
        //     return Response()->json(['result' => $totalSpan / $conversationIds->count()]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // daily breakdown section
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getDailyBreakdownQuery(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetDailyBreakdownQueryJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // $isValid = false;
        // if ($showAll) {
        //     $endDateTime = Carbon::now();
        //     $startDateTime = $endDateTime->copy()->subDays(7);
        //     $isValid = true;
        // }
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $isValid = true;
        // }
        // if (!$isValid)
        //     return Request()->json(['result' => 'failed parameter verification']);
        // // Perform the query to count rows for each day
        // $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        //     ->get();

        // // Convert the results to an associative array for JSON response
        // $report = $result->pluck('count', 'date')->all();
        // Log::info('--------------End of getDailyBreakdownQuery----------------');
        // return $report;
    }

    public function getDailyBreakdownResponseStartTime(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetDailyBreakdownResponseStartTimeJob($startDateTime, $endDateTime, $showAll));
        return 'Dispatcher has been started!';
    }
    public function getDailyBreakdownResponseEndTime(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetDailyBreakdownResponseEndTimeJob($startDateTime, $endDateTime));
        return 'dispatcher has been started!';
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     // Perform the query to count rows for each day
        //     $result = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(response_time) as count'))
        //         ->get();

        //     // Convert the results to an associative array for JSON response
        //     $report = $result->pluck('count', 'date')->all();
        //     return $report;
        // }
        // return Response()->json(['result' => 'Failed']);
    }

    public function getDailyBreakdownInputWord(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetDailyBreakdownInputWordJob($startDateTime, $endDateTime));
        return 'dispatcher has been started!';
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     // Perform the query to calculate average word count for 'user_query' for each day
        //     $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count'))
        //         ->get();

        //     $report = $result->pluck('average_word_count', 'date')->all();
        //     return $report;
        // }
        // return Response()->json(['result' => 'Failed']);
    }

    public function getDailyBreakdownOutputWord(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetDailyBreakdownOutputWordJob($startDateTime, $endDateTime));
        return 'dispatcher has been started!';
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     // Perform the query to calculate average word count for 'user_query' for each day
        //     $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(openai_response) - LENGTH(REPLACE(openai_response, " ", "")) + 1) as average_word_count'))
        //         ->get();

        //     $report = $result->pluck('average_word_count', 'date')->all();
        //     return $report;
        // }
        // return Response()->json(['result' => 'Failed']);
    }

    public function getDailyBreakdownConversations(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetDailyBreakdownConversationsJob($startDateTime, $endDateTime));
        return 'dispatcher has been started!';
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     // Perform the query to count rows for each day
        //     $result = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        //         ->get();

        //     // Convert the results to an associative array for JSON response
        //     $report = $result->pluck('count', 'date')->all();
        //     return $report;
        // }
        // return Response()->json(['result' => 'Failed']);
    }

    public function getDailyBreakdownQueryPerConversation(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetDailyBreakdownQueryPerConversationJob($startDateTime, $endDateTime));
        return 'dispatcher has been started!';
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     $resultFinal = [];
        //     // Perform the query to count rows for each day
        //     $resultConversations = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        //         ->get();
        //     $arrConversations = $resultConversations->pluck('count', 'date');
        //     $resultQueries = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->groupBy(DB::raw('DATE(created_at)'))
        //         ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        //         ->get();
        //     $arrQueries = $resultQueries->pluck('count', 'date');

        //     foreach ($arrConversations as $key => $value) {
        //         # code...
        //         if ($value != 0) {
        //             $resultFinal[$key] = $arrQueries[$key] / $value;
        //         }

        //         // Convert the results to an associative array for JSON response

        //     }
        //     return $resultFinal;
        // }
        // return Response()->json(['result' => 'Failed']);
    }

    public function getDailyBreakdownConversationTime(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetDailyBreakdownConversationTimeJob($startDateTime, $endDateTime));
        return 'dispatcher has been started!';
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);

        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $conversationIds = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->distinct()
        //         ->pluck('conversation_id');
        //     $totalSpan = 0;
        //     $report = [];
        //     $countAll = [];
        //     foreach ($conversationIds as $conversationId) {
        //         $oldestTimestamp = prompt_histories::where('conversation_id', $conversationId)->whereBetween('created_at', [$startDateTime, $endDateTime])
        //             ->min('created_at');
        //         $latestTimestamp = prompt_histories::where('conversation_id', $conversationId)->whereBetween('created_at', [$startDateTime, $endDateTime])
        //             ->max('created_at');

        //         // Check if the dates are valid
        //         $oldestDate = Carbon::parse($oldestTimestamp);
        //         $latestDate = Carbon::parse($latestTimestamp);
        //         if ($oldestDate->isValid() && $latestDate->isValid()) {

        //             $minuteSpan = $latestDate->diffInMinutes($oldestDate);
        //             $report[$oldestDate->toDateString()] = isset($report[$oldestDate->toDateString()]) ? ((int)$report[$oldestDate->toDateString()]) + $minuteSpan : $minuteSpan;
        //             $countAll[$oldestDate->toDateString()] = isset($countAll[$oldestDate->toDateString()]) ? ((int)$countAll[$oldestDate->toDateString()]) + 1 : 1;
        //         }
        //     }
        //     $reportFinal = [];
        //     foreach ($report as $key => $value) {
        //         $reportFinal[$key] = $value / $countAll[$key];
        //     }
        //     ksort($reportFinal);
        //     return $reportFinal;
        // }
        // return Response()->json(['result' => 'Failed']);
    }

    public function getUserLocation()
    {
        // dispatch(new GetUserLocationJob());
        dispatch(new GetUserLocationJob());
        return 'dispatcher has been started!';
        // $USAcount = prompts_metadata::where('location', 'like', '%United States%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $turkeyCount = prompts_metadata::where('location', 'like', '%Turkey%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $argentinaCount = prompts_metadata::where('location', 'like', '%Argentina%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $japanCount = prompts_metadata::where('location', 'like', '%Japan%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $canadaCount = prompts_metadata::where('location', 'like', '%Canada%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $angolaCount = prompts_metadata::where('location', 'like', '%Angola%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $chinaCount = prompts_metadata::where('location', 'like', '%China%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $pakistanCount = prompts_metadata::where('location', 'like', '%Pakistan%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();
        // $portugalCount = prompts_metadata::where('location', 'like', '%Portugal%')
        //     ->distinct('user_ip') // Use distinct to count unique user_ips
        //     ->count();

        // return [
        //     'United states' => $USAcount, 'Turkey' => $turkeyCount, 'Argentina' => $turkeyCount, 'Japan' => $japanCount,
        //     'Canada' => $canadaCount, 'Angola' => $angolaCount, 'China' => $chinaCount, 'Pakistan' => $pakistanCount, 'Portugal' => $portugalCount,
        // ];
    }

    public function getBarchartUsers(Request $request)
    {
        dispatch(new GetBarchartUsersJob());
        return 'dispatcher has been started!';
        // $user = ['Alden' => 65, 'Wajid' => 25, 'Anonymous' => 5];
        // return Response()->json($user);
    }

    public function getBarchartSource(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetBarchartSourceJob($startDateTime, $endDateTime, $showAll));
        return 'dispatcher has been started!';
        // if ($showAll) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $countEmbed = prompts_metadata::where('request_source', 'like', '%embed%')->count();
        //     $countApi = prompts_metadata::where('request_source', 'like', '%api%')->count();
        //     $countDashboard = prompts_metadata::where('request_source', 'like', '%dashboard%')->count();
        //     $countLivechat = prompts_metadata::where('request_source', 'like', '%livechat%')->count();
        //     $countTotal = $countApi + $countDashboard + $countEmbed + $countLivechat;
        //     $result = [
        //         'Dashboard' => $countDashboard, 'Embed' => $countEmbed,
        //         'Livechat' => $countLivechat, 'API' => $countApi
        //     ];
        //     arsort($result);
        //     return Response()->json($result);
        // }
        // if ($startDateTime && $endDateTime) {
        //     $startDateTime = Carbon::parse($startDateTime);
        //     $endDateTime = Carbon::parse($endDateTime);
        //     $countEmbed = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->where('request_source', 'like', '%embed%')->count();
        //     $countApi = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->where('request_source', 'like', '%api%')->count();
        //     $countDashboard = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->where('request_source', 'like', '%dashboard%')->count();
        //     $countLivechat = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
        //         ->where('request_source', 'like', '%livechat%')->count();
        //     $countTotal = $countApi + $countDashboard + $countEmbed + $countLivechat;
        //     $result = [
        //         'Dashboard' => $countDashboard, 'Embed' => $countEmbed,
        //         'Livechat' => $countLivechat, 'API' => $countApi
        //     ];
        //     arsort($result);
        //     return Response()->json($result);
        // }
        // return Response()->json(['result' => 'Failed']);
    }


    public function getBarchartBrowsers(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetBarchartBrowsersJob($startDateTime, $endDateTime, $showAll));

        return 'Dispatcher has been started!';
    }
    public function getBarchartQueryStatus(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');

        dispatch(new GetBarchartQueryStatusJob($startDateTime, $endDateTime, $showAll));

        return 'Dispatcher has been started!';
    }

    public function getQueryByHourly(Request $request)
    {
        $startDateTime = $request->input('start');
        $showAll = $request->input('showall');

        dispatch(new GetQueryByHourlyJob($startDateTime, $showAll));

        return 'Dispatcher has been started!';
    }
    public function getQueryDaily(Request $request)
    {
        $startDateTime = $request->input('start');
        $showAll = $request->input('showall');

        dispatch(new GetQueryDailyJob($startDateTime, $showAll));

        return 'Dispatcher has been started!';
    }

    public function getall(Request $request)
    {
        $startDateTime = $request->input('start');
        $endDateTime = $request->input('end');
        $showAll = $request->input('showall');
        dispatch(new GetTotalQueryCountJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetAvgResponseEndTimeJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetAvgResponseStartTimeJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetAvgInputWordsJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetAvgOutputWordsJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetTotalConversationCountJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetAvgQueryPerConversationJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetAvgTimePerConversationJob($startDateTime, $endDateTime, $showAll));
        // dispatch(new GetDailyBreakdownQueryJob($startDateTime, $endDateTime, $showAll));
        // dispatch(new GetDailyBreakdownResponseStartTimeJob($startDateTime, $endDateTime, $showAll));
        // dispatch(new GetDailyBreakdownResponseEndTimeJob($startDateTime, $endDateTime));
        // dispatch(new GetDailyBreakdownInputWordJob($startDateTime, $endDateTime));
        // dispatch(new GetDailyBreakdownOutputWordJob($startDateTime, $endDateTime));
        // dispatch(new GetDailyBreakdownConversationsJob($startDateTime, $endDateTime));
        // dispatch(new GetDailyBreakdownQueryPerConversationJob($startDateTime, $endDateTime));
        // dispatch(new GetDailyBreakdownConversationTimeJob($startDateTime, $endDateTime));
        dispatch(new GetUserLocationJob());
        dispatch(new GetBarchartUsersJob());
        dispatch(new GetBarchartSourceJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetBarchartBrowsersJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetBarchartQueryStatusJob($startDateTime, $endDateTime, $showAll));
        dispatch(new GetQueryByHourlyJob($startDateTime, $showAll));
        dispatch(new GetQueryDailyJob($startDateTime, $showAll));
        // MyEvent::dispatch("this is the data from test");
        return 'Dispatcher has been started!';
    }

    public function test(Request $request)
    {
        // event(new MyEvent("this is the data from test"));
        MyEvent::dispatch("this is the data from test");
    }
}
