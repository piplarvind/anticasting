<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
class ViewProfileController extends Controller
{
    //
    public function profileDetails()
    {
        $user_id = auth()->user()->id;
        $item = User::where('id', $user_id)
            ->with('profile')
            ->with('introVideo')
            ->with('images')
            ->first();
    
        return view('view-profile-details',compact('item'));
    }
}
