<?php

namespace App\Modules\SubmitProfile\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserProfile, UserProfileImage, User, State};

class SubmitProfileController extends Controller
{
    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = UserProfile::filterName()
            ->with('profileImage')
            ->filterStatus()
            ->paginate(10);
            // dd($items);
        $state = State::all();
        return view('SubmitProfile::index', compact('items', 'state'));
    }

    public function edit($id)
    {
        $userProfile = UserProfile::where('id', $id)->first();
        $userImage = User::where('id', $userProfile->user_id)
            ->with([
                'images' => function ($image) {
                    $image
                        ->offset(0)
                        ->orderBy('id', 'ASC')
                        ->limit(10);
                },
            ])
            ->first();

        return view('SubmitProfile::edit', compact('userProfile', 'userImage'));
    }
    public function Update(Request $request, $profileId, $userId)
    {
        // dd($request);
        // $request->validate(
        //     [
        //         'name' => 'required',
        //         'date_of_birth' => 'required',
        //         'ethnicity' => 'required',
        //         'gender' => 'required',
        //         'countryCode' => 'required',
        //         'mobile_no' => 'required|max:10',
        //         'email' => 'required',
        //         'current_location' => 'required',
        //         'intro_video_link' => 'required|url',
        //         'choose_language' => 'required',
        //         'country' => 'required',
        //         'work_reel1' => 'required|url',
        //         'work_reel2' => 'required|url',
        //         'work_reel3' => 'required|url',
        //     ],
        //     [
        //         'name.required' => 'Please enter a name',
        //         'date_of_birth.required' => 'Please enter a date of birth',
        //         'ethnicity.required' => 'Please select ethnicity',
        //         'gender.required' => 'Please select  gender',
        //         'contact.required' => 'Please select  contact',
        //         'mobile_no.required' => 'Please enter a mobile number',
        //         'mobile_no.max' => 'Mobile number should be 10 digit.',
        //         'email.required' => 'Please enter a email',

        //         'current_location.required' => 'Please enter a current location',
        //         'intro_video_link.required' => 'Please enter a intro video url',
        //         'work_reel1.url' => 'Please enter  youtube link',
        //         'work_reel2.url' => 'Please enter   youtube link',
        //         'work_reel3.url' => 'Please enter  youtube link',

        //         'choose_language.required' => 'Please select language',
        //     ],
        // );

        // $request->validate(
        //     [
        //         'headshot_image.*' => ['required', 'image', 'mimes:png,jpg,gif'],
        //     ],
        //     [
        //         'headshot_image.required' => 'Image should be jpeg,png,jpg,gif',
        //     ],
        // );
        //$userId = auth()->user()->id;

        if (auth()->user()) {
            $user = User::find($userId);
            $user_profile = UserProfile::findOrFail($profileId);

            $user->name = $request->name;
            $user->save();
            $user_profile->date_of_birth = $request->date_of_birth;
            $user_profile->mobile_no = $request->mobile_no;
            $user_profile->ethnicity = $request->ethnicity;
            $user_profile->work_reel1 = $request->reels_1;
            $user_profile->work_reel2 = $request->reels_2;
            $user_profile->work_reel3 = $request->reels_3;
            $user_profile->intro_video_link = $request->intro_video_link;
            $user_profile->gender = $request->gender;
            $user_profile->current_location = $request->current_location;
            $user_profile->choose_language = $request->choose_language;
            $user_profile->countryCode = $request->countryCode;
            $user_profile->user_id = $userId;
            $user_profile->status = $request->status == 1 ? 1 : 0;
            $user_profile->email = $request->email;
            $user_profile->save();

            if ($request->file('headshot_image')) {
                $images = $request->file('headshot_image');

                foreach ($images as $image) {
                    $filename = $image->getClientOriginalName();
                    $image_name = time() . '-' . $filename;
                    $profile_image = new UserProfileImage();
                    $profile_image->profile_images = $image_name;
                    $ImagePath = $image->move('upload/profile', $image_name);
                    $profile_image->user_id = $userId;
                    $profile_image->save();
                }
            }
            return redirect()->route('admin.submitprofile');
        } else {
            return redirect()->route('users.login');
        }
    }
    public function deleteImage($id)
    {
        $Image = UserProfileImage::findOrFail($id);
        dd($Image);
        // return
    }
    public function manageUserProfile($id)
    {
        $user = User::where('id', $id)->first();

        return view('SubmitProfile::manage-user', compact('user'));
    }
    public function manageUserProfileStore(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        $user->save();
        return redirect()->route('admin.submitprofile');
    }
}
