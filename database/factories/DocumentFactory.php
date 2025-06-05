<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer' => function () {
                // Assuming you have a Customer model and want to assign a random existing customer ID
                return \App\Models\Customer::factory()->create()->sku;
            },
            'document_id' => $this->faker->unique()->uuid, // Generating a unique UUID for the document_id
            'document' => json_encode($this->faker->sentence), // Generating a random sentence for the document
        ];
    }
}
