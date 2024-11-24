<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Copyright;

class CheckExpiryCopyright extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expiry-copyrigit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra hết hạn cho bản quyền';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Checking copyright expiry...');

        $today = Carbon::today();

        $expiredCopyrights = Copyright::where('expiry_day', '<', $today)->get();

        foreach ($expiredCopyrights as $copyright) {
            $this->info("Copyright ID {$copyright->id} expired on {$copyright->expiry_day}.");
        }

        $this->info('Expiry check completed.');
    }
}
