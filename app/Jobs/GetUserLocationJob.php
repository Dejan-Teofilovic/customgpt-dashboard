<?php

namespace App\Jobs;

use App\Events\MyEvent;
use App\Events\UserLocationEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\prompts_metadata;

class GetUserLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $result;
    protected $results;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->results = [];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $USAcount = prompts_metadata::where('location', 'like', '%United States%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $turkeyCount = prompts_metadata::where('location', 'like', '%Turkey%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $argentinaCount = prompts_metadata::where('location', 'like', '%Argentina%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $japanCount = prompts_metadata::where('location', 'like', '%Japan%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $canadaCount = prompts_metadata::where('location', 'like', '%Canada%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $angolaCount = prompts_metadata::where('location', 'like', '%Angola%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $chinaCount = prompts_metadata::where('location', 'like', '%China%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $pakistanCount = prompts_metadata::where('location', 'like', '%Pakistan%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $portugalCount = prompts_metadata::where('location', 'like', '%Portugal%')
            ->distinct('user_ip') // Use distinct to count unique user_ips
            ->count();
        $this->result = [
            'United States' => $USAcount, 'Turkey' => $turkeyCount, 'Argentina' => $argentinaCount, 'Japan' => $japanCount,
            'Canada' => $canadaCount, 'Angola' => $angolaCount, 'China' => $chinaCount, 'Pakistan' => $pakistanCount, 'Portugal' => $portugalCount,
        ];
        MyEvent::dispatch([
            'United States' => $USAcount, 'Turkey' => $turkeyCount, 'Argentina' => $argentinaCount, 'Japan' => $japanCount,
            'Canada' => $canadaCount, 'Angola' => $angolaCount, 'China' => $chinaCount, 'Pakistan' => $pakistanCount, 'Portugal' => $portugalCount,
        ], "setUserLocation");
    }
}
