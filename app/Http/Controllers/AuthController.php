<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function attempt(Request $request)
    {
        $request->phone = str_replace(" ", "", $request->phone);
        $validator = Validator::make($request->all(), [
            "phone" => "required|regex:/^0?9\d{9}$/"
        ]);

        if($validator->fails()) {
            return response()->json([
                "result" => false,
                "error" => "INVALID"
            ]);
        }


        $user = User::where("phone_number", $request["phone"])->first();
        VerificationMessage::where("phone_number", $request["phone"])->delete();
        $type = isset($user) ? VerificationMessage::TYPE_LOGIN : VerificationMessage::TYPE_REG;
        VerificationMessage::create([
            "code" => randstr(6),
            "type" => $type,
            "phone_number" => $request["phone"],
        ]);
        return response()->json([
            "result" => true,
            "type" => "code_request"
        ]);
    }
    public function verifyCode(Request $request) {
        $validator = Validator::make($request->all(), [
            "phone" => "required|regex:/^0?9\d{9}$/",
            "code" => "required|integer|digits:6",
        ]);
        if($validator->fails()) {
            return response()->json([
                "result" => false,
                "error" => "INVALID",
            ]);
        }
        $code = VerificationMessage::where("phone_number", $request["phone"])
            ->where("code", $request["code"])->first();
        if(! $code) {
            return response()->json(["result" => false]);
        }
        else{
            $redirect = route("info", ["phone" => $request["phone"]]);
            if($code->type == VerificationMessage::TYPE_REG) {
                $code->status = VerificationMessage::STATUS_VERIFIED;
                $code->save();
            }
            else{
                VerificationMessage::where("phone_number", $request["phone"])->delete();
                $user = User::where("phone_number", $request["phone"])->first();
                Auth::login($user);
                $redirect = $this->redirectUser();
            }
            return response()->json([
                "result" => true,
                "redirect" => $redirect
            ]);
        }
    }
    public function info(Request $request)
    {
        $phone = explode("/",url()->current())[5];
        return view("info", compact("phone"));
    }

    public function compeleteInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "phone" => "required|regex:/^0?9\d{9}$/",
            "name" => "required|string|between:2,32",
            "lastname" => "required|string|between:2,32",
            "address" => "required|string|between:2,200",
        ]);

        if($validator->fails()) {
            return response()->json([
                "result" => false,
                "error" => "INVALID",
                "messages" => $validator->messages()
            ]);
        }
        DB::beginTransaction();
        try{
            VerificationMessage::where("phone_number", $request["phone"])->delete();
            $user = $this->setInfo($request->name, $request->lastname, $request->phone);
            Address::create([
                "address" => $request->address,
                "user_id" => $user->id,
                "selected" => Address::ADDRESS_ACTIVE
            ]);
            DB::commit();
            Auth::login($user);
            return response()->json(["result" => true]);
        }
        catch(\Exception $e) {
            DB::rollBack();
        }
    }
    private function setInfo($name, $lastname, $phone)
    {
        return User::create([
            "name" => $name,
            "lastname" => $lastname,
            "phone_number" => $phone,
        ]);
    }
    private function redirectUser()
    {
         return Role::hasRole(auth()->user(), Role::ROLE_ADMIN) ?
            route("dashboard-products") : route("panel");
    }
}
