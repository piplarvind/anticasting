<?php

namespace App\Modules\Message\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Message\Models\{Message};

class MessageReply extends Model
{
    use HasFactory;
    protected $table = "message_reply";
    protected $fillable = ["reply_msg","msg_id","user_id"];

    // public function message(){

    //     return $this->belongsTo(Message::class, 'msg_id', 'id')->select(['message' => 'message']);
    // }
}
