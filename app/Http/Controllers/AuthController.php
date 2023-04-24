<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationMessage;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function attempt(Request $request)
    {
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
        //todo transaction
        //todo request validation
        VerificationMessage::where("phone_number", $request["phone"])->delete();
        $user = $this->setInfo($request->name, $request->lastname, $request->phone);
        Auth::login($user);
        return response()->json(["result" => true]);
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
