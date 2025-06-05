<?php

namespace Database\Factories;

use App\Models\AsaasEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsaasEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AsaasEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event' => $this->faker->unique()->word(), // Gerar um nome de evento único
        ];
    }
}
