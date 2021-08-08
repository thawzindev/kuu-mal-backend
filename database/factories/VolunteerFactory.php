<?php

namespace Database\Factories;

use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Volunteer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'password' => $this->faker->password, 
            'state_id' => random_int(1, 12),
            'township_id'   => random_int(1, 100),
            'activities' => $this->faker->text,
            'address' => $this->faker->text,
            'ip_address' => $this->faker->localIpv4,
            'user_agent' => $this->faker->userAgent,
        ];
    }
}
