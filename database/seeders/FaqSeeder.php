<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::create(['question' => 'I want to Start a Commission'    ]);
        Faq::create(['question' => 'What are the Services that G-PROP provides?']);
        Faq::create(['question' => 'How is the commission calculated?']);
        Faq::create(['question' => 'Can I modify my commission after placing it?']);
        Faq::create(['question' => 'What payment methods do you accepts?']);

    }
}