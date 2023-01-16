<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;
use App\Models\UserInformation;
use Auth;
use App\Models\UserPaymentTransaction;
use App\Models\UserSubscriptionAttr;
use Piplmodules\Notifications\Models\Notification;

class SendToCountryComposer {

    private $session_user;

    /**
     * Create a new profile composer.
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    

    public function sendCountryList(View $view) {

        $receiving_countries = ReceivingCountry::where(['status'=>1])->get();

        if(!empty(Auth::user())){
            $user_id = Auth::user()->id;
            $selected_send_country = UserInformation::where(['user_informations.id'=> $user_id])->leftJoin('receiving_countries',function($join) {
                $join->on('receiving_countries.country_iso_code', '=', 'user_informations.send_money_to');
            })->first();

            $sharedSendingLimit = UserSubscriptionAttr::where(['user_id' => $user_id])->orderBy('id', 'DESC')->first();
            $today = date('Y-m-d');
            $sharedOneDayTotalAmountSent= UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '=', $today)->groupBy("user_id")->sum('sent_amount');

            /*
            * Get unread admin notifications
            */
            $unreadNotifications = Notification::where('status', 0)->orderBy('id', 'DESC')->take(10)->get();


        }else{
            $selected_send_country = null;
            $sharedSendingLimit = 2999;
            $sharedOneDayTotalAmountSent = 0;
            $unreadNotifications = 0;
        }
        
        $view->with(['header_receiving_countries'=> $receiving_countries, 'selected_send_country'=>$selected_send_country,'sharedSendingLimit'=> $sharedSendingLimit, 'sharedOneDayTotalAmountSent'=>$sharedOneDayTotalAmountSent, 'unreadNotifications' => $unreadNotifications]);
    }



}
