<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;



class PostController extends Controller
{
    public PostsService $postsService;

    public function __construct(PostsService $postsService){
        $this->postsService = $postsService;
    }

   public function index(){
       return $this->postsService->getPosts();
   }

    public function store(StorePostRequest $request){
       return $this->postsService->addPost($request);
    }

    public function update(UpdatePostRequest $request, $id): \Illuminate\Http\JsonResponse{
       return $this->postsService->updatePost($request, $id);
    }

    public function destroy($id){
      return $this->postsService->deletePost($id);
    }


}
