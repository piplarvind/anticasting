<?php

namespace Piplmodules\Earnings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\UserPaymentTransaction;

use Response;
use Auth;
use Validator;

class EarningApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Transactionhistory API Controller
      |--------------------------------------------------------------------------
      |
     */


    /**
     * @param
     * @return
     */
    public function listEarnings(Request $request) {
        $search_date = $request->search_date;
        
        $transfer_histories = UserPaymentTransaction::orderBy('id', 'desc')
        ->where(function($query) use ($search_date){
            if($search_date != null){
                $dates = explode('-', $search_date);
                $query->where('created_at','>=', date("Y-m-d", strtotime($dates[0])))->where('created_at','<=', date("Y-m-d", strtotime($dates[1])));
            }
        
        })->paginate($request->get('paginate'));

            

        $transfer_histories->appends($request->except('page'));
        return $transfer_histories;
    }

    public function getTransactionhistory($id){
        $transfer_history = UserPaymentTransaction::where('id', $id)->first();
        return $transfer_history;
    }
}
