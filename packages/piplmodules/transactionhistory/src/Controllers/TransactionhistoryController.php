<?php

namespace Piplmodules\Transactionhistory\Controllers;

use App\Models\UserPaymentTransaction;
use Illuminate\Http\Request;
use Piplmodules\Transactionhistory\Controllers\TransactionhistoryApiController as API;

use Barryvdh\DomPDF\Facade as PDF;

class TransactionhistoryController extends TransactionhistoryApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Transactionhistory Controller
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
        $transfer_histories = $this->api->listTransactionhistory($request);
        return view('Transactionhistory::transactionhistory.index', compact('transfer_histories'));
    }

    public function trasnactionDetails($id)
    {
        $transaction_details = $this->api->getTransactionhistory($id);
        $transaction_response = json_decode($transaction_details->transaction_response);
        return view('Transactionhistory::transactionhistory.detail', compact('transaction_details', 'transaction_response'));
    }

    /**
     * Generate/print PDF
     */
    public function generateReceiptPdf($transaction_id)
    {
        $receipt_details = UserPaymentTransaction::where(['transaction_id' => $transaction_id])->first();
        $transaction_response = json_decode($receipt_details->transaction_response);

        if (isset($receipt_details) && isset($transaction_response)) {
            $items = [];
            //            return view('Wallets::wallets.pdf-view', compact('items', 'start_date', 'end_date'));
            $items['receipt_details'] = $receipt_details;
            $items['transaction_response'] = $transaction_response;
            // dd($items);
            // share data to view
            view()->share('items', $items);
            $pdf = PDF::loadView('Transactionhistory::transactionhistory.receipt-pdf-details', $items);
            // return view('payments.receipt-pdf-details', compact('items'));

            // download PDF file with download method
            return $pdf->download('payzz-receipt-details-' . time() . '.pdf');
        } else {
            return redirect()->route('admin.transactions.history.detail', [$transaction_id])
                ->with("alert-danger", "Something went wrong!!!");
        }
    }

}
