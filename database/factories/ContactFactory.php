<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'  => $this->faker->name,
            'last_name'   => Str::random(7),
            'slug'        => Str::slug($this->faker->name),
            'email'       => $this->faker->unique()->safeEmail(),
            'street'      => Str::random(10),
            'zipcode'     => Str::random(5),
            'city'        => 676,
        ];
    }
}
