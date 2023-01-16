<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}
