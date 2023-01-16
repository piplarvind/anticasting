<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GeneralHelper;
use Silamoney\Client\Domain\PlaidTokenType;
use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\{BalanceEnvironments,Environments};


class SilaController extends Controller
{
    private $appHandle;
    private $privateKey;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

        // Load your credentials
        $this->appHandle = 'payzz_handle';
        $this->privateKey = '84cdca2fe94731319d73981c12c58b8d4eb5033ec3445ab2352f6e1cc08cb7ab';
    }

    public function linkAccount(){
        // Create your client

        // From predefined environments
        $client = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $this->appHandle, $this->privateKey);

        // From custom URL
        //$client = new SilaApi('your sila endpoint url', 'your sila balance endpoint url', $this->appHandle, $this->privateKey);

        // From default sandbox environments
        $client = SilaApi::fromDefault($this->appHandle, $this->privateKey);


        // Plaid token flow
        // Load your information
        $userHandle = 'user.silamoney.eth';
        $accountName = 'default'; // Defaults to 'default'
        $plaidToken = 'processor-sandbox-81d69c0d-8729-4d77-a819-61b78d689727'; // A temporary token returned from the Plaid Link plugin. See above for testing.
        $accountId = 'R6oGvAEjNAuLPplEKQRLCe3n76bNXRHRGmL47'; // Recommended but not required. See note above.
        $userPrivateKey = 'arvind2484'; // The private key used to register the specified user
        $plaidTokenType = 'PROCESSOR';//PlaidTokenType::Processor(); // Optional.  PROCESSOR

        // Call the api
        $response = $client->linkAccount($userHandle, $userPrivateKey, $plaidToken, $accountName, $accountId, $plaidTokenType);

        dd($response);
    }
}
