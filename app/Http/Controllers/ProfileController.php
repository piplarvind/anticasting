<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{User, UserProfile, UserProfileImage, State};
use App\Helpers\GeneralHelper;
use App\Modules\Message\Models\{MessageReply, Message};

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
        $states = State::all();
      
     
        return view('submit-profile-new.create', compact('user', 'userProfile', 'userInfo', 'states'));
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
                'current_location' => 'required',
                'height' => 'required',
                'weight' => 'required',
                'complexions' => 'required',
                
                'work_reel1' => [
                    'required',
                    'url',
                    function ($attribute, $requesturl, $failed) {
                        if (!preg_match('/(youtube.com|youtu.be)\/(embed)?(\?v=)?(\S+)?/', $requesturl)) {
                            $failed(trans('Work reel one should be youtube url', ['name' => trans('general.url')]));
                        }
                    },
                ],
                'work_reel2' => [
                    'required',
                    'url',
                    function ($attribute, $requesturl, $failed) {
                        if (!preg_match('/(youtube.com|youtu.be)\/(embed)?(\?v=)?(\S+)?/', $requesturl)) {
                            $failed(trans('Work reel two should be youtube url', ['name' => trans('general.url')]));
                        }
                    },
                ],
                'work_reel3' => [
                    'required',
                    'url',
                    function ($attribute, $requesturl, $failed) {
                        if (!preg_match('/(youtube.com|youtu.be)\/(embed)?(\?v=)?(\S+)?/', $requesturl)) {
                            $failed(trans('Work reel three should be youtube url', ['name' => trans('general.url')]));
                        }
                    },
                ],
                
            ],
            [
                'first_name.required' => 'Please enter a firstname',
                'last_name.required' => 'Please enter a lastname',
                'date_of_birth.required' => 'Please enter a DateOfBirth',
                'ethnicity.required' => 'Please select ethnicity',
                'gender.required' => 'Please select  gender',
                'height.required' => 'Please enter a height',
                'weight.required' => 'Please enter a weight',
                'complexions.required' => 'Please select a complexions',
                'current_location.required' => 'Please enter a current location',
                'intro_video_link.required' => 'Please enter a intro video url',
                'work_reel1.required' => 'Please enter a one work reel',
                'work_reel2.required' => 'Please enter a two work reel',
                'work_reel3.required' => 'Please enter a three work reel',
                'work_reel1.url' => 'The work reel one must be a valid URL.',
                'work_reel2.url' => 'The work reel two must be a valid URL.',
                'work_reel3.url' => 'The work reel three must be a valid URL.',
                'intro_video_link.url' => 'The intro video link must be a valid URL.',
            ],
        );
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

            $user_profile = UserProfile::where('user_id', auth()->user()->id)->first();
            if (!isset($user_profile)) {
                $user_profile = new UserProfile();
            }
            $user_profile->email = $request->email;
            $user_profile->date_of_birth = $request->date_of_birth;
            $user_profile->ethnicity = $request->ethnicity;
            $user_profile->work_reel1 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel1);
            $user_profile->work_reel2 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel2);
            $user_profile->work_reel3 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel3);
            $user_profile->gender = $request->gender;
            $user_profile->height = $request->height;
            $user_profile->complexions = $request->complexions;
            $user_profile->current_location = $request->current_location;
            $user_profile->choose_language = $request->choose_language;
            $user_profile->weight = $request->weight;
            $user_profile->user_id = $userId;
            $user_profile->save();
            return redirect()
                ->back()
                ->with('message', 'Your profile saved successfully.');
        } else {
            return redirect()->route('users.login');
        }
    }
    public function submitWorkReel(Request $request)
    {
        //  dd($request->all());
        $user_profile = UserProfile::where('user_id', auth()->user()->id)->first();
        if (!isset($user_profile)) {
            $user_profile = new UserProfile();
        }
        $user_profile->user_id = auth()->user()->id;
        if ($request->has('work_reel1')) {
            $user_profile->work_reel1 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel1);
        }
        if ($request->has('work_reel2')) {
            $user_profile->work_reel2 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel2);
        }
        if ($request->has('work_reel3')) {
            $user_profile->work_reel3 = GeneralHelper::getYoutubeEmbedUrl($request->work_reel3);
        }
        $user_profile->save();
        return redirect()->back();
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
    public function IntroVideo(Request $request){
        $request->validate(
            [
            'intro_video' => [
                'required',
                'url',
                function ($attribute, $requesturl, $failed) {
                    if (!preg_match('/(youtube.com|youtu.be)\/(embed)?(\?v=)?(\S+)?/', $requesturl)) {
                        $failed(trans('Intro video link should be youtube url', ['name' => trans('general.url')]));
                    }
                },
            ],
        ],
        [
           'intro_video.required' => 'Please enter a intro video url',
           'intro_video.url' => 'The intro video link must be a valid URL.',
        ]);
    }
}
