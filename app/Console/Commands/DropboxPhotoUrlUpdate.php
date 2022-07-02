<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\DropboxService;

class DropboxPhotoUrlUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DropboxPhoto:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update dropbox photo url every  hour';

    private $dropboxService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dropboxService = new DropboxService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::stack(['project'])->info('about to update url');
        $this->dropboxService->refreshToken();
        $this->dropboxService->refreshPhotoUrls();
    }
}
