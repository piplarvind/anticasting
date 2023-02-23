<?php

namespace App\Modules\Actors\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;

class ActorsController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function listActors()
    {
        $actors = User::where('user_type', '0')
            ->with('images')
            ->FilterName()
            ->FilterStatus()
            ->paginate(10);
        // dd($actors);
        return view("Actors::index", compact('actors'));
    }

}
