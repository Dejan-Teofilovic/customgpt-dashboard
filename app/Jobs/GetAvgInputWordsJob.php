<?php

namespace App\Jobs;

use App\Events\MyEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\prompt_histories;

class GetAvgInputWordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* The code snippet `protected ; protected ; protected ;`
    declares three protected properties in the `GetAvgInputWordsJob` class. These properties are
    used to store the values passed to the constructor of the class. */

    protected $startDateTime;
    protected $endDateTime;
    protected $showAll;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startDateTime, $endDateTime, $showAll)
    {
        //
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->showAll = $showAll;
    }


    /**
     * The handle function calculates the average word count of user queries either for all records or
     * within a specified date range and dispatches an event with the result.
     */
    public function handle()
    {
        //
        if ($this->showAll) {
            // Use the query builder to select the specified column and calculate the average word count
            $averageWordCount = prompt_histories::select(
                DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count')
            )->first()->average_word_count;

            // Handle cases where there are no records
            $averageWordCount = $averageWordCount ?: 0;
            $result = ['result' => intval($averageWordCount)];
            MyEvent::dispatch(intval($averageWordCount), "setAvgQueryInputWord");
        } elseif ($this->startDateTime && $this->endDateTime) {
            $startDateTime = Carbon::parse($this->startDateTime);
            $endDateTime = Carbon::parse($this->endDateTime);

            // Perform the query to calculate average word count for 'user_query' for each day
            $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(user_query) - LENGTH(REPLACE(user_query, " ", "")) + 1) as average_word_count'))
                ->get();

            // Calculate the overall average word count
            $totalWordCount = 0;
            $recordCount = $result->count();
            foreach ($result as $row) {
                $totalWordCount += $row->average_word_count;
            }
            $averageWordCount = $recordCount > 0 ? ($totalWordCount / $recordCount) : 0;
            $result = ['result' => $averageWordCount];
            MyEvent::dispatch($averageWordCount, "setAvgQueryInputWord");
        } else {
            MyEvent::dispatch("failed", "");
        }
    }
}
