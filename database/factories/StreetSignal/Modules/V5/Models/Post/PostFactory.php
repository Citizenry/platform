<?php

namespace Database\Factories\StreetSignal\Modules\V5\Models\Post;

use Illuminate\Database\Eloquent\Factories\Factory;
use StreetSignal\Modules\V5\Models\Post\Post;
class PostFactory extends Factory
{
   /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber(),
        ];
    }
}
