<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\conversation_debug_info;
use App\Models\prompt_histories;
use App\Models\prompts_metadata;
use App\Models\conversations;

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
     * The URL is api/analytics/conversations
     * This function returns the conversations count, queries per conversation, conversatoin time.
     * For the conversation card in the dashboard. 
     */
    public function conversations()
    {
        
    }

    /**
     * The URL is api/analytics/daily-breakdown
     * This function returns the queries, response end time, reponse start time, input words, output words, conversations,
     * queries per conversation, and conversation time.
     * For the daily breakdown card in the dashboard. 
     */
    public function dailybreakdown()
    {
    }

    /**
     * The URL is api/analytics/user-location
     * This function returns the count of users in USA, ....
     * For the user location card in the dashboard. 
     */
    public function userlocation()
    {
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
