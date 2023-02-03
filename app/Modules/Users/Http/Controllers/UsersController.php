<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};

class UsersController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function manageUser(){

        $user = User::FilterName()->FilterStatus()->paginate(10);
        return view('Users::users.manage-user-index',compact('user'));

    }
    public function editUser($id){
     
        $user = User::where('id',$id)->first();
        return view('Users::users.manage-user-edit',compact('user'));
    }
    public function UpdateUserStore(Request $request,$id){
           
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        $user->status = $request->status==1 ? 1 : 0;
        $user->save();
        return redirect()->route('admin.manageuser');
    }
}
