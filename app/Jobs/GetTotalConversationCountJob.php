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
use App\Models\conversations;

class GetTotalConversationCountJob implements ShouldQueue
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
            $conversationCount = conversations::count();
            $result = ['result' => $conversationCount];
        } elseif ($this->startDateTime && $this->endDateTime) {
            $startDateTime = Carbon::parse($this->startDateTime);
            $endDateTime = Carbon::parse($this->endDateTime);
            $conversationCount = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
            $result = ['result' => $conversationCount];
        } else {
            // $result = ['result' => "Parameter verification failed"];
            MyEvent::dispatch("failed", "");
            return;
        }

        MyEvent::dispatch($conversationCount, "setTotalConversationCount");
    }
}
