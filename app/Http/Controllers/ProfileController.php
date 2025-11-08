<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public ProfileService $profileService;

    public function __construct(ProfileService $profileService){
        $this->profileService = $profileService;
    }

    public function index(){
        return $this->profileService->showProfil();
    }

    public function store(CreatProfileRequest $request){
        return $this->profileService->createProfile($request);
    }

    public function update(UpdateProfileRequest $request){
        return $this->profileService->updateProfile($request);
    }


}
