<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use App\Models\Rules;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
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

        $ref_user = null;
        if(!empty($request->get("promo_code"))){
            $ref_user = User::where('promo_code', '=', $request->get("promo_code"))->whereIn('rule_id', [Rules::AFFILIATE, Rules::SUBAFFILIATE])->first(['id']);
            if(empty($ref_user)){
                $response = [
                    "success" => false,
                    "message" => "Promo Code Invalid!"
                ];
                return response()->json($response, 400);
            }
        }

        $row_data = array(
            "name"          => $request->get("name"),
            "email"         => $request->get("email"),
            "password"      => bcrypt($request->get("password")),
            "rule_id"       => Rules::NORMALUSER,
            "ref_id"        => !empty($ref_user) ? $ref_user->id : null,
            "promo_code"    => Str::upper(Str::random(10)),
            "remember_token" => Str::uuid()
        );

        try {
            $user = User::create($row_data);
            $rule = $user->rule;

            $success['token'] = $user->createToken('SOFTIC')->plainTextToken;
            $success['name'] = $user->name;
            $success['rule_id'] = $rule->id;
            $success['rule_name'] = $rule->name;

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
                    "message" => 'This email already register!'
                ];
                return response()->json($response, 400);
            }
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $rule = $user->rule;

            $success['token'] = $user->createToken('SOFTIC')->plainTextToken;
            $success['name'] = $user->name;
            $success['rule_id'] = $rule->id;
            $success['rule_name'] = $rule->name;

            $response = [
                "success" => true,
                'data' => $success,
                "message" => $user->name.' login successfully!'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "success" => false,
                "message" => "Email or Password wrong!"
            ];
            return response()->json($response);
        }
    }
}
