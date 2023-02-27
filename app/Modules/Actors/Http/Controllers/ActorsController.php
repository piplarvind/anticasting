<?php

namespace App\Modules\Actors\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,State,UserProfile};
use App\Helpers\PaginateCollection;
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
    //    dd($request->all());
        
           $actors = UserProfile::with('profileImage')
             ->FilterAge()->FilterHeight()->FilterEthnicty()->FilterGender()->paginate(2);
         
          // dd($actors);
           $state = State::all();
        return view("Actors::index", compact('actors','state'));
    }

}