<?php
namespace Piplmodules\Notifications\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Permissions\Models\Permission;
use Piplmodules\Notifications\Controllers\NotificationsApiController as API;
use Piplmodules\Notifications\Models\Notification;
use Piplmodules\Notifications\Models\NotificationTrans;

class NotificationsController extends NotificationsApiController
{

    /*
   |--------------------------------------------------------------------------
   | Piplmodules Notifications Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles Notifications for the application.
   |
   */
    public function __construct()
    {
        $this->api = new API;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function index(Request $request)
    {
        $request->request->add(['paginate' => 20]);
        $items = $this->api->listItems($request);
//        dd($items);
        return view('Notifications::notifications.index', compact('items'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function create()
    {
        $permissions = Permission::where('active','1')
            ->whereNotIn('slug', ['settings', 'admin-users', 'notifications', 'emailtemplates'])
            ->orderBy('id','ASC')
            ->get();
        return view('Notifications::notifications.create-edit', compact('permissions'));
    }


    /**
     *
     *
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:notifications_trans',
                'permissions' => 'required',
            ],
            [
                'name.required' => 'Please enter notification name',
                'permissions.required' => 'Please select at least one permission'
            ]
        );
        $store = $this->api->storeNotification($request);

        $store = $store->getData();

        if(isset($store->errors)){
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $store->message);

        if($request->back){
            return back();
        }
        return redirect()->route('admin.notifications');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = Notification::findOrFail($id);
//        $trans = NotificationTrans::where('notification_id', $id)->get()->keyBy('lang')->toArray();
        $arr_notification_permission = [];
        $user_permission = $item->hasPermission;
        foreach ($user_permission as $key => $value) {
            $arr_notification_permission[] = $user_permission{$key}->getPermission->id;
        }
//        dd($arr_notification_permission);
        $permissions = Permission::where('active','1')
            ->whereNotIn('slug', ['settings', 'admin-users', 'notifications', 'emailtemplates'])
            ->orderBy('id','ASC')
            ->get();
//        dd($permissions);
        return view('Notifications::notifications.create-edit', compact('item','permissions','arr_notification_permission'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function update(Request $request, $id)
    {
        $notificationTrans = NotificationTrans::where('notification_id', $id)->first();
        $this->validate($request,
            [
                'name' => 'required|unique:notifications_trans,name,'.$notificationTrans->id,
                'permissions' => 'required',
            ],
            [
                'name.required' => 'Please enter notification name',
                'permissions.required' => 'Please select at least one permission'
            ]
        );

        $update = $this->api->updateNotification($request, $id);

        $update = $update->getData();

        /*if(isset($update->errors)){
            return back()->withInput()->withErrors($update->errors);
        }*/

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $update->message);

        if($request->back){
            return back();
        }
        return redirect()->route('admin.notifications');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function confirmDelete($id)
    {
        $item = Notification::findOrFail($id);
        return view('Notifications::notifications.confirm-delete', compact('item'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if($request->ids){
            $items = Notification::whereIn('id', $request->ids)->get();
            if($items->count()){
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if($request->operation && $request->operation === 'activate'){
                        $item->active = true;
                        $item->save();
                        \Session::flash('message', trans('Core::operations.activated_successfully'));
                    }elseif($request->operation && $request->operation === 'deactivate'){
                        $item->active = false;
                        $item->save();
                        \Session::flash('message', trans('Core::operations.deactivated_successfully'));
                    }

                }
            }

            \Session::flash('alert-class', 'alert-success');

        }else{
            \Session::flash('alert-class', 'alert-warning');
            \Session::flash('message', trans('Core::operations.nothing_selected'));
        }
        return back();
    }

    //change notification status
    public function changeStatus(Request $request)
    {
        if ($request->id != "") {
            $notification = Notification::find($request->id);
            if (isset($notification)) {
                $notification->status = $request->status;
                $notification->save();
                echo json_encode(array("error" => "0"));
            } else {
                echo json_encode(array("error" => "1"));
            }
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1"));
        }
    }
}
