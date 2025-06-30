<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class TransactionsController extends Controller
{
    public function recentTransactionsList()
    {
        
        $allData = Transactions::select('name', 'amount','image','date')
                        ->orderBy('id', 'desc')
                        ->get();
    
        if ($allData->isNotEmpty()) {
            return response()->json([
                "status" => "Success",
                "data" => $allData
            ], 200);
        } else {
            return response()->json([
                "status" => "Error",
                "message" => "No expense found"
            ], 404);
        }
    }

    public function createRecentTransaction(Request $request)
    {  
      
        try {
            $request->validate([
                'name'      => 'string|required',
                'amount'    => 'string|required',              
                'date'      => 'required',
            ]);
            
            $name = $request->input('name');         
            $amount = $request->input('amount');  
            $image = $request->input('image');  
            $date = $request->input('date');  
            
            $file=$request->file('image');
            $fileName=$file->getClientOriginalName();
            $t=time();
            $image=$t.'-'.$fileName;
            $path='images/'.$image;
            $file->move(public_path('images'),$image);


            // ✅ Associative Array ব্যবহার করতে হবে
            Transactions::create([
                'name' => $name,
                'amount' => $amount,
                'image' => $image,
                'date' => $date
            ]);
            

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
}
