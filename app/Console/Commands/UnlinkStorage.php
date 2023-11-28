<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UnlinkStorage extends Command
{
    protected $signature = 'unlink:storage';
    protected $description = 'Unlink the storage symbolic link';

    public function handle()
    {
        $linkPath = public_path('storage');

        if (File::exists($linkPath)) {
            File::delete($linkPath);
            $this->info('Storage link has been unlinked.');
        } else {
            $this->info('Storage link does not exist.');
        }
    }
}
