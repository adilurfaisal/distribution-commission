<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCommissionRequest;
use App\Http\Requests\UpdateCommissionRequest;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $auth_user =  auth('sanctum')->user();

        $commission = Commission::select(DB::raw('commissions.id, users.id AS user_id, users.name, users.email, rules.name as rule_name, transactions.trx_id, transactions.amount as trx_amount, commissions.amount as commissions_amount, commissions.percent as commissions_percent, commissions.created_at'))
            ->join('transactions', 'transactions.id', '=', 'commissions.trans_id')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->join('rules', 'rules.id', '=', 'users.rule_id')
            ->orderBy('commissions.created_at', 'desc')
            ->where('commissions.user_id', $auth_user->id)
            ->get();


        return response()->json($commission, 200);

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
    public function store(StoreCommissionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $auth_user =  auth('sanctum')->user();

        $commission = Commission::select(DB::raw('commissions.id, users.id AS user_id, users.name, users.email, rules.name as rule_name, transactions.trx_id, transactions.amount as trx_amount, commissions.amount as commissions_amount, commissions.percent as commissions_percent, commissions.created_at'))
            ->join('transactions', 'transactions.id', '=', 'commissions.trans_id')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->join('rules', 'rules.id', '=', 'users.rule_id')
            ->orderBy('commissions.created_at', 'desc')
            ->where('commissions.user_id', $id)
            ->get();


        return response()->json($commission, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commission $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommissionRequest $request, Commission $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commission $commission)
    {
        //
    }
}
