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
use App\Models\prompts_metadata;

class GetDailyBreakdownResponseEndTimeJob implements ShouldQueue
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

        // Perform the query to count rows for each day
        $result = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(response_time) as count'))
            ->get();

        // Convert the results to an associative array for JSON response
        $report = $result->pluck('count', 'date')->all();
        MyEvent::dispatch($report, "setDailyBreakdownResponseEndTime");
    }
}
