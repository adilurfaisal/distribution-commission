<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Rules;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $auth_user =  auth('sanctum')->user();
        if(!empty($auth_user->rule_id)){
            if($auth_user->rule_id==Rules::ADMIN){
                $user = User::with('rule:id,name')->where('id', '<>', $auth_user->id)->select(array('id', 'name', 'email', 'promo_code', 'rule_id'))->get();
                return response()->json($user, 200);
            }else if($auth_user->rule_id==Rules::AFFILIATE || $auth_user->rule_id==Rules::SUBAFFILIATE){
                $user = User::with('rule:id,name')->where('ref_id', $auth_user->id)->where('id', '<>', $auth_user->id)->select(array('id', 'name', 'email', 'promo_code', 'rule_id'))->get();
                return response()->json($user, 200);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $create_by =  auth('sanctum')->user();
        $rule_id = null;
        if(!empty($create_by->rule_id)){
            if($create_by->rule_id==Rules::ADMIN){
                $rule_id = Rules::AFFILIATE;
            }else if($create_by->rule_id==Rules::AFFILIATE){
                $rule_id = Rules::SUBAFFILIATE;
            }
        }
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email',
            "password" => 'required',
            "c_password" => 'required|same:password',
        ]);
        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $row_data = array(
            "name"          => $request->get("name"),
            "email"         => $request->get("email"),
            "password"      => bcrypt($request->get("password")),
            "rule_id"       => $rule_id,
            "ref_id"        => $create_by->id,
            "promo_code"    => Str::upper(Str::random(10)),
            "remember_token" => Str::uuid()
        );

        try {
            $user = User::create($row_data);

            $success['create_by'] = $create_by->id;
            $success['name'] = $user->name;
            $success['promo_code'] = $user->promo_code;

            $response = [
                "success" => true,
                'data' => $success,
                "message" => 'User created successfully!'
            ];
            return response()->json($response, 201);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];          
            if($errorCode == 1062){
                $response = [
                    "success" => false,
                    "message" => 'Duplicate Entry!'
                ];
                return response()->json($response, 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $auth_user =  auth('sanctum')->user();
        $user = User::with('rule:id,name')->where('id', $auth_user->id)->select(array('id', 'name', 'email', 'promo_code', 'rule_id'))->first();
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $id = $request->get("id");
        $deleteStatus = User::where('id', $id)->delete();
        //
        if($deleteStatus){
            $response = [
                "success" => true,
                "message" => "Delete successfully!"
            ];
            return response()->json($response);
        } else {
            $response = [
                "success" => false,
                "message" => "Delete failed!"
            ];
            return response()->json($response, 400);
        }
    }
}
