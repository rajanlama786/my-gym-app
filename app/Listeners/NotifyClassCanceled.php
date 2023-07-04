<?php

namespace App\Listeners;

use App\Events\ClassCanceled;
use App\Jobs\NotifyClassCanceledJob;
use App\Mail\ClassCanceledMail;
use App\Notifications\ClassCancelNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyClassCanceled
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ClassCanceled  $event
     * @return void
     */
    public function handle(ClassCanceled $event)
    {
        $scheduledClass = $event->scheduledClass;

        $members = $event->scheduledClass->members()->get();

        $className = $event->scheduledClass->classType->name;
        $classDateTime = $event->scheduledClass->date_time;

        $details = compact('className', 'classDateTime'); // this will create array

        /** this to send mail person by eprson */
//        $members->each(function($user) use ($details){
//            Mail::to($user)->send( new ClassCanceledMail( $details) );
//        });

        // THis is to send notifications to all
        // you can move this to job
        // Notification::send($members, new ClassCancelNotification($details));

        //Log::info($scheduledClass);

        NotifyClassCanceledJob::dispatch( $members, $details);
    }
}
