<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function dashboard()
    {
        $profile = UserProfile::where('user_id', auth()->user()->id)->first();
     
        if (!isset($profile)) {
            return redirect()->route('users.submitProfile');
        }
        return view('dashboard');
    }
}
