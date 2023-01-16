<?php 
namespace Piplmodules\Core\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

 	/*
    |--------------------------------------------------------------------------
    | Piplmodules Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Products for the application.
    |
    */

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function index()
    {
        return view('Core::dashboard.index');
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getAdminLogout()
    {
        auth()->logout();
        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', 'This user has been logged out');
        return redirect()->route('admin.login');
    }

}