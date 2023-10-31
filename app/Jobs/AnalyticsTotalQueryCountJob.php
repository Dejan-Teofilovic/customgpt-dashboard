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

    /* The lines `protected ;`, `protected ;`, and `protected ;` are
    declaring protected properties in the `AnalyticsTotalQueryCountJob` class. These properties are
    used to store the values passed to the constructor when creating an instance of the class. */
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
    /**
     * The function handles a query count based on certain conditions and dispatches an event with the
     * result.
     * 
     * @return the result of the query count. If the `` flag is set, it returns the count of
     * all prompt_histories records. If the `` and `` variables are set, it
     * returns the count of prompt_histories records created between those two dates. If neither
     * condition is met, it dispatches a MyEvent with the result "failed".
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
