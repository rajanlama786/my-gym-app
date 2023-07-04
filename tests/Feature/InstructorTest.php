<?php

namespace Tests\Feature;

use App\Models\ScheduledClass;
use App\Models\User;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ClassType;

class InstructorTest extends TestCase
{
    //use RefreshDatabase; // this will refresh DB every time runs
    /**
     * A basic feature test example.
     *
     * @return void
     */
//    public function test_example()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
    public function test_instructor_is_redirected_to_instructor_dashboard(){
        $user = \App\Models\User::factory()->create([
            'role' => 'instructor'
        ]);
        $response = $this->actingAs($user)
            ->get('/dashboard'); /// this is redirected url
        $response->assertRedirectToRoute('instructor.dashboard'); // this is the redirected url

        $this->followingRedirects($response)->assertSeeText("Hey Instructor"); // this will fail becuase test is not same
    }

    public function test_instructor_can_schedule_a_class(){
        //Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);
        $this->seed(ClassTypeSeeder::class);

        //this is use for database assert
        //When
        $response =  $this->actingAs($user)
            ->post('/instructor/schedule', [
            'class_type_id' => ClassType::first()->id,
            'date' => '2023-07-20 12:50:00',
        ]);

        $this->assertDatabaseHas(  'scheduled_classes',[
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2023-07-05 06:17:26',
        ]);

        //Then
        $response->assertRedirectToRoute('schedule.index');
    }

    public  function test_instructor_can_cancel_class(){
        //Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);
       // $this->seed(ClassTypeSeeder::class);
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2023-08-20 12:00:00'
        ]);

        //When
        $response =  $this->actingAs($user)
            ->delete('/instructor/schedule'.$scheduledClass->id);

        $this->assertDatabaseMissing(  'scheduled_classes',[
            'id' => $scheduledClass->id
        ]);

        //Then
        $response->assertRedirectToRoute('schedule.index');
    }

}
