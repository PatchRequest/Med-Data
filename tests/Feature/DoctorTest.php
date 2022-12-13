<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DoctorTest extends TestCase
{
    /**
     * Check if the doctor page returns a 200 status code.
     *
     *
     * @return void
     */
    public function test_doctors_index_are_rendered()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // login user
        $response = $this->actingAs($user);

        // check if the doctor page returns a 200 status code
        $response = $this->get('/aerzte');

        $response->assertStatus(200);
    }

    /**
     * Check if the doctor page can only be visitied if logged in.
     *
     *
     * @return void
     */
    public function test_doctors_index_can_only_be_visited_if_logged_in()
    {
        // check if the doctor page can only be visitied if logged in
        $response = $this->get('/aerzte');

        $response->assertStatus(302);
    }

    /**
     * Check if A new user is never a Doctor
     *
     * @return void
     */

    public function test_a_new_user_is_never_a_doctor()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // check if the user is not a doctor
        $this->assertTrue(!$user->is_doctor);

    }


}
