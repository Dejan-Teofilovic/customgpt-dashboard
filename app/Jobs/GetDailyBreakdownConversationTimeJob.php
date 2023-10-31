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
use App\Models\prompt_histories;

class GetDailyBreakdownConversationTimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDateTime;
    protected $endDateTime;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startDateTime, $endDateTime)
    {
        //
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $startDateTime = Carbon::parse($this->startDateTime);
        $endDateTime = Carbon::parse($this->endDateTime);
        $conversationIds = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->distinct()
            ->pluck('conversation_id');
        $totalSpan = 0;
        $report = [];
        $countAll = [];

        foreach ($conversationIds as $conversationId) {
            $oldestTimestamp = prompt_histories::where('conversation_id', $conversationId)->whereBetween('created_at', [$startDateTime, $endDateTime])
                ->min('created_at');
            $latestTimestamp = prompt_histories::where('conversation_id', $conversationId)->whereBetween('created_at', [$startDateTime, $endDateTime])
                ->max('created_at');

            // Check if the dates are valid
            $oldestDate = Carbon::parse($oldestTimestamp);
            $latestDate = Carbon::parse($latestTimestamp);

            if ($oldestDate->isValid() && $latestDate->isValid()) {
                $minuteSpan = $latestDate->diffInMinutes($oldestDate);
                $report[$oldestDate->toDateString()] = isset($report[$oldestDate->toDateString()]) ? ((int)$report[$oldestDate->toDateString()]) + $minuteSpan : $minuteSpan;
                $countAll[$oldestDate->toDateString()] = isset($countAll[$oldestDate->toDateString()]) ? ((int)$countAll[$oldestDate->toDateString()]) + 1 : 1;
            }
        }

        $reportFinal = [];
        foreach ($report as $key => $value) {
            $reportFinal[$key] = $value / $countAll[$key];
        }

        ksort($reportFinal);
        MyEvent::dispatch($reportFinal, "setDailyBreakdownConversationTime");
    }
}
