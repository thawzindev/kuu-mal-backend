<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Volunteer;

class VolunteerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_volunteer_can_be_created()
    {
        $volunteer = Volunteer::factory()->raw();

        $result = $this->post('/api/volunteer/create', $volunteer);
    
        $result->assertStatus(200);
    }

    public function test_creating_volunteer_requires_a_name()
    {
        $volunteer = Volunteer::factory()->raw(['name' => '']);

        $result = $this->post('/api/volunteer/create', $volunteer);
    
        $result->assertStatus(422);
    }
}
