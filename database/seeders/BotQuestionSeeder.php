<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BotQuestion;

class BotQuestionSeeder extends Seeder
{
    public function run()
    {
        $main = BotQuestion::create([
            'question_text' => 'What would you like to know today?',
            'type' => 'select',
            'options' => [
                ['label' => 'About Leolus Energy', 'value' => 'about'],
                ['label' => 'Our Products', 'value' => 'products'],
                ['label' => 'Why Choose Us', 'value' => 'why'],
                ['label' => 'Contact & Support', 'value' => 'contact']
            ]
        ]);

        BotQuestion::create([
            'question_text' => 'Can I have your name, please?',
            'parent_id' => $main->id,
            'type' => 'input'
        ]);
    }
}

