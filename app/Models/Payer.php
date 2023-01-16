<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payer
 * @package App
 */
class Payer extends Model
{

    protected $table ="payers";

    protected $fillable = [
        'payer_id', 
        'payer_name',
        'payer_country',
        'payer_service', 
        'payer_currency', 
        'transaction_type',
        'min_amount',
        'max_amount',
        'precision', 
        'increment',
        'required_sender',
        'required_beneficiary',
        'credit_party_identifiers_accepted',
        'credit_party_information_credit_party_identifiers_accepted',
        'credit_party_verification_credit_party_identifiers_accepted',
        'credit_party_verification_required_receiving_entity_fields',
        'required_documents'];

    
}
