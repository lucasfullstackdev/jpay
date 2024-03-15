<?php

namespace Database\Factories;

use App\Models\ClickSignEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClickSignEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClickSignEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event' => $this->faker->unique()->word,
        ];
    }
}
