<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\VerificationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $mostSelled = OrderDetail::mostSelled();
    $newest = OrderDetail::newest();
    return view('home',compact(["mostSelled", "newest"]));
})->name('home');

Route::get("/login", function(Request $request) {
    $timestamp = 0;
    $ip = VerificationMessage::where("ip", $request->ip())->latest()->first();
    if($ip) { $timestamp = strtotime($ip->created_at); }
    return view("login", compact("timestamp"));
})->name("login")->middleware("guest");

Route::post("/auth/attempt", [AuthController::class, "attempt"])->name("attempt");
Route::post("/auth/verify_code", [AuthController::class, "verifyCode"])->name("verify_code");

Route::get("/auth/info/{phone}", [AuthController::class, "info"])->name("info")->middleware(["phone_verified"]);
Route::post("/auth/info/{phone}", [AuthController::class, "compeleteInfo"])->name("compelete-info")->middleware(["phone_verified"]);


Route::middleware(['auth'])->group(function () {
    Route::get("/panel", [PanelController::class, "panel"])->name("panel");
    
    Route::prefix("/dashboard")->group(function() {
        //--- Products ---//
        Route::get("/products", [DashboardController::class, "dashboardProducts"])->name("dashboard-products");
        Route::post("/product", [DashboardController::class, "product"])->name("save-product");
        //--- Categories ---//
        Route::post("/category", [DashboardController::class, "category"])->name("cat-create");
        Route::post("/category/delete", [DashboardController::class, "deleteCat"])->name("cat-delete");
        Route::get("/cats", [DashboardController::class, "cats"])->name("cats");
        //--- Orders ---//
        Route::get("/orders", [DashboardController::class, "dashboardOrders"])->name("dashboard-orders");
        Route::get("/ordersList", [DashboardController::class, "ordersList"])->name("orders-list");
        Route::get("/order-cash-payments", [DashboardController::class, "orderCashPayments"])->name("order-cash-payments");
        Route::get("/order-checks", [DashboardController::class, "orderChecks"])->name("order-checks");
        Route::get("/order-products", [DashboardController::class, "orderProducts"])->name("order-products");
        Route::post("/update-details", [DashboardController::class, "updateDetails"])->name("update-details");
    });

    Route::post("/order", [ShopController::class, "order"])->name("order");
    Route::get("/order-details", [PanelController::class, "orderDetails"])->name("orderDetails");
    Route::get("/order-debt", [PanelController::class, "getOrderDebt"])->name("order-debt");
    Route::get("/total-debt", [PanelController::class, "getTotalDebt"])->name("total-debt");
    Route::post("/pay", [PanelController::class, "payment"])->name("pay");
    Route::post("/check", [PanelController::class, "addCheck"])->name("add-check");
    Route::get("/debt-details", [PanelController::class, "debtDetails"])->name("debt-details");
    Route::get("/has-wating", [PanelController::class, "hasWatingOrder"])->name("has-wating");
    Route::get("/waitings", [PanelController::class, "waitings"])->name("waitings");
    Route::get("/not-delivered-pendings", [PanelController::class, "pendings"])->name("not-delivered-pendings");
    Route::get("/finalizeds", [PanelController::class, "finalizedOrders"])->name("finalizeds");
    Route::get("/order-cash-payments-list", [PanelController::class, "getOrderCashPayments"])->name("order-cash-payments-list");

    Route::get("/invoice", function(Request $request) {
        $order = Order::invoice($request->order);
        return view("invoice",['order' => $order]);
    })->name("invoice");

    Route::post("/logout", [AuthController::class, "logout"])->name("logout");

});


Route::get("/shop", [ShopController::class, "shop"])->name("shop");
Route::get("/product/{pid}", [ShopController::class, "product"])->name("getProduct");


