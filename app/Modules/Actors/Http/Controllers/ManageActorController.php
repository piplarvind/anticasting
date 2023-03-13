<?php

namespace App\Modules\Actors\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{UserProfile, UserProfileImage, User, State};
class ManageActorController extends Controller
{
    //
    public function ActorList(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $items = User::where('user_type', '0')
            ->with('images')
            ->with('profile')
            ->paginate(5);
        // dd( $items );
        return view('Actors::ManageActor.index', compact('items'));
    }
    public function ActorCreate()
    {
        $state = State::all();
        return view('Actors::ManageActor.create', compact('state'));
    }
    public function ActorStroe(Request $request)
    {
        //dd($request->all());
        $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'ethnicity' => 'required',
                'gender' => 'required',
                'email' => 'required|unique:users,email',
                'current_location' => 'required',
                'mobile_no' => 'required',
            ],
            [
                'first_name.required' => 'Please enter a firstname',
                'last_name.required' => 'Please enter a lastname',
                'date_of_birth.required' => 'Please enter a DateOfBirth',
                'email.required' => 'Please enter a email',
                'ethnicity.required' => 'Please select ethnicity',
                'gender.required' => 'Please select  gender',
                'current_location.required' => 'Please enter a current location',
                'mobile_no.required' => 'Please enter a mobile number',
              
            ],
        );
        //  dd($request->all());
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->countryCode = $request->iso2;
        $user->mobile_no = $request->mobile_no;
        $user->status = $request->status == true ? 1 : 0;
        $user->user_type = '0';
        $user->save();

        $user_profile = new UserProfile();
        $user_profile->date_of_birth = \Carbon\Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $user_profile->ethnicity = $request->ethnicity;
        $user_profile->email = $request->email;
        $user_profile->current_location = $request->current_location;
        $user_profile->gender = $request->gender;
        $user_profile->height = $request->height;
        $user_profile->weight = $request->weight;
        $user_profile->user_id = $user->id;
        $user_profile->save();

        if ($request->file('images')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'gif','jfif'];
            $images = $request->file('images');
            foreach ($images as $image) {
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $user_profile_imge = new UserProfileImage();
                    $image_name = time() . '-' . $filename;
                    $user_profile_imge->image = $image_name;
                    $ImagePath = $image->move('upload/profile', $image_name);
                    $user_profile_imge->user_id = $user->id;
                    $user_profile_imge->save();
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'image should be jpg,jpeg,png,jfif,gif');
                }
            }
        }
        return redirect()->route('admin.actors.mange');
    }
    public function ActorEdit($id)
    {
        $items = User::where('id', $id)
            ->where('user_type', '0')
            ->with('profile')
            ->with('images')
            ->first();
        // dd($items);
        $state = State::all();
        return view('Actors::ManageActor.edit', compact('state', 'items'));
    }
    public function ActorUpdate(Request $request, $user_id)
    {
        $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'ethnicity' => 'required',
                'gender' => 'required',
                'email' => 'required|unique:users,email,' . $user_id,
                'current_location' => 'required',
                'mobile_number' => 'required',
            ],
            [
                'first_name.required' => 'Please enter a firstname',
                'last_name.required' => 'Please enter a lastname',
                'date_of_birth.required' => 'Please enter a DateOfBirth',
                'email.required' => 'Please enter a email',
                'ethnicity.required' => 'Please select ethnicity',
                'gender.required' => 'Please select  gender',
                'current_location.required' => 'Please enter a current location',
                'mobile_number.required' => 'Please enter a mobile number',
                // 'mobile_number.max' => 'Mobile number should be 10 digit.',
            ],
        );
        $user = User::where('id', $user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->countryCode = $request->iso2;
        $user->mobile_no = $request->mobile_number;
        $user->user_type = '0';
        $user->save();

        $user_profile = UserProfile::where('user_id', $user->id)->first();
        $user_profile->date_of_birth = \Carbon\Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $user_profile->ethnicity = $request->ethnicity;
        $user_profile->email = $request->email;
        $user_profile->current_location = $request->current_location;
        $user_profile->gender = $request->gender;
        $user_profile->height = $request->height;
        $user_profile->weight = $request->weight;
        $user_profile->status = $request->status == true ? 1 : 0;
        $user_profile->save();

        if ($request->file('images')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'gif','jfif'];
            $images = $request->file('images');

            foreach ($images as $image) {
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $user_profile_imge = UserProfileImage::where('user_id', $user->id)->first();
                    if (isset($user_profile_imge)) {
                        $image_name = time() . '-' . $filename;
                        $user_profile_imge->image = $image_name;
                        $ImagePath = $image->move('upload/profile', $image_name);
                        $user_profile_imge->user_id = $user->id;
                        $user_profile_imge->save();
                    }
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'image should be jpg,jpeg,jfif,png,gif');
                }
            }
        }
        return redirect()->route('admin.actors.mange');
    }
    public function ActorDetails($id){

        $item = User::where('id', $id)
        ->where('user_type', '0')
        ->with('profile')
        ->with('images')
        ->with('introVideo')
        ->first();
        // dd($item);
       return view('Actors::ManageActor.details',compact('item'));
    }
    public function ActorDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $user_profile = UserProfile::where('user_id', $user->id)->first();
        $user_profile->delete();
        return redirect()->back();
    }
}
