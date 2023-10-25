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

class GetBarchartBrowsersJob implements ShouldQueue
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
            $totalCount = prompts_metadata::distinct()->select('user_ip')->count();
            $chromeCount = prompts_metadata::where('user_agent', 'like', '%chrome%')
                ->distinct('user_ip')
                ->count();
            $windowsCount = prompts_metadata::where('user_agent', 'like', '%windows%')
                ->distinct('user_ip')
                ->count();
            $safariCount = prompts_metadata::where('user_agent', 'like', '%safari%')
                ->distinct('user_ip')
                ->count();
            $unknownCount = $totalCount - $chromeCount - $windowsCount - $safariCount;
            $agentReport = [
                'chrome' => $chromeCount, 'windows' => $windowsCount, 'safari' => $safariCount,
                'unknown' => $unknownCount
            ];
            arsort($agentReport);
            MyEvent::dispatch($agentReport, "setBarchartBrowsers");
            return;
        }

        if ($startDateTime && $endDateTime) {
            // ... (same code as in the original function)
            $startDateTime = Carbon::parse($startDateTime);
            $endDateTime = Carbon::parse($endDateTime);
            $totalCount = prompts_metadata::distinct()->select('user_ip')->count();
            $chromeCount = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('user_agent', 'like', '%chrome%')
                ->distinct('user_ip')
                ->count();
            $windowsCount = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('user_agent', 'like', '%windows%')
                ->distinct('user_ip')
                ->count();
            $safariCount = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('user_agent', 'like', '%safari%')
                ->distinct('user_ip')
                ->count();
            $unknownCount = $totalCount - $chromeCount - $windowsCount - $safariCount;
            $agentReport = [
                'chrome' => $chromeCount, 'windows' => $windowsCount, 'safari' => $safariCount,
                'unknown' => $unknownCount
            ];
            arsort($agentReport);
            MyEvent::dispatch($agentReport, "setBarchartBrowsers");
            return;
        }

        MyEvent::dispatch("failed", "");
    }
}
