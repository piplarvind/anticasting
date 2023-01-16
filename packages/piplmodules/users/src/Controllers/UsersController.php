<?php

namespace Piplmodules\Users\Controllers;

use App\Models\UserInformation;
use Illuminate\Http\Request;
use Piplmodules\Users\Controllers\UsersApiController as API;
use Piplmodules\Users\Models\User;
use Piplmodules\Roles\Models\Role;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;

class UsersController extends UsersApiController {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Users Controller
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
        $roleId = 3;
        $request->request->add(['role_id' =>     $roleId, 'paginate' => 20]);
        $items = $this->api->listUsers($request);
        return view('Users::users.index', compact('items'));
    }
    /**
     * @param
     * @return
     */
    public function create(Request $request) {
        return view('Users::users.create-edit', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function store(Request $request) {
        $roleId = 3;

        $request->request->add(['role_id' => $roleId]);
        $store = $this->api->storeUser($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-success', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.customers');
    }

    /**
     * @param
     * @return
     */
    public function edit($id) {
        $item = User::findOrFail($id);
        //dd($item);
//        $roles = Role::where('id' , '!=', 5)->where('id' , '!=', 3)->get();
        $roles = Role::where('id' , '!=', 5)->get();

        $edit = 1;

        $receiving_countries = ReceivingCountry::where(['status' => 1])->get();

        return view('Users::users.create-edit', compact('item', 'edit','roles','receiving_countries'));
    }

    /**
     * @param
     * @return
     */
    public function viewUser($id) {
        $item = User::findOrFail($id);
        $user_basic_info = UserInformation::where(['user_id' => $id])->first();
        return view('Users::users.view', compact('item', 'user_basic_info'));
    }

    /**
     * @param
     * @return
     */
    public function update(Request $request,$id)
    {
        $update = $this->api->updateUser($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.customers');
    }

    /**
     * @param
     * @return
     */
    public function editAddress(Request $request,$id)
    {
        $update = $this->api->updateUserAddress($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.customers');
    }

    /**
     * @param
     * @return
     */
    public function editSendCountry(Request $request,$id)
    {
        $update = $this->api->updateSendCountry($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.customers');
    }


    /**
     * Delete single user
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (isset($user) && $user->id != 1) {
            $user->delete();
            request()->session()->flash('alert-success', 'User deleted successfully.');
        } else {
            request()->session()->flash('alert-danger', 'No record found for selected item.');
        }
        return redirect()->route('admin.customers');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($role, $id)
    {
        $item = User::findOrFail($id);
        return view('Users::users.confirm-delete', compact('item'));
    }

    /**
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = User::whereIn('id', $request->ids)->get();
//            dd($items);
            if ($items->count()) {
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if ($request->operation && $request->operation === 'activate') {
                        $item->account_status = '1';
//                        $item->updated_by = Auth::user()->id;
                        $item->save();
                        request()->session()->flash('alert-success', trans('Core::operations.activated_successfully'));
                    } elseif ($request->operation && $request->operation === 'deactivate') {
                        $item->account_status = '0';
//                        $item->updated_by = Auth::user()->id;
                        $item->save();
                        request()->session()->flash('alert-success', trans('Core::operations.deactivated_successfully'));
                    }
                }
            }

        } else {
            request()->session()->flash('alert-danger', trans('Core::operations.nothing_selected'));
        }
        return back();
    }

    //change member status
    public function changeStatus(Request $request)
    {
        if ($request->user_id != "") {
            $user = User::find($request->user_id);
            if (isset($user) && $user->id != 1) {
                $user->account_status = $request->user_status;
                $user->save();
                echo json_encode(array("error" => "0"));
            } else {
                echo json_encode(array("error" => "1"));
            }
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1"));
        }
    }

    public function exportUserData(){
        $file_name = 'user_data_'.strtotime(date('Y-m-d H:i:s')).'.xlsx';
        $file_url = storage_path('app') .'/' . $file_name;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$file_name."\"");
        readfile($file_url);
        exit;
    }

    /**
     * @param
     * @return
     */
    public function recipients(Request $request, $user_id) {
        
        $items = $this->api->listRecipients($request, $user_id);
        return view('Users::users.recipients.recipients', compact('items'));
    }

    /*
    * View the user recipient detail
    */
    public function viewRecipient(Request $request, $user_id, $id){
        
        $item = $this->api->recipientDetails($request, $id);
        return view('Users::users.recipients.view', compact('item'));
    }

    /*
    * Edit the user recipient detail
    */
    public function editRecipient(Request $request, $user_id, $id){
        
        $item = $this->api->recipientDetails($request, $id);
        return view('Users::users.recipients.edit', compact('item'));
    }

    /*
    * Update the user recipient detail
    */
    public function updateRecipient(Request $request, $user_id, $id){
        
        $update = $this->api->updateRecipient($request, $id);
        $update = $update->getData();

        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-success', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.customers.recipients',[$user_id]);
    }

    /*
    * Delete the user recipient detail
    */
    public function deleteRecipient(Request $request, $user_id, $id){
        
        $item = $this->api->recipientDelete($id);
        if($item){
            request()->session()->flash('alert-success', 'Record deleted successfully');
        }else{
            request()->session()->flash('alert-danger', 'Something went wrong');
        }
        
        return redirect()->route('admin.customers.recipients',[$user_id]);
    }
}
