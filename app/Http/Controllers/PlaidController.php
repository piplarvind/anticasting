<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use App\Models\PlaidInstitution;
use App\Http\Requests;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\PlaidHelper;
use TomorrowIdeas\Plaid\Plaid;


class PlaidController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function plaid()
    {
        $user_id = Auth::user()->id;  
        
    }

   public function getBalance(){

        $processor_token = PlaidHelper::createProcessorToken();
        dd($processor_token);
        $access_token = PlaidHelper::getAccessToken();
        $plaid = new Plaid(
            config("app.PLAID_CLIENT_ID"),
            config("app.PLAID_CLIENT_SECRET"),
            config("app.PLAID_ENVIRONMENT")
        );

        $post_data = [
            "client_id"=> config("app.PLAID_CLIENT_ID"),
            "secret"=> config("app.PLAID_CLIENT_SECRET"),
            "access_token"=> $access_token
        ];
        $curl = curl_init();

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $request_type = 'POST';

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.plaid.com/accounts/balance/get',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_CUSTOMREQUEST => $request_type,
            CURLOPT_HTTPHEADER => $headers
        ));

        $return = json_decode(curl_exec($curl));
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }
        curl_close($curl);
        dd($return);
   }
   
   
   public function getInstitutions(){
    $access_token = PlaidHelper::getProcessorAccessTocken();
    dd( $access_token);
    $plaid = new Plaid(
        config("app.PLAID_CLIENT_ID"),
        config("app.PLAID_CLIENT_SECRET"),
        config("app.PLAID_ENVIRONMENT")
    );

    $post_data = [
        "client_id"=> config("app.PLAID_CLIENT_ID"),
        "secret"=> config("app.PLAID_CLIENT_SECRET"),
        "count"=>500,
	    "offset"=> 0,
        "country_codes"=> ['US']
    ];
    //dd($post_data);
    
    $curl = curl_init();

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $request_type = 'POST';

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.plaid.com/institutions/get',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_POSTFIELDS => json_encode($post_data),
        CURLOPT_CUSTOMREQUEST => $request_type,
        CURLOPT_HTTPHEADER => $headers
    ));

    $return = json_decode(curl_exec($curl));
    if (curl_errno($curl)) {
        echo 'Error:' . curl_error($curl);
    }
    curl_close($curl);
    //dd($return);
    return $return->institutions;
   }

   public function getInstitutionsAPI() {
       $banks = PlaidInstitution::take(5)->get();
       if($banks->count() < 0) {
            $banks = $this->getInstitutions();

            foreach ($banks as $bank) {
                $bank_name = preg_split('/(?=[A-Z])/', $bank->name, -1, PREG_SPLIT_NO_EMPTY);
                $plaid_institution = new PlaidInstitution();
                $plaid_institution->country_codes = $bank->country_codes[0];
                $plaid_institution->institution_id = $bank->institution_id;
                $plaid_institution->name = $bank_name[0].' ' . $bank_name[1];
                $plaid_institution->routing_numbers = ($bank->routing_numbers)?$bank->routing_numbers[0]:null;
                $plaid_institution->save();
            }
        }
      
       $html_view = view("ajaxView.banks", compact('banks'))->render();
       return response()->json(['html'=>$html_view]);
   }
}
