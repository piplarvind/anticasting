<?php

namespace Piplmodules\Sendinglimits\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class SendingLimitAttribute extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sending_limit_attributes';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
