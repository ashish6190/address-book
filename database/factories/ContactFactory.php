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
            'last_name'   => $this->faker->name,
            'slug'        => Str::slug($this->faker->name),
            // 'profile_pic' => $this->faker->name,
            'email'       => $this->faker->unique()->safeEmail(),
            'street'      => $this->faker->text,
            // 'zipcode'     => $this->faker->text,
            // 'city'        => $this->faker->name,
        ];
    }
}
