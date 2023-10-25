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

class GetQueryByHourlyJob implements ShouldQueue
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

        // Define the time ranges
        $timeRanges = [
            ['start' => 0, 'end' => 6],
            ['start' => 6, 'end' => 9],
            ['start' => 9, 'end' => 12],
            ['start' => 12, 'end' => 15],
            ['start' => 15, 'end' => 18],
            ['start' => 18, 'end' => 23],
            ['start' => 23, 'end' => 24], // Note that this range includes 23:00 to 00:00
        ];
        $currentDateTime = $currentDateTime->startOfDay();

        // Create an array to store the counts for each time range
        $countResults = [];

        // Loop through the time ranges and count the rows in each range
        foreach ($timeRanges as $range) {
            $startTime = $currentDateTime->copy()->addHours($range['start']);
            $endTime = $currentDateTime->copy()->addHours($range['end']);

            $count = prompt_histories::whereBetween('created_at', [$startTime, $endTime])->count();

            $countResults[$range['start']] = $count;
        }
        // Log::info('--------------End of getQueryByHourly----------------');
        MyEvent::dispatch($countResults, "setTotalQueryHourly");
    }
}
