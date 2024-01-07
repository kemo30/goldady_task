<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Http\Resources\CategoryRedource;
use App\Http\Resources\CategoryResource;
use App\Models\category;
use Illuminate\Http\Request;
use App\Service\CategoryService;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function __construct( protected CategoryService $CategoryService){}
  
   

    public function index(){
      return response()->json(['categories' => $this->CategoryService->getAll()],200);
    }

    public function show(Request $request, category $category){
        return response()->json(['category' => $this->CategoryService->showOne($category)],200);
    }

    public function store(CategoriesRequest $request){
      
        if($this->CategoryService->store($request) == true){
            return response()->json(['massage'  => 'created Successfully'] , 201);
    
        }else{
            return response()->json(['massage' => 'Oops! Something went wrong. Please try again later.' ] , 422);
        }
           
    }

    public function update(CategoriesRequest $request , category $category){
      
        if($this->CategoryService->update($request,$category) == true){
            return response()->json(['massage'  => 'updated Successfully'] , 200);
    
        }else{
            return response()->json(['massage' => 'Oops! Something went wrong. Please try again later.' ] , 422);
        }
    }

    public function destroy(category $category){

        if($this->CategoryService->destroy($category) == true){
            return response()->json(['massage'  => 'deleted Successfully'] , 200);
    
        }else{
            return response()->json(['massage' => 'Oops! Something went wrong. Please try again later.' ] , 422);
        }
    }

}
