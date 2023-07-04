<?php

namespace App\Console\Commands;

use App\Notifications\RemindMembersNotfication;
use Illuminate\Console\Command;
use App\Models\User;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
class RemindMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:remind-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind members to book a call';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $members = User::where('role','member')->whereDoesntHave('bookings', function($query){
            $query->where('date_time', '>', now());
        })->select('name', 'email')->get();
//        return Command::SUCCESS;
        $this->table(
            ['Name', 'Email'],
            $members->toArray()
        );

        //Notification::send($members, new RemindMembersNotfication);
    }
}
