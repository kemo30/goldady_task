<?php

namespace App\Service;

use App\Http\Resources\CategoryResource;
use App\Models\category;
use Illuminate\Support\Facades\Auth;

class CategoryService{

    public function getAll(){
        $categories =  category::paginate(15);
        return CategoryResource::collection($categories);
    }
    
    public function showOne($category){
        return new CategoryResource($category);
    }
    public function store($request){
        $request['user_id'] = Auth::user()->id;
        $category =category::create($request->all());

      if($category){

        return true ;
      }
      return false;

    }

    public function update($request,$category){
        if($category->user_id == Auth::user()->id){
          $category->update($request->all());
          return true;
        }else{
          return false;
        }
    }

   public function destroy($category){
    if($category->user_id == Auth::user()->id){
      $category->delete();
      return true;
    }else{
      return false;
    }
   }

   
}