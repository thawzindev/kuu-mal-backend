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
    
        $result->assertSee("Success");
    }

    public function test_volunteer_can_be_created_and_login()
    {
        $volunteer = Volunteer::factory()->raw(['password'  => 'password']);

        $accCreateResp = $this->post('/api/volunteer/create', $volunteer);
        
        $accCreateResp->assertStatus(200);

        $loginAttributes = [
            'phone' => $volunteer['phone'],
            'password'  => $volunteer['password']
        ];

        $loginResp = $this->post('/api/volunteer/login', $loginAttributes);

        $loginResp->assertSee('access_token');

    }

    public function test_volunteer_cannot_update_profile_without_authenticated()
    {
        $profileUpdateAttributes = [
            'name'  => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'address'  => $this->faker->address,
            'activities'    => $this->faker->text
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'bearer 12121',
        ];


        $updateProfileResp = $this->post('/api/volunteer/profile/update', $profileUpdateAttributes);
        
        $updateProfileResp->assertUnauthorized();
    }


    public function test_volunteer_can_view_profile_if_authenticated()
    {

        $this->withoutExceptionHandling();

        $volunteer = Volunteer::factory()->create();

        $token = \JWTAuth::fromUser($volunteer);

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'bearer '. $token,
        ];

        $viewProfileResp = $this->withHeaders($headers)->get('/api/volunteer/profile');
        
        $viewProfileResp->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id', 'name', 'phone', 'active', 'activities', 'address'
            ]
        ]);
    }

    public function test_volunteer_can_update_profile_if_authenticated_and_recheck()
    {

        $this->withoutExceptionHandling();

        $volunteer = Volunteer::factory()->create();

        $profileUpdateAttributes = [
            'name'  => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'address'  => $this->faker->address,
            'activities'    => $this->faker->text
        ];
        
        $token = \JWTAuth::fromUser($volunteer);

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'bearer '. $token,
        ];
        

        $updateProfileResp = $this->withHeaders($headers)->postJson('/api/volunteer/profile/update', $profileUpdateAttributes);
        
        $updateProfileResp->assertStatus(200)->assertJsonStructure([
            'message'
        ]);
    }

    public function test_creating_volunteer_requires_a_name()
    {
        $volunteer = Volunteer::factory()->raw(['name' => '']);

        $result = $this->post('/api/volunteer/create', $volunteer);
    
        $result->assertStatus(422);
    }
}
