<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Services\DropboxService;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            \Log::stack(['project'])->info("Scheduler called");
            if(time() > env('DROPBOX_TOKEN_EXPIRY') || ((env('DROPBOX_TOKEN_EXPIRY') - time()) <= 60)) {
                //dd(time().' < '.env('DROPBOX_TOKEN_EXPIRY'));
                //If the dropbox token has expired or will expire in less than 1minute
                try{ 
                    DropboxService::refreshToken();
                }catch(\Throwable $th) {
                    \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
