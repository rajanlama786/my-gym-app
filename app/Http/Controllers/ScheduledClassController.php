<?php

namespace App\Http\Controllers;

use App\Events\ClassCanceled;
use App\Models\ClassType;
use App\Models\ScheduledClass;
use Illuminate\Http\Request;

class ScheduledClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheduledClasses = auth()->user()->scheduledClasses()->upcoming()->oldest('date_time')->get();
        return view('instructor.upcoming')->with('scheduledClasses', $scheduledClasses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classTypes = ClassType::all();
        return view('instructor.schedule')->with('classTypes', $classTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date_time = $request->input('date')." ".$request->input('time');

        $request->merge([
            'date_time' => 'date_time',
            'instructor_id' => auth()->id(),
        ]);

        $validated = $request->validate([
            'class_type_id' => 'required',
            'date_time' => 'required|unique:scheduled_classes,date_time|after:now'
        ]);

        ScheduledClass::create( $validated );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScheduledClass $schedule)
    {

        if(auth()->user()->cannot('delete', $schedule)){
            abort(403);
        }

//        if( auth()->user()->id !== $schedule->?instructor_id){
//            abort(403 );
//        }

        ClassCanceled::dispatch($schedule); // this is required to dispatch or trigger the event


        $schedule->members()->detach();
        $schedule->delete();

        return redirect()->route('schedule.index');

    }
}
