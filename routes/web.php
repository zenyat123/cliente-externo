<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OauthController;

Route::get("/", function()
{

    return view("welcome");

});

Route::get("/dashboard", function()
{

    return view("dashboard");

})->middleware(["auth"])->name("dashboard");

require __DIR__."/auth.php";

Route::get("redirect", [OauthController::class, "redirect"])->name("redirect");
Route::get("callback", [OauthController::class, "callback"])->name("callback");