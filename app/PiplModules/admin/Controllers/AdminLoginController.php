<?php

namespace App\PiplModules\admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * Class AdminLoginController
 * @package App\PiplModules\admin\Controllers
 */
class AdminLoginController extends Controller
{

    /**
     * @description This function is used to show the login window for admin.
     * @return Response
     */
    public function __construct()
    {
        \App::setLocale('en');
    }

    /**
     * @description This function is used to view admin login page
     * @return \Illuminate\View\View
     */
    public function showLogin(Request $request)
    {
        //$request->session()->flush();
        return view('admin::login');
    }

}