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
        Faq::create(['question' => 'What is Laravel?'    ]);
        Faq::create(['question' => 'How to install Laravel?']);
    }
}