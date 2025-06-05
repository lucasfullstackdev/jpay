<?php

namespace Database\Factories;

use App\Models\BillingSending;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillingSendingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BillingSending::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->uuid,
            'customer' => $this->faker->randomNumber(5),
            'value' => $this->faker->randomFloat(2, 10, 1000),
            'net_value' => $this->faker->randomFloat(2, 5, 800),
            'billing_type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'invoice_url' => $this->faker->url,
            'invoice_number' => $this->faker->randomNumber(6)
        ];
    }
}
