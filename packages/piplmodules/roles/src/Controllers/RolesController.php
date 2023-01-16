<?php
namespace Piplmodules\Roles\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Permissions\Models\Permission;
use Piplmodules\Roles\Controllers\RolesApiController as API;
use Piplmodules\Roles\Models\Role;
use Piplmodules\Roles\Models\RoleTrans;

class RolesController extends RolesApiController
{

    /*
   |--------------------------------------------------------------------------
   | Piplmodules Roles Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles Roles for the application.
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
        return view('Roles::roles.index', compact('items'));
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
            ->whereNotIn('slug', ['settings', 'admin-users', 'roles', 'emailtemplates'])
            ->orderBy('id','ASC')
            ->get();
        return view('Roles::roles.create-edit', compact('permissions'));
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
                'name' => 'required|unique:roles_trans',
                'permissions' => 'required',
            ],
            [
                'name.required' => 'Please enter role name',
                'permissions.required' => 'Please select at least one permission'
            ]
        );
        $store = $this->api->storeRole($request);

        $store = $store->getData();

        if(isset($store->errors)){
            return back()->withInput()->withErrors($store->errors);
        }
        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $store->message);

        if($request->back){
            return back();
        }
        return redirect()->route('admin.roles');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function edit($id)
    {
        $item = Role::findOrFail($id);
//        $trans = RoleTrans::where('role_id', $id)->get()->keyBy('lang')->toArray();
        $arr_role_permission = [];
        $user_permission = $item->hasPermission;
        foreach ($user_permission as $key => $value) {
            $arr_role_permission[] = $user_permission[$key]->getPermission->id;
        }
//        dd($arr_role_permission);
        $permissions = Permission::where('active','1')
            ->whereNotIn('slug', ['settings', 'admin-users', 'roles', 'emailtemplates'])
            ->orderBy('id','ASC')
            ->get();
//        dd($permissions);
        return view('Roles::roles.create-edit', compact('item','permissions','arr_role_permission'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function update(Request $request, $id)
    {
        $roleTrans = RoleTrans::where('role_id', $id)->first();
        $this->validate($request,
            [
                'name' => 'required|unique:roles_trans,name,'.$roleTrans->id,
                'permissions' => 'required',
            ],
            [
                'name.required' => 'Please enter role name',
                'permissions.required' => 'Please select at least one permission'
            ]
        );

        $update = $this->api->updateRole($request, $id);

        $update = $update->getData();

        /*if(isset($update->errors)){
            return back()->withInput()->withErrors($update->errors);
        }*/

        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', $update->message);

        if($request->back){
            return back();
        }
        return redirect()->route('admin.roles');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function confirmDelete($id)
    {
        $item = Role::findOrFail($id);
        return view('Roles::roles.confirm-delete', compact('item'));
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
            $items = Role::whereIn('id', $request->ids)->get();
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
}