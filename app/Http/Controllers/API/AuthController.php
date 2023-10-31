<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{

    public function login(LoginRequest $request):JsonResponse
    {
        $json = ["status"=>false, "message"=>"", "data"=>[]];
        $user = User::where("email", $request->email)->first();
        if (!empty($user)){
            if (Hash::check($request->password, $user->password)){
                $user = Auth::loginUsingId($user->id);
                $token = $user->createToken('authToken')->plainTextToken;
                $this->json["status"] = true;
                $this->json["data"] = ["user"=>$user];
                $this->json["access_token"] = $token;
                $this->json["message"] = "Logged successfully.";
                return response()->json($this->json);
            }
            $json["message"] = "Invalid password.";
            return response()->json($json);
        }
        $json["message"] = "Invalid email address.";
        return response()->json($json);
    }

    public function logout(Request $request):JsonResponse
    {
        $request->user()->token()->delete();
        return response()->json(["status"=>true, "message"=>"User logout successfully.", "data"=>[]]);
    }
}
