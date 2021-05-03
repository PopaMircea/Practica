<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Boards;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Boards::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->sentence(),
            'user_id'=> User::all()->random()->id,
        ];
    }
}
