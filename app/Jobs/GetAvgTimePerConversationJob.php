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
use mysqli;

class GetAvgTimePerConversationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $conversationIds = null;
        $isValid = false;
        if ($this->showAll) {
            $query = "
         SELECT
             ROUND(TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(AVG(start_time)), FROM_UNIXTIME(AVG(end_time)))/60, 2) AS span_time_in_minutes
         FROM
             (SELECT conversation_id, UNIX_TIMESTAMP(MIN(created_at)) AS start_time, UNIX_TIMESTAMP(MAX(created_at)) AS end_time FROM prompt_histories GROUP BY conversation_id) AS subquery;
     ";

            $result = DB::select($query);

            // Access the result as an array of objects
            $spanTimeInMinutes = $result[0]->span_time_in_minutes;
            $result = ['result' => floatval($spanTimeInMinutes)];
            MyEvent::dispatch(floatval($spanTimeInMinutes), "setAvgTimePerConversation");
            return;
        } elseif ($this->startDateTime && $this->endDateTime) {
            $startDateTime = Carbon::parse($this->startDateTime);
            $endDateTime = Carbon::parse($this->endDateTime);
            $conversationIds = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->distinct()
                ->pluck('conversation_id');
            $isValid = true;
        }

        if (!$isValid) {
            MyEvent::dispatch("failed", "");
            return;
        }

        $totalSpan = 0;

        foreach ($conversationIds as $conversationId) {
            $oldestTimestamp = prompt_histories::where('conversation_id', $conversationId)
                ->min('created_at');
            $latestTimestamp = prompt_histories::where('conversation_id', $conversationId)
                ->max('created_at');

            $oldestDate = Carbon::parse($oldestTimestamp);
            $latestDate = Carbon::parse($latestTimestamp);

            $minuteSpan = $latestDate->diffInMinutes($oldestDate);
            $totalSpan += $minuteSpan;
        }
        $result = ['result' => $totalSpan / $conversationIds->count()];

        MyEvent::dispatch($totalSpan / $conversationIds->count(), "setAvgTimePerConversation");
    }
}
