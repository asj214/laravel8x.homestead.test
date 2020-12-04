<?php

namespace Database\Factories;

use App\Models\Attachment;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $width = 800;
        $height = 600;
        $type = Arr::random(['city', 'abstract', 'food', 'nightlife']);

        return [
            //
            // 'attachment_type' => 'posts',
            // 'attachment_id' => 1,
            // 'user_id' => 1,
            'filename' => $this->faker->word.".jpg",
            'url' => $this->faker->imageUrl($width, $height, $type, true, 'Faker', true)
        ];
    }
}
