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
use App\Models\conversations;
use App\Models\prompt_histories;


class GetDailyBreakdownQueryPerConversationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDateTime;
    protected $endDateTime;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startDateTime, $endDateTime)
    {
        //
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
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

        $resultFinal = [];
        // Perform the query to count rows for each day
        $resultConversations = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->get();
        $arrConversations = $resultConversations->pluck('count', 'date');
        $resultQueries = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->get();
        $arrQueries = $resultQueries->pluck('count', 'date');

        foreach ($arrConversations as $key => $value) {
            if ($value != 0) {
                $resultFinal[$key] = $arrQueries[$key] / $value;
            }
        }
        MyEvent::dispatch($resultFinal, "setDailyBreakdownQueryPerConversation");
        return;
    }
}
