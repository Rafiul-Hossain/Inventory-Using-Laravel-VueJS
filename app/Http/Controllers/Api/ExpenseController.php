<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class ExpenseController extends Controller
{

    public function expenseList()
    {
        $allData = Expense::select('id','entertainment', 'bill','investment','others')
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

    public function createExpense(Request $request)
    {  
        try {
            $request->validate([
                'entertainment' => 'integer|required',
                'bill' => 'integer|required',
                'investment' => 'integer|required',
                'others' => 'integer|required',
            ]);
            
            $entertainment = $request->input('entertainment');         
            $bill = $request->input('bill');  
            $investment = $request->input('investment');  
            $others = $request->input('others');  
            
            // ✅ Associative Array ব্যবহার করতে হবে
            Expense::create([
                'entertainment' => $entertainment,
                'bill' => $bill,
                'investment' => $investment,
                'others' => $others
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
