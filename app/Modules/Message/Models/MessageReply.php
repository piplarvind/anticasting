<?php

namespace App\Modules\Message\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    use HasFactory;
    protected $table = "message_reply";
    protected $fillable = ["reply_msg","msg_id","user_id"];
}
