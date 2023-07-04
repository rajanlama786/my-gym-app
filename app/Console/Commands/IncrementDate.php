<?php

namespace App\Console\Commands;

use App\Models\ScheduledClass;
use Illuminate\Console\Command;

class IncrementDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:increment-date {--days=1}';
    // this is without parameter
    //protected $signature = 'command:increment-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment all the scheduled Classes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $scheduledClasses = ScheduledClass::latest('date_time')->get();
        $scheduledClasses->each(function($class){
//            $class->date_time = $class->date_time->addDays(1);
            $class->date_time = $class->date_time->addDays($this->options('days')); // this is used when we have options
            $class->save();
        });
        //return Command::SUCCESS;
    }
}
