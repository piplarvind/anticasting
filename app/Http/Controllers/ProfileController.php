<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{User, UserProfile, UserProfileImage};
use App\Helpers\GeneralHelper;

class ProfileController extends Controller
{
    public function submitProfile()
    {
        $userid = auth()->user()->id;
        $user = User::where('id', $userid)
            ->with([
                'images' => function ($image) {
                    $image
                        ->offset(0)
                        ->orderBy('id', 'ASC')
                        ->limit(2);
                },
            ])
            ->first();
        $userProfile = UserProfile::where('user_id', $userid)->first();
        //    dd($userProfile);
        $userInfo = User::where('id', $userid)->first();
        // dd($userInfo);
       // $message = MessageReply::where('user_id', $userid)->get();
        return view('submit-profile.create-edit', compact('user', 'userProfile', 'userInfo'));
    }
    public function submitProfileStore(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'ethnicity' => 'required',
                'gender' => 'required',
                'countryCode' => 'required',
                'mobile_no' => 'required|max:10',
                'email' => 'required',
                'current_location' => 'required',
                'intro_video_link' => 'required|url',
                'choose_language' => 'required',
                'height' => 'required',
                'complexions' => 'required',

                // 'work_reel1' => 'required|url',
                // 'work_reel2' => 'required|url',
                // 'work_reel3' => 'required|url',
            ],
            [
                'first_name.required' => 'Please enter a firstname',
                'last_name.required' => 'Please enter a lastname',
                'date_of_birth.required' => 'Please enter a date of birth',
                'ethnicity.required' => 'Please select ethnicity',
                'gender.required' => 'Please select  gender',
                'countryCode.required' => 'Please select  countryCode',
                'mobile_no.required' => 'Please enter a mobile number',
                'mobile_no.max' => 'Mobile number should be 10 digit.',
                'email.required' => 'Please enter a email',
                'height.required' => 'Please enter a height',
                'complexions.required' => 'Please select a complexions',

                'current_location.required' => 'Please enter a current location',
                'intro_video_link.required' => 'Please enter a intro video url',
                // 'work_reel1.url' => 'Please enter  youtube link',
                // 'work_reel2.url' => 'Please enter   youtube link',
                // 'work_reel3.url' => 'Please enter  youtube link',

                'choose_language.required' => 'Please select language',
            ],
        );

        // $request->validate(
        //     [
        //         'headshot_image.*' => ['required', 'image', 'mimes:png,jpg,gif'],
        //     ],
        //     [
        //         'headshot_image.required' => 'Image should be jpeg,png,jpg,gif',
        //     ],
        // );
        //  dd($request);
        $userId = auth()->user()->id;
        if (auth()->user()) {
            $user = User::find($userId);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->countryCode = $request->countryCode;
            $user->mobile_no = str_replace(' ', '', $request->mobile_no);
            // $user->email = $request->email;
            // $user->mobile_no = $request->mobile_no;
            $user->save();
            $user_profile = new UserProfile();
            $user_profile->email = $request->email;

            $user_profile->date_of_birth = $request->date_of_birth;
            $user_profile->ethnicity = $request->ethnicity;
            $user_profile->work_reel1 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel1);
            $user_profile->work_reel2 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel2);
            $user_profile->work_reel3 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel3);
            $user_profile->intro_video_link = GeneralHelper::getYoutubeEmbedUrl($request->intro_video_link);
            $user_profile->gender = $request->gender;
            $user_profile->height = $request->height;
            $user_profile->complexions = $request->complexions;
            $user_profile->current_location = $request->current_location;
            $user_profile->choose_language = $request->choose_language;

            $user_profile->user_id = $userId;
            $user_profile->save();

            // if ($request->file('headshot_image')) {
            //     $images = $request->file('headshot_image');

            //     foreach ($images as $image) {
            //         $filename = $image->getClientOriginalName();
            //         $image_name = time() . '-' . $filename;
            //         $profile_image = new UserProfileImage();
            //         $profile_image->profile_images = $image_name;
            //         $ImagePath = $image->move('upload/profile', $image_name);
            //         $profile_image->user_id = $userId;
            //         $profile_image->save();
            //     }
            // }

            return redirect()
                ->back()
                ->with('message', 'Your Profile Submited.');
        } else {
            return redirect()->route('users.login');
        }
    }
    public function editProfile($id)
    {
        $userid = auth()->user()->id;
        $user = User::where('id', $userid)
            ->with([
                'images' => function ($image) {
                    $image
                        ->offset(0)
                        ->orderBy('id', 'ASC')
                        ->limit(2);
                },
            ])
            ->first();
        //   $userProfile = UserProfile::where('user_id', $userid)->first();
        //  dd($userProfile);
        $userInfo = User::where('id', $userid)
            ->with('images')
            ->first();
        $userProfileUpdate = UserProfile::where('id', $id)->first();
        // dd($userInfo);
        return view('submit-profile.create-edit', compact('user', 'userProfileUpdate', 'userInfo'));
    }
    public function updateProfile(Request $request, $id)
    {
        //dd($request->all());
        $userId = auth()->user()->id;

        if (auth()->user()) {
            $user = User::find($userId);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile_no = str_replace(' ', '', $request->mobile_no);
            $user->countryCode = $request->countryCode;
            // $user->email = $request->email;
            // $user->mobile_no = $request->mobile_no;
            $user->save();
            $user_profile = UserProfile::where('id', $id)->first();

            $user_profile->email = $request->email;
            $user_profile->date_of_birth = $request->date_of_birth;
            $user_profile->ethnicity = $request->ethnicity;
            $user_profile->work_reel1 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel1);
            $user_profile->work_reel2 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel2);
            $user_profile->work_reel3 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel3);
            $user_profile->intro_video_link = GeneralHelper::getYoutubeEmbedUrl($request->intro_video_link);
            $user_profile->gender = $request->gender;
            $user_profile->height = $request->height;
            $user_profile->complexions = $request->complexions;
            $user_profile->current_location = $request->current_location;
            $user_profile->choose_language = $request->choose_language;

            $user_profile->user_id = $userId;
            $user_profile->save();

            return redirect()
                ->route('users.dashboard')
                ->with('message', 'Your Profile Updated Successfully.');
        } else {
            return redirect()->route('users.login');
        }
    }
    public function uploadUserImage(Request $request)
    {
        $userId = auth()->user()->id;
        $profile_image = new UserProfileImage();
        if (auth()->user()) {
            if ($request->file('picture')) {
                $images = $request->file('picture');

                $filename = $images->getClientOriginalName();
                $image_name = time() . '-' . $filename;
                $profile_image->image = $image_name;
                $ImagePath = $images->move('upload/profile', $image_name);
                $profile_image->user_id = $userId;
                $profile_image->save();
                return redirect()->back();
            }
        } else {
            return redirect()->route('users.login');
        }
    }
}
