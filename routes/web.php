<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
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
    return view('home');
});

Route::get("/login", function() {
    return view("login");
})->name("login");

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
});


Route::get("/shop", [ShopController::class, "shop"])->name("shop");
Route::get("/product/{pid}", [ShopController::class, "product"])->name("getProduct");
