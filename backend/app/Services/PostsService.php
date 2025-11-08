<?php
namespace App\Services;
use App\Http\Controllers\Responses;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Dotenv\Store\FileStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostsService{

    public function getPosts(){
        $posts = Post::where('user_id', Auth::user()->id)->whitCount('likes')->orderBy('created_at', 'desc')->get();
        foreach ($posts as $post) {
            if($post->image){
                $url = asset('storage/'.$post->image);
                $post->image = $url;
            }
        }
        return Responses::success('The posts have been returned', $posts,200);
    }

    public function addPost(StorePostRequest $request){
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        if($request->hasFile('image')){
            $file = $request->file('image')->store('PostImages', 'public');
            $validated['image'] = $file;

        }
        $post =  Post::create($validated);
        if($request->hasFile('image')) {
            $url = asset('storage/' . $post->image);
            $post->image = $url;
        }
        return Responses::success('The post was created',$post,201);
    }

    public function updatePost(UpdatePostRequest $request, $id){
        $validated = $request->validated();
        $post = Post::find($id);
        if (!$post){
            return Responses::fail('The post was not found',null,404);
        }
        if($request->hasFile('image')){
            $file = $request->file('image')->store('PostImages', 'public');
            $validated['image'] = $file;
        }
        if($post->image){
            Storage::disk('public')->delete($post->image);
        }
        $post->update($validated);
        if($request->hasFile('image')) {
            $url = asset('storage/' . $post->image);
            $post->image = $url;
        }
        return Responses::success('The post was updated',$post,200);
    }
    public function deletePost($id){
        $post = Post::find($id);
        if($post->image){
            Storage::disk('public')->delete($post->image);
        }
        Post::destroy($id);
        return Responses::success('The post was deleted',null,200);
    }
}
