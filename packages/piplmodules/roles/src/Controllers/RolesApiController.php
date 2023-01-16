<?php

namespace Piplmodules\Roles\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Piplmodules\Roles\Models\Role;
use Piplmodules\Roles\Models\RoleTrans;
use Piplmodules\Users\Models\PermissionRole;

class RolesApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Roles API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     * @param
     * @return
     */
    public function listItems(Request $request) {
        $roles = Role::where('id','!=', 1)->where('id','!=',3)->FilterName()->FilterStatus()->orderBy('id', 'ASC')->paginate($request->get('paginate'));
        $roles->appends($request->except('page'));
        return $roles;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function storeRole(Request $request)
    {
        $role = new Role;
        $role->active = false;
        if ($request->active) {
            $role->active = true;
        }
        $role->save();

        // Trans
        $roleTrans = new RoleTrans;
        $roleTrans->role_id = $role->id;
        $roleTrans->name = $request->name;
        $roleTrans->lang = 'en';
        $roleTrans->save();

        $permission_ids = $request->permissions;
        if (isset($permission_ids) && count($permission_ids) > 0) {
            foreach ($permission_ids as $new_per) {
                $new_permission = new PermissionRole;
                $new_permission->role_id = $role->id;
                $new_permission->permission_id = $new_per;
                $new_permission->save();
            }
        }

        $response = ['message' => 'New role created successfully'];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::find($id);
//        dd($role);
        $role->active = false;
        if ($request->active) {
            $role->active = true;
        }
        $role->save();
        //trans
        $roleTrans = RoleTrans::where('role_id', $role->id)->first();
        if (!isset($roleTrans)) {
            $roleTrans = new RoleTrans;
            $roleTrans->role_id = $role->id;
            $roleTrans->lang = 'en';
        }
        $roleTrans->name = $request->name;
        $roleTrans->save();

        //permission
        $users_all_permissions = PermissionRole::where('role_id', $role->id)->get();
        if (isset($users_all_permissions) && count($users_all_permissions) > 0) {
            foreach ($users_all_permissions as $del) {
                $del->delete();
            }
        }
        $permission_ids = $request->permissions;
        if (isset($permission_ids) && count($permission_ids) > 0) {
            foreach ($permission_ids as $new_per) {
                $new_permission = new PermissionRole;
                $new_permission->role_id = $role->id;
                $new_permission->permission_id = $new_per;
                $new_permission->save();
            }
        }

        $response = ['message' => trans('Roles::roles.updated_successfully')];
        return response()->json($response, 201);
    }

}
