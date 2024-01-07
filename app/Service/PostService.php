<?php

namespace App\Service;

use App\Http\Resources\PostResource;
use App\Models\category;
use App\Models\post;
use Illuminate\Support\Facades\Auth;

class PostService{

    public function getAll(){
        $posts = post::paginate(15);
        return PostResource::collection($posts);
    }
    
    public function showOne($category){
        return new PostResource($category);
    }

    public function store($request){
        $request['user_id'] = Auth::user()->id;
        $posts = post::create($request->all());
        return true;

      

    }

    public function update($request,$post){
        if($post->user_id == Auth::user()->id){
          $post->update($request->all());
          return true;
        }
    }

   public function destroy($post){
    if($post->user_id == Auth::user()->id){
      $post->delete();
      return true;
    }
   }

   
}