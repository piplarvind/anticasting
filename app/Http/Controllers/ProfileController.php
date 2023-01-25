<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ProfileController extends Controller
{
    //
     public function submitProfile(){
       // dd("Mahesh");
        return view('submit_profile');
     }
}
