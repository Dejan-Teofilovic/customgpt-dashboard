<?php

namespace App\Jobs;

use App\Events\MyEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\prompts_metadata;

class GetAvgResponseStartTimeJob implements ShouldQueue
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
        if ($this->showAll) {
            $avgResponseEnd = prompts_metadata::average('response_time');
            MyEvent::dispatch(1.3, "setAvgResponseStartTime");
        }

        if ($this->startDateTime && $this->endDateTime) {
            $startDateTime = Carbon::parse($this->startDateTime);
            $endDateTime = Carbon::parse($this->endDateTime);
            $avgResponseEnd = prompts_metadata::whereBetween('created_at', [$startDateTime, $endDateTime])->avg('response_time');
            // return Response()->json(['avgResponseEnd' => 1.3]);
            MyEvent::dispatch(1.3, "setAvgResponseStartTime");
        }

        MyEvent::dispatch("failed", "");
    }
}
