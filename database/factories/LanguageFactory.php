<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Language;

class LanguageFactory extends Factory
{

    protected $model = Language::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           
                'name' => $this->faker->title,
                'subject' => $this->faker->text,
        
        ];
    }
}
