<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Piplmodules\Transactionhistory\Controllers\TransactionhistoryApiController as API;

class TransactionHisoryExport implements FromView
{

    public function __construct($request) {
        $this->api = new API;
        $this->request = $request;
    }

    public function view(): View
    {
        $date = "";
        $is_date_interval = true;
        $date = explode("-",$this->request->search_date);
        
        $reports = $this->api->TransactionHistoryExportReport($date, $is_date_interval);
        $reports = json_encode($reports);
        $reports = json_decode($reports);
        //var_dump($reports);
        //dd($reports);
        $arrReport = [];
        if (is_array($reports)) {
            foreach ($reports as $report) {
                $tmpReport = [];
                $tmpReport['transaction_id'] = $report->transaction_id;
                $tmpReport['Delivery_Method'] = json_decode($report->transaction_response)->payer->service->name;
                $tmpReport['Sender_Name'] =  json_decode($report->transaction_response)->sender->firstname . ' ' . json_decode($report->transaction_response)->sender->lastname;
                $tmpReport['Send_Amount'] = json_decode($report->transaction_response)->source->amount . ' ' . json_decode($report->transaction_response)->source->currency ;
                $tmpReport['Recipient_Name'] =  json_decode($report->transaction_response)->beneficiary->firstname . ' ' . json_decode($report->transaction_response)->beneficiary->lastname;
                $tmpReport['Recipient_Amount'] = json_decode($report->transaction_response)->destination->amount . ' ' . json_decode($report->transaction_response)->destination->currency;
                $tmpReport['Transfer_Status'] = ($report->status)?$report->status:"-";
                $tmpReport['Reason'] = ($report->purpose_of_remittance)?str_replace('-'," ",$report->purpose_of_remittance):"-";
                $tmpReport['date'] = $report->created_at;
                array_push($arrReport, $tmpReport);
            }
        }
        //dd($arrReport);
        return view('transaction-history-report', [
            'arrReport' => $arrReport
        ]);
    }
}
