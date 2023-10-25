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


class GetDailyBreakdownOutputWordJob implements ShouldQueue
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

        // Perform the query to calculate average word count for 'openai_response' for each day
        $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(LENGTH(openai_response) - LENGTH(REPLACE(openai_response, " ", "")) + 1) as average_word_count'))
            ->get();
        $report = $result->pluck('average_word_count', 'date')->all();
        MyEvent::dispatch($report, "setDailyBreakdownOutputWord");
    }
}
