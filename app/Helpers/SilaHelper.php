<?php

namespace App\Helpers;

use Silamoney\Client\Api\SilaApi;
use Silamoney\Client\Domain\{BalanceEnvironments,Environments};

class SilaHelper
{
    private $appHandle;
    private $privateKey;
    public function __construct()
    {
        // Load your credentials
        $this->appHandle = 'payzz_handle';
        $this->privateKey = '84cdca2fe94731319d73981c12c58b8d4eb5033ec3445ab2352f6e1cc08cb7ab';
    }
    

    public static function client(){
        // Create your client

        // From predefined environments
        $client = SilaApi::fromEnvironment(Environments::SANDBOX(), BalanceEnvironments::SANDBOX(), $this->appHandle, $this->privateKey);

        // From custom URL
        //$client = new SilaApi('your sila endpoint url', 'your sila balance endpoint url', $this->appHandle, $this->privateKey);

        // From default sandbox environments
        $client = SilaApi::fromDefault($this->appHandle, $this->privateKey);
    }
}