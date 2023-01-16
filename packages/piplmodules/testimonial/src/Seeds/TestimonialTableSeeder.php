<?php
namespace Piplmodules\Testimonial\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TestimonialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('testimonials')->insert([
            'client_name' =>'Eric Campos',
            'testimonial' =>'With this marvelous cast of characters and the comic brilliance of writer/director Greg Pritikin, nary a minute goes by that you\'re not slapping your knee with laughter',
            'rating' => 5,
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);

        \DB::table('testimonials')->insert([
            'client_name' =>'Maitland McDonagh',
            'testimonial' =>'It\'s repetitive and obvious but somehow endearing, like a truly ugly dog with sweet eyes.',
            'rating' => 5,
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);

        \DB::table('testimonials')->insert([
            'client_name' =>'V.A. Musetto',
            'testimonial' =>'What could have been a biting dark comedy is, instead, uninspired and generic. The contrived, everybody\'s-happy finale just makes things worse.',
            'rating' => 5,
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);

        \DB::table('testimonials')->insert([
            'client_name' =>'Compi24',
            'testimonial' =>'Adrien Brody and Milla Jovovich, "Dummy" is that special kind of indie comedy that knows how to perfectly balance its offbeat humor with just the right amount of dramatic intrigue.',
            'rating' => 5,
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);


    }
}
