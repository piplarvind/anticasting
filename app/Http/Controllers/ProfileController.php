<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{User,UserProfile,UserProfileImage};
class ProfileController extends Controller
{
    //
     public function submitProfile(){

    $userProfileImage = UserProfileImage::offset(0)->limit(3)->get();
  
        return view('submit_profile',compact('userProfileImage'));
     }
     public function submitProfileStore(Request $request){

        // dd($request);
       // |image|mimes:jpeg,jpg,gif,png
         $request->validate([
          
           'name'=>'required',
           'date_of_birth'=>'required',
           'ethnicity'=>'required',
           'gender'=>'required',
           'contact'=>'required',
           'mobile_no'=>'required',
           'email'=>'required',
           'current_location'=>'required',
           'headshot_image'=>'required|min:0.005|max:2192|image|mimes:jpeg,jpg,gif,png',
           'choose_language'=>'required',
         ],[
           'name.required'=>"Please enter a name",
           'date_of_birth.required'=>"Please enter a date of birth",
           'ethnicity.required'=>"Please select ethnicity",
           'gender.required'=>"Please select  gender",
           'contact.required'=>"Please select  contact",
           'mobile_no.required'=>"Please enter a mobile number",
           'email.required'=>"Please enter a email",
           'current_location.required'=>"Please enter a current location",
           'headshot_image.required'=>"Please choose image",
           'choose_language.required'=>"Please select language",
           'headshot_image.max' => "Maximum file size to upload is 2MB (2192 KB). If you are uploading a photo, try to reduce its resolution to make it under 2MB",
           'headshot_image.min' => "Manimum file size to upload is 5KB (0.005 B). If you are uploading a photo, try to reduce its resolution to make it under 5KB",
           'headshot_image.image'=>"Image Should be (jpeg,gif,jpg,png)"
         ]
        
        );
             $user = new User();
           
             $user->name = $request->name;
             $user->mobile_no = $request->mobile_no;
             $user->save();
             $user_profile = new UserProfile();
             $user_profile->date_of_birth = $request->date_of_birth;
             $user_profile->ethnicity = $request->ethnicity;
             $user_profile->gender = $request->gender;
             $user_profile->current_location = $request->current_location;
             $user_profile->choose_language = $request->choose_language;
             $user_profile->contact = $request->contact;
             $user_profile->user_id = $user->id;
             $user_profile->email = $request->email;
             $user_profile->save();

             if($request->file('headshot_image')){

              $images = $request->file('headshot_image');
           
              foreach($images as $image){
                 
               $filename = $image->getClientOriginalName();
               $name = time().'-'.$filename;
               $profile_image  =  new UserProfileImage();
               $profile_image->profile_images= $name;
               $ImagePath = $image->move('upload/profile', $name);
               $profile_image->user_profile_id = $user_profile->id;
               $profile_image->save(); 
              
              }
            }

      
                

            return redirect()->back()->with('message','Your Profile Submited.');
     }
}
