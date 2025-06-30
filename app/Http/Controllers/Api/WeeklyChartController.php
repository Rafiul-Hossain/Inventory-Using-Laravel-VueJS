<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeeklyChart;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class WeeklyChartController extends Controller
{
    public function weeklyActivityList()
    {
        $allData = WeeklyChart::select('days', 'deposit','withdraw')
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

    public function createWeeklyActivity(Request $request)
    {  
        try {
            $request->validate([
                'days' => 'string|required|unique:weekly_charts,days',
                'deposit' => 'integer|required',
                'withdraw' => 'string|required',
            ]);
            
            $days = $request->input('days');         
            $deposit = $request->input('deposit');  
            $withdraw = $request->input('withdraw');  
            
            // ✅ Associative Array ব্যবহার করতে হবে
            WeeklyChart::create([
                'days' => $days,
                'deposit' => $deposit,
                'withdraw' => $withdraw
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
