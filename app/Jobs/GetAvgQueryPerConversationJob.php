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
use App\Models\prompt_histories;

class GetAvgQueryPerConversationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDateTime;
    protected $endDateTime;
    protected $showAll;
    public $result;
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
            $queryCount = prompt_histories::count();
            $result = ['result' => $queryCount / $conversationCount];
            $this->result = $queryCount / $conversationCount;
            MyEvent::dispatch($queryCount / $conversationCount, 'setAvgQueryPerConversation');
        } elseif ($this->startDateTime && $this->endDateTime) {
            $startDateTime = Carbon::parse($this->startDateTime);
            $endDateTime = Carbon::parse($this->endDateTime);
            $conversationCount = conversations::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
            $queryCount = prompt_histories::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
            $result = ['result' => $queryCount / $conversationCount];
            $this->result = $queryCount / $conversationCount;
            MyEvent::dispatch($queryCount / $conversationCount, 'setAvgQueryPerConversation');
        } else {
            MyEvent::dispatch("failed", "");
            $this->result = 'failed';
        }
    }
    public function finished()
    {
        // MyEvent::dispatch($this->result, 'setAvgQueryPerConversation');
    }
}
