<?php

namespace App\Modules\Actors\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Modules\Actors\Models\{Bucket,BucketMembers};
class BucketController extends Controller
{
    //
    public function store(Request $request){
  
      
      $bucket = new Bucket();
      $bucket->bucket_name=$request->bucket_name;
      $bucket->status = $request->status==true ? 1 : 0;
      $bucket->save();
      $users_id = explode(',',$request->user_id);
       foreach($users_id as $key=>$user_id){
          $bucket_members = new BucketMembers();
          $bucket_members->user_id = $user_id;
          $bucket_members->bucket_id = $bucket->id;
          $bucket_members->status =  $request->status == true ? 1 : 0;
          $bucket_members->save();
        }
    
      return redirect()->back()->with('success','Your Bucket list saved.');
    }
}
