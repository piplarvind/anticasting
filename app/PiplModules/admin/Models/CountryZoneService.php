<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryZoneService
 * @package App\PiplModules\admin\Models
 */
class CountryZoneService extends Model
{
    protected $fillable = ['country_id','zone_id','service_id','fixed_fees','ride_starting_fees','ride_driving_rate',
        'pre_ride_driving_fees',' pre_ride_waiting_fees','ride_waiting_rate','max_search_time','range_for_finding_taxi','no_of_rejection','taxi_distance','cancellation_fees','min_charge','accepting_limit','driver_pickup_waiting_time','passenger_pickup_waiting_time','no_show_fees_for_passenger','no_show_fees_for_driver','driver_no_show_suspension_time','passenger_no_show_suspension_time','status'];

    /**
     * @description This function is used to get service information by using belongsTo relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceMainInformation()
    {
        return $this->belongsTo('App\PiplModules\service\Models\Service','service_id','id');
    }
}
