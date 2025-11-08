<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\HomePageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainScreenController extends Controller
{
    private HomePageService $homePageService;

    public function __construct(HomePageService $homePageService){
        $this->homePageService = $homePageService;
    }

    public function index(){
       return $this->homePageService->getPosts();
    }
    public function pressLike($post_id){
       return $this->homePageService->postLike($post_id);
    }
    public function pressDislike($post_id){
        return $this->homePageService->postDislike($post_id);
    }


}
