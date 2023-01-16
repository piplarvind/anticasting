<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Piplmodules\Banners\Models\Banner;
use Piplmodules\Media\Models\Media;
use App\Models\Visitor;
use Piplmodules\Testimonial\Models\Testimonial;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        session('show_login_popup');
        $this->websiteVisitor();

        //$banners = Banner::where('active', 1)->get();
        //$galleries = Media::get();
        $testimonials = Testimonial::where('status', 1)->get();
        return view('home', compact('testimonials'));
    }

    public function reviews(){
        $testimonials = Testimonial::where('status', 1)->get();
        return view('testimonial', compact('testimonials'));
    }

    private function websiteVisitor(){
        $date = new \DateTime;

        $today = date("Y-m-d");

        $check_if_exists = Visitor::where(['ip'=> $_SERVER['REMOTE_ADDR'], 'visit_date' => $today])->first();

        if(!$check_if_exists)
        {
            Visitor::insert(array('ip' => $_SERVER['REMOTE_ADDR'], 'hits' => '1', 'visit_date' => $date));
        }else{
            Visitor::where(['ip'=> $_SERVER['REMOTE_ADDR'], 'visit_date' => $today])->increment('hits');
        }
    }

    public function topicDetail($topic){
        $topics = EssayTopic::where(['status' => '1'])->get();
        $topic_info = EssayTopic::whereHas('trans',function($query) use($topic){
            $query->where(['slug' => $topic]);
        })->first();
        return view('topic-detail', compact('topic_info', 'topics'));
    }

    public function search(Request $request){
        $search_key = $request->search_key;
        $topics = EssayTopic::whereHas('trans',function($query) use($search_key){
            $query->where('name', 'like', '%'.$search_key.'%')->orWhere('description', 'like', '%'.$search_key.'%');
        })->get();

        return view('search-topics', compact('topics'));
    }
}
