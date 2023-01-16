<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Piplmodules\Roles\Models\Role;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->user()->userRole->role_id != '1') {
                if ($request->user()->userRole->role_id == '3') {
                    abort('403', 'Unauthorized action.');
                }
                if ($request->user()->account_status == '0') {
                    request()->session()->flush();
                    request()->session()->flash('alert-class', 'alert-danger');
                    request()->session()->flash('message', trans('admin.inactive_alert'));
                    return redirect('/admin/login');
                }

                if (request()->segment(2) != NULL && isset(auth()->user()->userRole->role->hasPermission)) {
                    $all_permissions = auth()->user()->userRole->role->hasPermission;
                    $arr_user_permission = [];
                    foreach ($all_permissions as $key => $value) {
                        $arr_user_permission[] = $all_permissions{$key}->getPermission->slug;
                    }
                    if (isset($all_permissions) && count($all_permissions) > 0) {
                        if (!in_array(request()->segment(2), $arr_user_permission)) {
                            abort('403', 'Unauthorized action.');
                        }
                    } else {
                        abort('403', 'Unauthorized action.');
                    }
                }
            }
        } else {
            return redirect( 'admin/login');
        }

        return $next($request);
    }
}
