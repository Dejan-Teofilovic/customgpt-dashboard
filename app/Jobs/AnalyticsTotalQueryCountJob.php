<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\prompt_histories;
use App\Events\MyEvent;
use Illuminate\Support\Carbon;

class AnalyticsTotalQueryCountJob implements ShouldQueue
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
        $queryCount = 0;

        if ($this->showAll) {
            $queryCount = prompt_histories::count();
        } else if ($this->startDateTime && $this->endDateTime) {
            $queryCount = prompt_histories::whereBetween('created_at', Carbon::parse($this->startDateTime), Carbon::parse($this->endDateTime))->count();
        } else {
            MyEvent::dispatch(['result' => "failed"]);
            return;
        }

        MyEvent::dispatch(['result' => $queryCount]);
    }
}
