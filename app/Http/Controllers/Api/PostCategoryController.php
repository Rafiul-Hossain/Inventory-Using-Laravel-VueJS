<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class PostCategoryController extends Controller
{
   
    public function postCategoryList()
    {
        $allPostCategory = PostCategory::with('posts')->select('id', 'name')->get();
    
        if ($allPostCategory->isNotEmpty()) {
            return response()->json([
                "status" => "success",
                "data" => $allPostCategory
            ]);
        } else {
            return response()->json([
                "status" => "Error",
                "message" => "No categories found"
            ], 404);
        }
    }
    
    public function createPostCategory(Request $request)
    {  
        try {
            $request->validate([
                'name' => 'string|required|unique:post_categories,name',
            ]);

            $name = $request->input('name');         
            PostCategory::create(['name' => $name]);

            return response()->json([
                "status" => "success",
                "message" => "Category created successfully"
            ]);

        } catch (ValidationException $e) {
            // Validation ব্যর্থ হলে response
            return response()->json([
                "status" => "error",
                "message" => $e->errors() // সব validation error array আকারে পাওয়া যাবে
            ], 422);
        } catch (Exception $e) {
            // অন্যান্য ভুলের জন্য response
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }

    }

    public function postByCategory(Request $request)
    {
        $data = PostCategory::with('posts')->where('id', $request->id)->get();
    
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => "Data not found"
            ], 404);
        }
    }
    


}
