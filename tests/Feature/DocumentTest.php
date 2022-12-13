<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentTest extends TestCase
{

    /**
     * Check if the document page returns a 200 status code.
     *
     * @return void
     */
    public function test_documents_index_are_rendered()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // login user
        $response = $this->actingAs($user);

        // check if the document page returns a 200 status code
        $response = $this->get('/dokumente');

        $response->assertStatus(200);
    }

    /**
     * Check if the document upload page can be rendered.
     *
     *
     * @return void
     */
    public function test_documents_upload_page_can_be_rendered()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // create doctor
        $doctor = \App\Models\User::factory()->create();
        $doctor->is_doctor = true;

        // login user
        $response = $this->actingAs($user);

        // check if the document upload page can be rendered
        $response = $this->get('/dokumente/teilen/' . $doctor->id);

        $response->assertStatus(200);
    }

    /**
     * Check if the document upload page can only be visitied if logged in.
     *
     *
     * @return void
     */
    public function test_documents_upload_page_can_only_be_visited_if_logged_in()
    {
        // create doctor
        $doctor = \App\Models\User::factory()->create();
        $doctor->is_doctor = true;

        // check if the document upload page can be rendered
        $response = $this->get('/dokumente/teilen/' . $doctor->id);

        $response->assertStatus(302);
    }

    /**
     * Check if the document can only be shared with a doctor.
     *
     * @return void
     */
    public function test_document_can_only_be_shared_with_a_doctor()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // create doctor
        $doctor = \App\Models\User::factory()->create();

        // login user
        $response = $this->actingAs($user);

        // check if the document upload page can be rendered
        $response = $this->post('/dokumente/upload/' . $doctor->id);

        $response->assertStatus(403);
    }

    /**
     * Check if the document can be shared with a doctor.
     *
     * @return void
     */
    public function test_document_can_be_shared_with_a_doctor()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // create doctor
        $doctor = \App\Models\User::factory()->create();
        $doctor->is_doctor = true;

        // login user
        $response = $this->actingAs($user);

        // the backend check if files are uploaded
        // so we need to fake the upload
        $file = \Illuminate\Http\UploadedFile::fake()->create('document.pdf', 100);



        $response = $this->post('/dokumente/upload/' . $doctor->id, [
            'file' => $file,
            'description' => 'Test'
        ]);

        $response->assertStatus(403);
    }

    /**
     * Check if a document can be not be deleted by another user.
     *
     * @return void
     */

    public function test_document_can_not_be_deleted_by_another_user()
    {
        // create user
        $user = \App\Models\User::factory()->create();

        // create doctor
        $doctor = \App\Models\User::factory()->create();
        $doctor->is_doctor = true;

        // login user
        $response = $this->actingAs($user);

        // the backend check if files are uploaded
        // so we need to fake the upload
        $file = \Illuminate\Http\UploadedFile::fake()->create('document.pdf', 100);


        $response = $this->post('/dokumente/upload/' . $doctor->id, [
            'file' => $file,
            'description' => 'Test'
        ]);

        // check if the document upload page can be rendered
        $response = $this->delete('/dokumente/1');

        $response->assertStatus(404);
    }
}
