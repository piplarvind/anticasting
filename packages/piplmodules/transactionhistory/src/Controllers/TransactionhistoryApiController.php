<?php

namespace Piplmodules\Transactionhistory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\UserPaymentTransaction;

use Response;
use Auth;
use Validator;

class TransactionhistoryApiController extends Controller {
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
    public function listTransactionhistory(Request $request) {
        $search_date = $request->search_date;
        
        $transfer_histories = UserPaymentTransaction::orderBy('id', 'desc')
        ->where(function($query) use ($search_date){
            if($search_date != null){
                $dates = explode('-', $search_date);
                $query->whereDate('created_at','>=', date("Y-m-d", strtotime($dates[0])))->whereDate('created_at','<=', date("Y-m-d", strtotime($dates[1])));
            }
        
        })->paginate($request->get('paginate'));

            

        $transfer_histories->appends($request->except('page'));
        return $transfer_histories;
    }

    public function getTransactionhistory($id){
        $transfer_history = UserPaymentTransaction::where('id', $id)->first();
        return $transfer_history;
    }

    public function TransactionHistoryExportReport($date = [])
    {
        $query = UserPaymentTransaction::query();
        $reports = $query->where(function($query) use($date){  
            
            if($date[0] !=""){          
                $query->whereDate('created_at',">=",date("Y-m-d", strtotime($date[0])))->whereDate('created_at',"<=",date("Y-m-d", strtotime($date[1])));
            }
        })->orderBy('id', 'DESC')->get();
        
        return $reports;
    }
}
