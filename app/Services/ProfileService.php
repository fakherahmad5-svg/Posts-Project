<?php
namespace App\Services;
use App\Http\Controllers\Responses;
use App\Http\Requests\CreatProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function showProfil()
    {

        $id = Auth::user()->id;
        $profile = Profile::find($id);
        if (is_null($profile)) {
            return Responses::fail('Profile does not exist', 404);
        }
        if($profile->image){
            $url = asset('storage/'.$profile->image);
            $profile->image = $url;
        }
        return Responses::success('Profile has been sent successfully!', $profile,200);
    }



    public function createProfile(CreatProfileRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::user()->id;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image')->store('ProfileImage','public');
            $validatedData['profile_image'] = $image;
        }
        $profile = Profile::create($validatedData);
        if ($request->hasFile('profile_image')) {
        $url = asset('storage/'.$profile->profile_image);
        $profile->profile_image = $url;
        }
        return Responses::success('Profile created successfully!', $profile,201);

    }

    public function updateProfile(UpdateProfileRequest $request){
        $validatedData = $request->validated();
        $id = User::find(Auth::user()->id)->profile->id;
        $profile = Profile::find($id);
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image')->store('ProfileImage','public');
            $validatedData['profile_image'] = $image;

        }
        if($profile->imag){
            Storage::disk('public')->delete($profile->image);
        };
        $validatedData['email'] = $profile->email;
        $profile->update($validatedData);
        if ($request->hasFile('profile_image')) {
            $url = asset('storage/'.$profile->profile_image);
            $profile->profile_image = $url;
        }
        return Responses::success('Profile updated successfully!', $profile,200);

    }
}
