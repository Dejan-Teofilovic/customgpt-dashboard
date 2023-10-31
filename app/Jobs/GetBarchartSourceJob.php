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

class GetBarchartSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $results;
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
        $this->results = [];
        // $this->results = [];
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
            $countEmbed = prompts_metadata::where('request_source', 'like', '%embed%')->count();
            $countApi = prompts_metadata::where('request_source', 'like', '%api%')->count();
            $countDashboard = prompts_metadata::where('request_source', 'like', '%dashboard%')->count();
            $countLivechat = prompts_metadata::where('request_source', 'like', '%livechat%')->count();
            $countTotal = $countApi + $countDashboard + $countEmbed + $countLivechat;

            $result = [
                'Dashboard' => $countDashboard, 'Embed' => $countEmbed,
                'Livechat' => $countLivechat, 'API' => $countApi
            ];
            arsort($result);
            MyEvent::dispatch($result, "setBarchartSource");
            return;
        }

        if ($startDateTime && $endDateTime) {
            $countEmbed = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('request_source', 'like', '%embed%')->count();
            $countApi = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('request_source', 'like', '%api%')->count();
            $countDashboard = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('request_source', 'like', '%dashboard%')->count();
            $countLivechat = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])
                ->where('request_source', 'like', '%livechat%')->count();
            $countTotal = $countApi + $countDashboard + $countEmbed + $countLivechat;

            $result = [
                'Dashboard' => $countDashboard, 'Embed' => $countEmbed,
                'Livechat' => $countLivechat, 'API' => $countApi
            ];
            arsort($result);
            MyEvent::dispatch($result, "setBarchartSource");
            return;
        }

        MyEvent::dispatch("failed", "");
    }
}
