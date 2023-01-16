<?php

namespace Piplmodules\Earnings\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Earnings\Controllers\EarningApiController as API;



class EarningController extends EarningApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Earning Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles Users for the application.
      |
     */
    public function __construct() {
        $this->api = new API;
    }

    /**
     * @param
     * @return
     */
    public function index(Request $request) {
        $request->request->add(['paginate' => 20]);
        $transfer_histories = $this->api->listEarnings($request);
        //dd($transfer_histories->total());
        return view('Earnings::earnings.index', compact('transfer_histories'));
    }

    public function earningDetails($id)
    {
        $transaction_details = $this->api->getTransactionhistory($id);
        $transaction_response = json_decode($transaction_details->transaction_response);
        return view('Earnings::earnings.detail', compact('transaction_details', 'transaction_response'));
    }
    
}
