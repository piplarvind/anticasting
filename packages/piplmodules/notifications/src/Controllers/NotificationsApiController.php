<?php

namespace Piplmodules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Piplmodules\Notifications\Models\Notification;
use Piplmodules\Notifications\Models\NotificationTrans;
use Piplmodules\Users\Models\PermissionNotification;

class NotificationsApiController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Notifications API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     * @param
     * @return
     */
    public function listItems(Request $request)
    {
        $notifications = Notification::orderBy('id', 'DESC')
            ->paginate($request->get('paginate'));
        $notifications->appends($request->except('page'));
        return $notifications;
    }

}
