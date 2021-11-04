<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        QuestionType::factory()->create(['name' => 'Multichoice']);
        QuestionType::factory()->create(['name' => 'Singlechoice']);
        QuestionType::factory()->create(['name' => 'Rating']);
        QuestionType::factory()->create(['name' => 'Dropdown']);
        QuestionType::factory()->create(['name' => 'Textbox']);
        QuestionType::factory()->create(['name' => 'Ranking']);
        QuestionType::factory()->create(['name' => 'Slider']);

        Category::factory()->create(['name' => 'General']);
        Category::factory()->create(['name' => 'Customers feedback']);
        Category::factory()->create(['name' => 'Employees feedback']);
    }
}
