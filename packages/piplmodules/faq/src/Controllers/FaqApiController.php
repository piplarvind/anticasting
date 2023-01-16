<?php

namespace Piplmodules\Faq\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Piplmodules\Faq\Models\Faq;

use Response;
use Auth;
use Validator;

class FaqApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Faq API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     *
     *
     * @param
     * @return
     */


    public function updateValidation($request, $old_name="")
    {
        $rules['question'] = 'required';
        $rules['answer'] = 'required';
        $rules['order'] = 'required';

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listFaq(Request $request) {
        $payments = Faq::FilterQuestion()
            ->FilterStatus()
            ->orderBy('order', 'asc')
            ->paginate($request->get('paginate'));
        $payments->appends($request->except('page'));
        return $payments;
    }

    /**
     * @param
     * @return
     */
    public function storeFaq(Request $request)
    {
        $faq = new Faq();

        $author = auth()->user()->id;
        $faq->question = $request->question;
        $faq->status = false;
        if ($request->status) {
            $faq->status = true;
        }

        $faq->answer = $request->answer;
        $faq->order = $request->order;
        $faq->save();

        $response = ['message' => trans('Core::operations.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateFaq(Request $request, $id)
    {
        $faq = Faq::find($id);

        $faq->question = $request->question;
        $faq->status = false;
        if ($request->status) {
            $faq->status = true;
        }
        $faq->answer = $request->answer;
        $faq->order = $request->order;
        $faq->save();

        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }


}
