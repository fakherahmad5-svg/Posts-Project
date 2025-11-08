<?php
namespace App\Services;
use App\Http\Controllers\Responses;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomePageService{

    public function getPosts(){
        $user = Auth::user();
        $id = $user->id;
        $posts = Post::with('likes:id,name')
            ->with('user:id,name')
            ->where('user_id','!=', $id)
            ->withCount('likes')
            ->when($user, function ($query) use ($user) {
                $query->withExists([
                    'likes as is_liked' => function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    }
                ]);
            })->orderBy('created_at', 'desc')->get();
        foreach ($posts as $post) {
            if($post->image){
                $url = asset('storage/'.$post->image);
                $post->image = $url;
            }
        }
        return Responses::success('The posts have been sent successfully',$posts,200);
    }

    public function postLike($postId){
        $post = Post::findOrFail($postId);
        Auth::user()->likes()->syncWithoutDetaching($post->id);
        return Responses::success('The post has been liked successfully',$post,200);
    }

    public function postDislike($postId){
        $post = Post::findOrFail($postId);
        Auth::user()->likes()->detach($post->id);
        return Responses::success('The post has been disliked successfully',$post,200);
    }
}
