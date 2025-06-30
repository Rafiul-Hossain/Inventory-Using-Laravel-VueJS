<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class CardController extends Controller
{
    public function cardList()
    {
        $allData = Card::select('name', 'balance','card_number','validity')
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

    public function createCard(Request $request)
    {  
      
        try {
            $request->validate([
                'card_number' => 'string|required|unique:cards,card_number',
                'name' => 'string|required',
                'balance' => 'integer|required',
                'validity' => 'required',
            ]);
            
            $card_number = $request->input('card_number');         
            $name = $request->input('name');  
            $balance = $request->input('balance');  
            $validity = $request->input('validity');  
            
            // ✅ Associative Array ব্যবহার করতে হবে
            Card::create([
                'card_number' => $card_number,
                'name' => $name,
                'balance' => $balance,
                'validity' => $validity
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
