<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postList()
{
    $allPost = Post::select('title', 'descriptions', 'image', 'post_category_id')
                    ->orderBy('id', 'desc')
                    ->get();

    if ($allPost->isNotEmpty()) {
        return response()->json([
            "status" => "Success",
            "data" => $allPost
        ], 200);
    } else {
        return response()->json([
            "status" => "Error",
            "message" => "No posts found"
        ], 404);
    }
}

    
     public function createPost(Request $request)
     {      
               
        try {
            $request->validate([
                'title' => 'string|required|unique:posts,title',
                'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',           
                'post_category_id' => 'required|integer|min:0'
            ]);
        
            // File upload
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $t = time();
            $image = $t . '-' . $fileName;
            $path = 'images/' . $image;
            $file->move(public_path('images'), $image);
        
            $data = [
                'post_category_id' => $request->input('post_category_id'),
                'title' => $request->input('title'),
                'descriptions' => $request->input('descriptions'),             
                'image' => $path
            ];
        
            Post::create($data);
        
            return response()->json([
                "status" => "Success",
                "message" => "Post created successfully"
            ]);
        
        } catch (ValidationException $e) {
            // Validation error হলে json response
            return response()->json([
                "status" => "error",
                "message" => $e->errors() // এখানে সব validation error array হিসেবে পাওয়া যাবে
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
        
    }


    public function postDetails(Request $request)
    {
       
        $data=Post::with('post_category')->where('id',$request->id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

}
