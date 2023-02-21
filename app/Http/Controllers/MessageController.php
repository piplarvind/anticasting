<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Message\Models\{MessageReply,Message};

class MessageController extends Controller
{
    //
    public function storeMessage(Request $request)
     {      
           $userid = auth()->user()->id;
           $message_reply = new MessageReply();
          if(auth()->check()){

             $message_reply->reply_msg = $request->reply_msg;
             $message_reply->user_id=$userid;
             $message_reply->save();
             return redirect()->back()->with('message','Message successfully saved.');
         
        }
        else{
            return redirect()->route('users.login');
        }
      
    }
    // public function showMessage(){
          
    //     $userid = auth()->user()->id;
    //     $message = MessageReply::where('user_id', $userid)->get();
      
    //     return view('submit-profile.left-section',compact('message'));
    // }
}
