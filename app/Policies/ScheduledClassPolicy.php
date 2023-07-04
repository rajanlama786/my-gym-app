<?php

namespace App\Policies;

use App\Models\ScheduledClass;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScheduledClassPolicy
{
//    use HandlesAuthorization;
//
//    /**
//     * Create a new policy instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        //
//    }

    public function delete( User $user, ScheduledClass $scheduledClass){
        return $user->id === $scheduledClass->instructor_id;
    }
}
