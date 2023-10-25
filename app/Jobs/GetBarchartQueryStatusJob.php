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
use App\Models\conversation_debug_info;

class GetBarchartQueryStatusJob implements ShouldQueue
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
        $startDateTime = Carbon::parse($this->startDateTime);
        $endDateTime = Carbon::parse($this->endDateTime);
        $showAll = $this->showAll;

        if ($showAll) {
            // ... (same code as in the original function)
            $totalQueryStatus = conversation_debug_info::count();
            $successCount = conversation_debug_info::where('status', 'success')->count();
            $failCount = $totalQueryStatus - $successCount;
            $statusReport = ['success' => $successCount, 'fail' => $failCount];
            arsort($statusReport);
            MyEvent::dispatch($statusReport, "setBarchartQueryStatus");
            return;
        }

        if ($startDateTime && $endDateTime) {
            // ... (same code as in the original function)
            $startDateTime = Carbon::parse($startDateTime);
            $endDateTime = Carbon::parse($endDateTime);
            $successCount = conversation_debug_info::whereBetween('created_at', [$startDateTime, $endDateTime])->where('status', 'success')
                ->count();
            $totalQueryStatus = conversation_debug_info::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
            // $failedCount = $total- $successCount;
            $failCount = $totalQueryStatus - $successCount;

            $statusReport = ['success' => $successCount, 'fail' => $failCount];
            arsort($statusReport);
            MyEvent::dispatch($statusReport, "setBarchartQueryStatus");
            return;
        }

        MyEvent::dispatch("failed", "");
    }
}
