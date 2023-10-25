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

class GetTotalQueryCountJob implements ShouldQueue
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
        $queryCount = 0;

        if ($showAll) {
            $queryCount = prompt_histories::count();
        } elseif ($startDateTime && $endDateTime) {
            $queryCount = prompt_histories::where(function ($query) use ($startDateTime, $endDateTime) {
                $query->where('created_at', '>=', Carbon::parse($startDateTime))
                    ->where('created_at', '<=', Carbon::parse($endDateTime));
            })->count();
        } else {
            MyEvent::dispatch("failed", "");
            return;
        }

        MyEvent::dispatch($queryCount, "setTotalQueryCount");
    }
}
