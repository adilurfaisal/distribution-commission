<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //
        $auth_user =  auth('sanctum')->user();

        $transaction = Transaction::where('user_id', $auth_user->id)->get();


        return response()->json($transaction, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $auth_user =  auth('sanctum')->user();

        $validator = Validator::make($request->all(), [
            "amount" => 'required',
            "trans_type" => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $row_data = array(
            "user_id"       => $auth_user->id,
            "trx_id"        => Str::upper(Str::random(10)),
            "trans_type"    => $request->get("trans_type"),
            "amount"        => $request->get("amount"),
        );

        try {
            $money = Transaction::create($row_data);
            $response = [
                "success" => true,
                "message" => 'Money ' . $request->get("trans_type") . ' successfully!'
            ];
            return response()->json($response, 201);
        } catch (QueryException $e) {
            $response = [
                "data" => $row_data,
                "success" => false,
                "message" => $e
            ];
            return response()->json($response, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($parms)
    {
        $transaction = Transaction::where('user_id', $parms)->get();
        return response()->json($transaction, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
