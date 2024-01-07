<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\post;
use App\Service\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct( protected PostService $postService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['posts' => $this->postService->getAll()],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        if($this->postService->store($request) == true){
            return response()->json(['massage'  => 'created Successfully'] , 201);
    
        }else{
            return response()->json(['massage' => 'Oops! Something went wrong. Please try again later.' ] , 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(post $post)
    {
        return response()->json(['post' => $this->postService->showOne($post)],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        if($this->postService->update($request,$post) == true){
            return response()->json(['massage'  => 'updated Successfully'] , 201);
    
        }else{
            return response()->json(['massage' => 'Oops! Something went wrong. Please try again later.' ] , 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        if($this->postService->destroy($post) == true){
            return response()->json(['massage'  => 'deleted Successfully'] , 200);
    
        }else{
            return response()->json(['massage' => 'Oops! Something went wrong. Please try again later.' ] , 422);
        }
    }
}
