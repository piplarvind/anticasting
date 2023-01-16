<?php

namespace Piplmodules\Users\Controllers;

use App\Models\UserPaymentTransaction;
use Illuminate\Http\Request;
use Piplmodules\Users\Controllers\AdminApiController as API;
use Piplmodules\Users\Models\User;
use Piplmodules\Roles\Models\Role;
use Piplmodules\Users\Models\PermissionUser;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use App\Helpers\GeneralHelper;

class AdminController extends AdminApiController
{
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Users Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles Users for the application.
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
        $roleId = 1;
        //            $request->request->add(['paginate' => 20]);
        $request->request->add(['role_id' => $roleId, 'paginate' => 20]);
        $items = $this->api->listUsers($request);
        return view('Users::users.admin-index', compact('items'));
    }

    public function dashboard()
    {
        $thunes_url = 'balances';
        $request_type = 'GET';
        $res = GeneralHelper::thunesAPI($thunes_url, $request_type);
        $res =  json_encode($res);
        $res =  json_decode($res, true);
        //dd($res[0]['available']);
        $thunes_balance = isset($res) ? number_format($res[0]['available'], 2) : 0.00 ;
        //$thunes_balance .=  ' '.is_array($res) ? $res[0]['currency'] : '';
        $sendingLimit = Sendinglimit::where('status', 1)
            ->first();
        $incomeOutcome = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(fees), 2)) as income"),
            DB::raw("(ROUND(SUM(sent_amount), 2)) as outcome"),
            'fees_currency',
            'currency'
        )->first();
        //get items
        $transactionitems = [];
        $transactionitems['received_months'] = DB::table('user_payment_transaction')->select(
            // DB::raw("(SUM(fees)) as income"),
            DB::raw("MONTHNAME(created_at) as month_name")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->pluck('month_name')
            ->toArray();
        $transactionitems['received'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(fees), 2)) as income"),
            DB::raw("MONTHNAME(created_at) as month_name")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->pluck('income')
            ->toArray();
        $transactionitems['sent_months'] = DB::table('user_payment_transaction')->select(
            // DB::raw("(SUM(sent_amount)) as outcome"),
            DB::raw("MONTHNAME(created_at) as month_name")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->pluck('month_name')
            ->toArray();
        $transactionitems['sent'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(sent_amount), 2)) as outcome"),
            DB::raw("MONTHNAME(created_at) as month_name")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->pluck('outcome')
            ->toArray();

        $transactionitems['FAMILY_SUPPORT'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(sent_amount), 2)) as amount")
        )
            ->where('purpose_of_remittance', 'FAMILY_SUPPORT')
            ->first();
        $transactionitems['EDUCATION'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(sent_amount), 2)) as amount")
        )
            ->where('purpose_of_remittance', 'EDUCATION')
            ->first();
        $transactionitems['TAX_PAYMENT'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(sent_amount), 2)) as amount")
        )
            ->where('purpose_of_remittance', 'TAX_PAYMENT')
            ->first();
        $transactionitems['OTHER'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(sent_amount), 2)) as amount")
        )
            ->where('purpose_of_remittance', 'OTHER')
            ->first();

        // dd(Carbon::now()->startOfWeek()->format('Y-m-d H:i'));
        //bar chart data
        //income
        $transactionitems['income_day'] = DB::table('user_payment_transaction')->select(
            DB::raw("DAYNAME(created_at) as day")
        )
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('day')
            ->get()
            ->pluck('day')
            ->toArray();
        $transactionitems['income'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(fees), 2)) as income"),
            DB::raw("DAYNAME(created_at) as day")
        )
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('day')
            ->get()
            ->pluck('income')
            ->toArray();

        //outcome
        $transactionitems['outcome_day'] = DB::table('user_payment_transaction')->select(
            DB::raw("DAYNAME(created_at) as day")
        )
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('day')
            ->get()
            ->pluck('day')
            ->toArray();
        $transactionitems['outcome'] = DB::table('user_payment_transaction')->select(
            DB::raw("(ROUND(SUM(sent_amount), 2)) as outcome"),
            DB::raw("DAYNAME(created_at) as day")
        )
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('day')
            ->get()
            ->pluck('outcome')
            ->toArray();

        $search_type = 'monthly';
        if (request()->search_type !== '' && request()->search_type !== null) {
            $search_type = request()->search_type;
        }
        // dd($search_type);
        $previousTransactions = DB::table('user_payment_transaction AS upt')->select(
            'upt.id',
            'upt.transaction_id',
            'upt.fees',
            'upt.sent_amount',
            'upt.fees_currency',
            'upt.currency',
            'upt.status',
            'users.name',
            'users.first_name',
            'users.last_name',
            'upt.created_at'
        )->where(function ($q) use ($search_type) {
            if ($search_type == 'weekly') {
                $q->whereBetween('upt.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } else if ($search_type == 'today') {
                $q->whereDate('upt.created_at', '=', date('Y-m-d'));
            } else {
                $q->whereMonth('upt.created_at', '=', date('m'));
            }
        })
            ->join('users', 'users.id', '=', 'upt.user_id')
            ->orderBy('upt.created_at','desc')
            ->get();

        //most transfer
        $mostTransactions = DB::table('user_payment_transaction AS upt')->select(
            DB::raw("(ROUND(SUM(upt.sent_amount), 2)) as amount"),
            'users.id',
            'users.name',
            'users.first_name',
            'users.last_name',
            'users.email',
            'upt.created_at'
        )
            ->orderBy('amount', 'desc')
            ->groupBy('upt.user_id')
            ->join('users', 'users.id', '=', 'upt.user_id')
            ->get();
        // dd($mostTransactions);
        // dd($incomeOutcome);

        
        return view('Users::users.admin-dashboard', compact('sendingLimit', 'incomeOutcome', 'transactionitems', 'previousTransactions', 'mostTransactions', 'thunes_balance'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function create(Request $request)
    {
        $roles = Role::where('id', '!=', 1)->where('id', '!=', '3')->get();
        return view('Users::users.admin-create-edit', compact('roles'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $roleId = 1;
        $request->request->add(['role_id' => $roleId]);
        $store = $this->api->storeUser($request);
        $store = $store->getData();
        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $store->message);

        if ($request->back) {
            return back();
        }
        return redirect()->route('admin.users');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function edit(Request $request, $id)
    {
        $item = User::findOrFail($id);
        $roles = Role::where('id', '!=', 1)->where('id', '!=', 3)->get();
        $edit = 1;
            //    dd($item);
        return view('Users::users.admin-create-edit', compact('item', 'edit', 'roles'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function update(Request $request, $id)
    {
            //    dd($request->all());
        $roleId = 2;
        $request->request->add(['role_id' => $roleId]);

        $update = $this->api->updateUser($request, $id);
        $update = $update->getData();
        //dd($update->errors);
        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $update->message);

        if ($request->back) {
            return back();
        }
        // return redirect(route('admin.users'));
        return redirect(route('admin.users.edit', [$id]));
    }

    /**
     * Delete single admin user
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function delete($id)
    {
        $user = User::find($id);
        if (isset($user) && $user->id != 10000) {
            $user->delete();
            request()->session()->flash('alert-class', 'alert-success');
            request()->session()->flash('message', 'Admin user deleted successfully.');
        } else {
            request()->session()->flash('alert-class', 'alert-info');
            request()->session()->flash('message', 'No record found for selected item.');
        }
        return redirect()->route('admin.users');
    }

    /**
     * @param
     * @return
     */
    public function confirmDelete($id)
    {
        $item = User::findOrFail($id);
        return view('Users::users.confirm-delete', compact('item'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = User::whereIn('id', $request->ids)->get();
            if (isset($items)) {
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if ($request->operation && $request->operation === 'activate') {
                        $item->account_status = '1';
                        //                        $item->updated_by = auth()->user()->id;
                        $item->save();

                        request()->session()->flash('alert-class', 'alert-success');
                        request()->session()->flash('message', trans('Core::operations.activated_successfully'));
                    } elseif ($request->operation && $request->operation === 'deactivate') {
                        $item->account_status = '0';
                        //                        $item->updated_by = auth()->user()->id;
                        $item->save();
                        request()->session()->flash('alert-class', 'alert-success');
                        request()->session()->flash('message', trans('Core::operations.deactivated_successfully'));
                    } elseif ($request->operation && $request->operation === 'delete') {
                        /*$item->account_status = '0';
                        $item->updated_by = auth()->user()->id;
                        $item->save();*/
                        request()->session()->flash('alert-class', 'alert-info');
                        request()->session()->flash('message', "This action is not allowed.");
                    }
                }
            } else {
                request()->session()->flash('alert-class', 'alert-warning');
                request()->session()->flash('message', 'There is no record found to perform this action');
            }
        } else {
            request()->session()->flash('alert-class', 'alert-warning');
            request()->session()->flash('message', trans('Core::operations.nothing_selected'));
        }
        return back();
    }

    //change member status
    public function changeStatus(Request $request)
    {
        if ($request->user_id != "") {
            /* updating the user status. */
            $arr_to_update = array("active" => $request->user_status);
            /* updating the user status  value into database */
            User::where('id', $request->user_id)->update($arr_to_update);
            echo json_encode(array("error" => "0"));
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1"));
        }
    }

    public function givePermission(Request $request, $role_id = "", $user_id = "")
    {
        if ($role_id == 'admin') {
            $user = User::where('id', $user_id)->first();
            if (isset($user)) {
                $user_permission = $user->hasPermission;
                foreach ($user_permission as $key => $value) {
                    $arr_user_permission[] = $user_permission[$key]->getPermission->id;
                }
                $permissions = Permission::where('active', '1')->orderBy('id', 'Desc')->get();
                if ($request->method() == "GET") {
                    return view('Users::users.permission', compact('user', 'permissions', 'user_permission', 'arr_user_permission'));
                } else {
                    $users_all_permissions = PermissionUser::where('user_id', $user_id)->get();
                    if (isset($users_all_permissions) && count($users_all_permissions) > 0) {
                        foreach ($users_all_permissions as $del) {
                            $del->delete();
                        }
                    }
                    $permission_ids = $request->permission_id;
                    if (isset($permission_ids) && count($permission_ids) > 0) {
                        foreach ($permission_ids as $new_per) {
                            $new_permission = new PermissionUser;
                            $new_permission->user_id = $user_id;
                            $new_permission->permission_id = $new_per;
                            $new_permission->save();
                        }
                    }
                    request()->session()->flash('alert-class', 'alert-success');
                    request()->session()->flash('message', trans("Users::users.permission_set_successfully"));
                    return redirect()->route('admin.users');
                }
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Get country states
     */
    public function getCountryStates($countryId)
    {
        $states = State::where('country_id', $countryId)->where('active', 1)->get();
        $response = ['states' => $states];
        return response()->json($response, 201);
    }

    /**
     * Get state cities
     */
    public function getStateCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->where('active', 1)->get();
        $response = ['cities' => $cities];
        return response()->json($response, 201);
    }

    /*
     * Send notification to users
     */
    public function sendNotification(Request $request)
    {
        $users = User::where(['user_type' => '2', 'account_status' => '1'])->get();

        $notificationData = [
            'message' => 'Check out the topic'
        ];

        Notification::send($users, new AdminNotification($notificationData));
    }

    public function listNotifications()
    {
        $notifications = auth()->user()->unreadNotifications;

        return view('Users::notifications.index', compact('notifications'));
    }
}
