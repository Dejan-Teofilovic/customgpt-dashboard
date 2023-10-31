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
use App\Models\prompts_metadata;
use Illuminate\Support\Facades\DB;

class GetDailyBreakdownResponseStartTimeJob implements ShouldQueue
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
        $startDateTime = $this->startDateTime;
        $endDateTime = $this->endDateTime;
        $showAll = $this->showAll;

        if ($startDateTime && $endDateTime) {
            $startDateTime = Carbon::parse($startDateTime);
            $endDateTime = Carbon::parse($endDateTime);

            // Perform the query to count rows for each day
            $result = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(response_time) as count'))
                ->get();

            // Convert the results to an associative array for JSON response
            $report = $result->pluck('count', 'date')->all();
            MyEvent::dispatch($report, "setDailyBreakdownResponseStartTime");
        } else {
            MyEvent::dispatch("failed", "");
        }
    }
}
