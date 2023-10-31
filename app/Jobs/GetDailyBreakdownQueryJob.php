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

class GetDailyBreakdownQueryJob implements ShouldQueue
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
        //Log::info('--------------Start of getDailyBreakdownQuery----------------');
        $isValid = false;
        if ($this->showAll) {
            $endDateTime = Carbon::now();
            $startDateTime = $endDateTime->copy()->subDays(7);
            $isValid = true;
        } elseif ($this->startDateTime && $this->endDateTime) {
            $startDateTime = Carbon::parse($this->startDateTime);
            $endDateTime = Carbon::parse($this->endDateTime);
            $isValid = true;
        } else {
            MyEvent::dispatch("failed", "");
            return;
        }

        // Perform the query to count rows for each day
        $result = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->get();

        // Convert the results to an associative array for JSON response
        $report = $result->pluck('count', 'date')->all();
        // Log::info('--------------End of getDailyBreakdownQuery----------------');
        MyEvent::dispatch($report, "setDailyBreakdownQuery");
        return;
    }
}
