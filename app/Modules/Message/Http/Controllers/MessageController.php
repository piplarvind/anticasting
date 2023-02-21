<?php

namespace App\Modules\Message\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Message\Models\{MessageReply,Message};


class MessageController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Message::index");
    }
    public function create()
    {
       
        return view("Message::create-edit");
    }
    public function store(Request $request)
    {
        $userid = auth()->user()->id;
        $message = new Message();
        if(auth()->check()){

             $message->message = $request->message_text;
             $message->status = $request->status ? 1 : 0;
             $message->save();
            return redirect()->back()->with('message','Message successfully saved.');
         
        }
        else{
            return redirect()->route('users.login');
        }
      
        return view("Message::create-edit");
    }
}
