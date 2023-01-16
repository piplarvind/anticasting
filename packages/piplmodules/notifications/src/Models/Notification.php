<?php

namespace Piplmodules\Notifications\Models;

use App\Models\UserPaymentDetails;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Sender relation.
     */
    public function sender()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'from_id')
            ->select('id', 'first_name', 'last_name');
    }

    /**
     * Receiver relation.
     */
    public function receiver()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'to_id')
            ->select('id', 'first_name', 'last_name');
    }

    /**
     * Ride relation.
     */
    public function transaction()
    {
        return $this->belongsTo(UserPaymentDetails::class, 'transaction_id')
            ->select('*');
    }

}
