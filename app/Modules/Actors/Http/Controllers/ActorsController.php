<?php

namespace App\Modules\Actors\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,State,UserProfile};
use DB;

class ActorsController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function listActors(Request $request)
    {
       
        
          $actors = UserProfile::with('profileImage')
             ->FilterAge()->FilterHeight()->paginate(10);
          
            $state = State::all();
            // if($request->ajax()){
            //   //  dd($request->data);

            //     $profile = DB::table('user_profiles')->whereIn('ethnicity',[$request->data])->get();
            //     dd($profile);
            //    }
        return view("Actors::index", compact('actors','state'));
    }

}
