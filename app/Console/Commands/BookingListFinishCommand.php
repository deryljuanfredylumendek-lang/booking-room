<?php

namespace App\Console\Commands;

use App\Models\BookingList;
use Illuminate\Console\Command;

class BookingListFinishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Status Booking to Done based on time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lists = BookingList::whereIn('status', ['used', 'approved'])
                            ->where(function ($query) {
                                $query->whereDate('date', '<', now())
                                      ->orWhere(function ($query) {
                                          $query->whereDate('date', now())
                                                ->whereTime('end', '<', now());
                                      });
                            })
                            ->get();

        foreach ($lists as $list) {
            $list->update([
                'status' => 'done',
            ]);
        }

        $this->info('Set Status booking to done for finished bookings.');

        return 0;
    }
}
