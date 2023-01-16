<?php

namespace Piplmodules\Sendinglimits\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use Piplmodules\Sendinglimits\Models\SendingLimitAttribute;

use Response;
use Auth;
use Validator;

class SendinglimitsApiController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Sendinglimits API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     *
     *
     * @param
     * @return
     */


    public function updateValidation($request, $old_name = "")
    {
        $rules['name'] = 'required';
        // $rules['one_day_price'] = 'required';
        // $rules['thirty_day_price'] = 'required';
        // $rules['half_yearly_price'] = 'required';
        $rules['information_needed'] = 'required';

        return \Validator::make($request->all(), $rules);
    }

    /**
     * @param
     * @return
     */
    public function listSendinglimits(Request $request)
    {
        $sendingLimites = SendingLimit::FilterName()
            ->FilterStatus()
            ->orderBy('order', 'asc')
            ->paginate($request->get('paginate'));
        $sendingLimites->appends($request->except('page'));
        return $sendingLimites;
    }

    /**
     * @param
     * @return
     */
    public function storeSendinglimits(Request $request)
    {
        $sLimit = new SendingLimit();

        $author = auth()->user()->id;
        $sLimit->name = $request->name;
        // $sLimit->one_day_price = $request->one_day_price;
        // $sLimit->thirty_day_price = $request->thirty_day_price;
        // $sLimit->half_yearly_price = $request->half_yearly_price;
        $sLimit->information_needed = $request->information_needed;
        $sLimit->status = false;
        if ($request->status) {
            $sLimit->status = true;
        }
        $sLimit->save();

        $request->request->add(['one_day_price' => 0]);
        $request->request->add(['thirty_day_price' => 0]);
        $request->request->add(['half_yearly_price' => 0]);

        $this->storeSendinglimitAttr($request, $sLimit->id);

        $response = ['message' => trans('Sending limmit created successfull, please update attribute value.')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateSendinglimits(Request $request, $id)
    {
        $sLimit = SendingLimit::find($id);

        $sLimit->name = $request->name;
        // $sLimit->one_day_price = $request->one_day_price;
        // $sLimit->thirty_day_price = $request->thirty_day_price;
        // $sLimit->half_yearly_price = $request->half_yearly_price;
        $sLimit->information_needed = $request->information_needed;
        $sLimit->status = false;
        if ($request->status) {
            $sLimit->status = true;
        }
        $sLimit->save();

        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }

    /**
     * @param
     * @return
     */
    public function listSendinglimitAttributes($id)
    {
        $sendingLimites = SendingLimitAttribute::where('sending_limit_id', $id)
            ->orderBy('id', 'asc')
            ->get();
        return $sendingLimites;
    }
    /**
     * @param
     * @return
     */
    public function storeSendinglimitAttr(Request $request, $id)
    {
        $sLimit = new SendingLimitAttribute();

        $sLimit->sending_limit_id = $id;
        $sLimit->one_day_price = $request->one_day_price;
        $sLimit->thirty_day_price = $request->thirty_day_price;
        $sLimit->half_yearly_price = $request->half_yearly_price;
        // $sLimit->information_needed = $request->information_needed;
        $sLimit->status = true;
        $sLimit->save();

        $response = ['message' => trans('Core::operations.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateSendinglimitAttr(Request $request, $id, $sId)
    {
        $sLimit = SendingLimitAttribute::find($sId);

        $sLimit->one_day_price = $request->one_day_price;
        $sLimit->thirty_day_price = $request->thirty_day_price;
        $sLimit->half_yearly_price = $request->half_yearly_price;
        // $sLimit->information_needed = $request->information_needed;
        $sLimit->status = true;
        $sLimit->save();

        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }
}
