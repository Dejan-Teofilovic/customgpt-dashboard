<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\conversation_debug_info;
use App\Models\prompt_histories;
use App\Models\prompts_metadata;
use App\Models\conversations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    // Default method to display the index page
    public function index()
    {
        echo 'choego';
    }

    /**
     * Calculate the average word count based on the specified type ('input' or 'output').
     * This function retrieves text data from the database and computes the average word count.
     *
     * @param string $type The type of data to calculate word count for (either 'input' or 'output').
     * @return int The calculated average word count as an integer.
     */
    public function calculateAverageWordCount($type)
    {
        if ($type === 'input') {
            $column = 'user_query';
        } elseif ($type === 'output') {
            $column = 'openai_response';
        } else {
            // Handle invalid type, such as throwing an exception or setting a default
            return 0;
        }

        // Use the query builder to select the specified column
        $content = prompt_histories::pluck($column);

        // Initialize variables to store total word count and the number of records
        $totalWordCount = 0;
        $recordCount = $content->count();

        // Loop through the values and calculate word count
        foreach ($content as $text) {
            $wordCount = str_word_count($text);
            $totalWordCount += $wordCount;
        }

        // Calculate the average word count and cast it to an integer
        $averageWordCount = $recordCount > 0 ? intval($totalWordCount / $recordCount) : 0;

        return $averageWordCount;
    }

    /**
     * Endpoint for retrieving analytics related to queries.
     * This function returns query count, response end time, response start time, input words, and output words.
     * It is used for the queries card on the dashboard.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing query-related analytics.
     */
    public function queries()
    {
        $queryCount = prompt_histories::count();
        $queryResponseEndTime = 42; // Placeholder value, replace with actual data
        $queryResponseStartTime = 3.2; // Placeholder value, replace with actual data
        $queryInputWords = $this->calculateAverageWordCount('input');
        $queryOutputWords = $this->calculateAverageWordCount('output');

        return Response()->json([
            'querycount' => $queryCount,
            'queryResponseEndTime' => $queryResponseEndTime,
            'queryResponseStartTime' => $queryResponseStartTime,
            'queryInputWords' => $queryInputWords,
            'queryOutputWords' => $queryOutputWords
        ]);
    }

    /**
     * Calculate and return the time span in minutes between the first and last 'prompt_histories' for a conversation.
     *
     * @param int $conversationId The ID of the conversation for which to calculate the time span.
     * @return int|null The time span in minutes, or null if no records are found.
     */
    public function calculateTimeSpan($conversationId)
    {
        // Get the conversation by ID
        $conversation = conversations::find($conversationId);

        // Check if the conversation exists
        if (!$conversation) {
            return null; // Conversation not found
        }

        // Get the 'prompt_histories' related to the conversation
        $promptHistories = $conversation->promptHistories;

        // Check if there are 'prompt_histories' records
        if ($promptHistories->isEmpty()) {
            return null; // No 'prompt_histories' found
        }

        // Find the timestamps of the first and last 'prompt_histories'
        $firstTimestamp = $promptHistories->first()->created_at;
        $lastTimestamp = $promptHistories->last()->created_at;

        // Calculate the time span in minutes
        $timeSpanInMinutes = $firstTimestamp->diffInMinutes($lastTimestamp);

        return $timeSpanInMinutes;
    }

    /**
     * Calculate and return the average time span in minutes for all conversations.
     *
     * @return float|null The average time span in minutes, or null if no conversations are found.
     */
    public function calculateAverageTimeSpan()
    {
        // Get all conversations
        $conversations = conversations::all();

        // Check if there are conversations
        if ($conversations->isEmpty()) {
            return null; // No conversations found
        }

        $totalTimeSpanInMinutes = 0;

        // Calculate the total time span for all conversations
        foreach ($conversations as $conversation) {
            $timeSpan = $this->calculateTimeSpan($conversation->id);

            // Skip conversations with no 'prompt_histories'
            if ($timeSpan !== null) {
                $totalTimeSpanInMinutes += $timeSpan;
            }
        }

        // Calculate the average time span
        $averageTimeSpan = $totalTimeSpanInMinutes / $conversations->count();

        return $averageTimeSpan;
    }


    

    /**
     * The URL is api/analytics/conversations
     * This function returns the conversations count, queries per conversation, conversatoin time.
     * For the conversation card in the dashboard. 
     */
    public function conversations()
    {
        $conversationCount = conversations::count(); // Use the corrected model name
        $queryCount = prompt_histories::count();
        $averageCount = $conversationCount > 0 ?  $queryCount / $conversationCount : 0;
        $averageTimeSpan = $this->calculateAverageTimeSpan();
        return response()->json(['conversationCount' => $conversationCount, 'averageCount' => $averageCount, 'averageTimeSpan' => $averageTimeSpan]);
    }

    /**
     * Generate a report for 'prompt_histories' for the last 7 days.
     * Calculate the row count for each day.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateQueryReportLast7Days()
    {
        // Get the current date and time
        $currentDateTime = now();

        // Calculate the date and time 7 days ago
        $sevenDaysAgo = $currentDateTime->subDays(30);

        // Perform the query to count rows for each day
        $result = prompt_histories::where('created_at', '>=', $sevenDaysAgo)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->get();

        // Convert the results to an associative array for JSON response
        $report = $result->pluck('count', 'date')->all();

        return $report;
    }
    
    /**
     * Generate a report for 'prompt_histories' for the last 7 days.
     * Calculate the row count for each day.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateConversationReportLast7Days()
    {
        // Get the current date and time
        $currentDateTime = now();

        // Calculate the date and time 7 days ago
        $sevenDaysAgo = $currentDateTime->subDays(30);

        // Perform the query to count rows for each day
        $result = conversations::where('created_at', '>=', $sevenDaysAgo)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->get();

        // Convert the results to an associative array for JSON response
        $report = $result->pluck('count', 'date')->all();

        return $report;
    }
    
    /**
     * Calculate and return the average word count of 'user_query' for each day in the last 7 days.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateAverageInputWordCountLast7Days()
    {
        // Get the current date and time
        $currentDateTime = now();

        // Calculate the date and time 7 days ago
        $sevenDaysAgo = $currentDateTime->subDays(30);

        // Perform the query to calculate average word count for 'user_query' for each day
        $result = prompt_histories::where('created_at', '>=', $sevenDaysAgo)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count'))
            ->get();

            $report = $result->pluck('average_word_count', 'date')->all();
            return $report;
    }
    
    /**
     * Calculate and return the average word count of 'user_query' for each day in the last 7 days.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateAverageOutputWordCountLast7Days()
    {
        // Get the current date and time
        $currentDateTime = now();

        // Calculate the date and time 7 days ago
        $sevenDaysAgo = $currentDateTime->subDays(30);

        // Perform the query to calculate average word count for 'user_query' for each day
        $result = prompt_histories::where('created_at', '>=', $sevenDaysAgo)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(openai_response) - LENGTH(REPLACE(openai_response, " ", "")) + 1) as average_word_count'))
            ->get();

            $report = $result->pluck('average_word_count', 'date')->all();
            return $report;
    }

/**
 * Calculate the average count of recent 'prompt_histories' records per unique 'conversation_id' values.
 *
 * This function retrieves 'prompt_histories' records created in the past 7 days, counts the number of
 * unique 'conversation_id' values, and calculates the average count of records per unique conversation.
 *
 * @return float The average count of recent 'prompt_histories' records per unique 'conversation_id' values.
 */
function calculateAverageCountOfRecentPromptHistories()
{
    $sevenDaysAgo = now()->subDays(30); // Calculate the date 7 days ago

    $recentPromptHistories = prompt_histories::where('created_at', '>=', $sevenDaysAgo)->get();

    // Use the distinct method to retrieve unique conversation_id values
    $uniqueConversationIds = $recentPromptHistories->pluck('conversation_id')->unique();

    $uniqueConversationCount = $uniqueConversationIds->count();

    // Calculate the average count
    $averageCount = $recentPromptHistories->count() / $uniqueConversationCount;

    return $averageCount;
}

public function calculateAverageTimeSpanForlast7days()
    {
        // Get all conversations
        $sevenDaysAgo = now()->subDays(30); // Calculate the date 7 days ago
        $conversations = conversations::where('created_at', '>=', $sevenDaysAgo)->get();;

        // Check if there are conversations
        if ($conversations->isEmpty()) {
            return null; // No conversations found
        }

        $totalTimeSpanInMinutes = 0;

        // Calculate the total time span for all conversations
        foreach ($conversations as $conversation) {
            $timeSpan = $this->calculateTimeSpan($conversation->id);

            // Skip conversations with no 'prompt_histories'
            if ($timeSpan !== null) {
                $totalTimeSpanInMinutes += $timeSpan;
            }
        }

        // Calculate the average time span
        $averageTimeSpan = $totalTimeSpanInMinutes / $conversations->count();

        return $averageTimeSpan;
    }

    /**
     * The URL is api/analytics/daily-breakdown
     * This function returns the queries, response end time, reponse start time, input words, output words, conversations,
     * queries per conversation, and conversation time.
     * For the daily breakdown card in the dashboard. 
     */
    public function dailybreakdown()
    {
        $queryReport = $this->generateQueryReportLast7Days();
        $inputWordCount = $this->calculateAverageInputWordCountLast7Days();
        $outputWordCount = $this->calculateAverageOutputWordCountLast7Days();
        $conversationsReport = $this->generateConversationReportLast7Days();
        $queriesPerConversation = $this->calculateAverageCountOfRecentPromptHistories();
        $averageConversationTime = $this->calculateAverageTimeSpanForlast7days();
        return Response()->json(['queryReport' => $queryReport, 'responseStartTimeReport' => '3.2s', 'responseEndTimeReport' => '42s'
                               , 'inputWordReport' => $inputWordCount, 'outputWordReport' => $outputWordCount, 'conversationReport' => $conversationsReport,
                            'queriesPerConversation' => $queriesPerConversation, 'averageConversationTime' => $averageConversationTime]);
    }

    /**
     * The URL is api/analytics/user-location
     * This function returns the count of users in USA, ....
     * For the user location card in the dashboard. 
     */
    public function userlocation()
    {
        $USAcount = prompts_metadata::where('location', 'like','%United States%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $turkeyCount = prompts_metadata::where('location', 'like','%Turkey%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $argentinaCount = prompts_metadata::where('location', 'like','%Argentina%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $japanCount = prompts_metadata::where('location', 'like','%Japan%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $canadaCount = prompts_metadata::where('location','like', '%Canada%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $angolaCount = prompts_metadata::where('location','like', '%Angola%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $chinaCount = prompts_metadata::where('location', 'like','%China%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $pakistanCount = prompts_metadata::where('location', 'like','%Pakistan%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();
        $portugalCount = prompts_metadata::where('location', 'like','%Portugal%')
        ->distinct('user_ip') // Use distinct to count unique user_ips
        ->count();

        return Response()->json(['United Status' => $USAcount, 'Turkey' => $turkeyCount, 'Argentina' => $turkeyCount, 'Japan' => $japanCount,
                                'Canada' => $canadaCount, 'Angola' => $angolaCount, 'China' => $chinaCount, 'Pakistan' => $pakistanCount, 'Portugal' => $portugalCount] );

    }
    /**
     * The URL is api/analytics/total-queries
     * This function returns the statistics of the users, source, browser, query status.
     * For the user piechart cards in the dashboard. 
     */
    public function totalqueries()
    {
        
    }
}
