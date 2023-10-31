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

class GetQueryDailyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDateTime;
    protected $showAll;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startDateTime, $showAll)
    {
        //
        $this->startDateTime = $startDateTime;
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
        $showAll = $this->showAll;
        $currentDateTime = null;
        $isValid = false;

        if ($showAll) {
            $isValid = true;
            $currentDateTime = Carbon::now();
        }

        if ($startDateTime) {
            $currentDateTime = Carbon::parse($startDateTime);
            $isValid = true;
        }

        if (!$isValid) {
            MyEvent::dispatch("failed", "");
            return;
        }

        $currentDate = $currentDateTime->startOfWeek();

        // Create an array to store the counts for each time range
        $countResults = [];

        // Loop through the time ranges and count the rows in each range
        for ($i = 0; $i < 7; $i++) {
            # code...
            $startTime = $currentDate->copy()->addDays($i);
            $endTime = $currentDate->copy()->addDays($i + 1);
            $count = prompt_histories::whereBetween('created_at', [$startTime, $endTime])->count();
            $countResults[$startTime->format('D')] = $count;
        }
        // Log::info('--------------End of getQueryDaily----------------');
        MyEvent::dispatch($countResults, "setTotalQueryDaily");
    }
}
