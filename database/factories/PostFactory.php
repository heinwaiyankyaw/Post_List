<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{

    public function definition()
    {
        $address =['yangon','mandalay','bago','pyinoolwin','taunggyi','innlay','pyay'];
        return [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->text(200),
            'price'=>rand(2000,50000),
            'address'=>$address[array_rand($address)],
            'rating'=>rand(0,5),
        ];
    }
}
