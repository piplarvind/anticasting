<?php

namespace Piplmodules\Permissions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Piplmodules\Permissions\Models\Permission;
use Piplmodules\Permissions\Models\PermissionTrans;
use Piplmodules\Users\Models\PermissionRole;

class PermissionsApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Permissions API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     *
     *
     * @param
     * @return
     */
    public function validatation($request) {

        $languages = config('piplmodules.locales');

        $rules['language'] = 'required';

//        $rules['name'] = 'unique:roles_trans';
        if (count($languages)) {
            foreach ($languages as $key => $language) {
                $code = $language['code'];
                if ($request->language) {
                    foreach ($request->language as $lang) {
                        $rules['name_' . $code . ''] = 'required|max:255';
                    }
                }
            }
        }
        $rules['permissions'] = 'required';
        if ($request->segment(2) === 'api') {
            $rules['author'] = 'required|integer';
        }

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listItems(Request $request) {
        $roles = Permission::where('id','!=',5)->where('id','!=',3)->FilterName()->FilterStatus()->orderBy('id', 'ASC')->paginate($request->get('paginate'));
        $roles->appends($request->except('page'));
        return $roles;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function storePermission(Request $request) {
        $validator = $this->validatation($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cn = PermissionTrans::where('name', ucfirst(strtolower($request->name_ar)))->first();
        if (isset($cn->name)) {
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('message', trans('duplicate_role_msg'));
            $store = "Duplicate Entry Present";
            return $store;
        }

        $role = new Permission;
        if ($request->author) {
            $author = $request->author;
        } else {
            $author = auth()->user()->id;
        }

        $role->created_by = $author;
        $role->updated_by = $author;

        $role->active = false;
        if ($request->active) {
            $role->active = true;
        }
        $role->save();

        // Translation
        foreach ($request->language as $langCode) {
            $name = 'name_' . $langCode;

            $roleTrans = new PermissionTrans;
            $roleTrans->role_id = $role->id;
            $roleTrans->name = ucfirst(strtolower($request->$name));
            $roleTrans->lang = $langCode;
            $roleTrans->save();
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

        $response = ['message' => trans('Permissions::roles.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updatePermission(Request $request, $apiKey = '', $id) {
        $role = Permission::find($id);
        if ($request->author) {
            $author = $request->author;
        } else {
            $author = auth()->user()->id;
        }

        $role->updated_by = $author;

        $role->active = false;
        if ($request->active) {
            $role->active = true;
        }
        $role->save();
        // Translation
        foreach ($request->language as $langCode) {
            $name = 'name_' . $langCode;

            $roleTrans = PermissionTrans::where('role_id', $role->id)->where('lang', $langCode)->first();
            if (empty($roleTrans)) {
                $roleTrans = new PermissionTrans;
                $roleTrans->role_id = $role->id;
                $roleTrans->lang = $langCode;
            }
            $roleTrans->name = ucfirst(strtolower($request->$name));
            $roleTrans->save();
        }
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

        $response = ['message' => trans('Permissions::roles.updated_successfully')];
        return response()->json($response, 201);
    }

}
