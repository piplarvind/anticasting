<?php
namespace Piplmodules\Faq\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //1st
        \DB::table('faq')->insert([
            'question' =>'What is Lorem Ipsum?',
            'answer' =>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);

        \DB::table('faq')->insert([
            'question' =>'Why do we use it?',
            'answer' =>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.',
            'status' => 1,
            'order' => 2,
            'created_at' => Carbon::now()
        ]);


    }
}
