<?php

namespace App\Modules\Actors\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, State, UserProfile};
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
            ->FilterAge()
            ->FilterHeight()
            ->FilterEthnicty()
            ->FilterGender()
            ->paginate(6);

        // dd($actors);
        $state = State::all();
        return view('Actors::index', compact('actors', 'state'));
    }
    public function actorDetail($id)
    {
      
        $actor = UserProfile::with('profileImage')->where('id', $id)->first();
        return view('Actors::detail', compact(var_name: 'actor'))->render();
    }
}
