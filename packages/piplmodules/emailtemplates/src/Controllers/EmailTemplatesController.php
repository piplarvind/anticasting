<?php

namespace Piplmodules\Emailtemplates\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Emailtemplates\Controllers\EmailTemplatesApiController as API;
use Piplmodules\Emailtemplates\Models\EmailTemplate;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmailTemplatesController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | piplmodules Reports Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles Reports for the application.
      |
     */

    public function __construct() {
           $this->api = new API;
    }

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function index(Request $request) {
        $items = EmailTemplate::all();
        return view('Emailtemplates::templates.index', compact('items'));
    }

    public function create()
    {
        return view('Emailtemplates::templates.create-edit');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function store(Request $request)
    {

        $store = $this->api->storeTemplate($request);

        if($store == "Duplicate Entry Present")
            return back();


        $store = $store->getData();

        if(isset($store->errors)){
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-success', $store->message);

        if($request->back){
            return back();
        }
        return redirect()->route('admin.emailtemplates');
    }

    public function edit($id) {
        $item = EmailTemplate::findOrFail($id);
        $trans = EmailTemplateTrans::where('etemplate_id', $id)->first();
        return view('Emailtemplates::templates.create-edit', compact('item','trans'));
    }

    public function update(Request $request, $id)
    {
        $update = $this->api->updateEmailTemplate($request, $id);

        if($update == "Duplicate Entry Present")
            return back();
        $update = $update->getData();

        if(isset($update->errors)){
            return back()->withInput()->withErrors($update->errors);
        }
        request()->session()->flash('alert-success', $update->message);

        if($request->back){
            return back();
        }
        return redirect()->route('admin.emailtemplates');
    }

}
