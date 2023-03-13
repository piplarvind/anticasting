<?php

namespace App\Http\Controllers;

use App\Models\UserProfileImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    //
    public function deleteHeadShotImageSingle($id, $user_id)
    {
    }
    public function deleteHeadShotImageAll(Request $request, $user_id)
    {
        if (isset($user_id) && $user_id !== '') {
            $userImages = UserProfileImage::where('user_id', $user_id)->get();
            if (isset($userImages) && count($userImages) > 0) {
                UserProfileImage::where('user_id', $user_id)->delete();
                return redirect()
                    ->back()
                    ->with('message', 'All headshot deleted successfully.');
            } else {
                return redirect()
                    ->back()
                    ->with('message', 'Something went wrong, please try again.');
            }
        }
        return redirect()
            ->back()
            ->with('message', 'Something went wrong, please try again.');
    }
}
