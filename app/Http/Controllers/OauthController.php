<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class OauthController extends Controller
{

	public function redirect(Request $request)
	{

		$request->session()->put("state", $state = Str::random(40));

		$query = http_build_query([

			"client_id" => config("services.api.client_id"),
			"redirect_uri" => route("callback"),
			"response_type" => "code",
			"scope" => "",
			"state" => $state

		]);

		return redirect("https://integrar.pro/oauth/authorize?".$query);

	}

	public function callback(Request $request)
	{

		$state = $request->session()->pull("state");

	    throw_unless(
	        strlen($state) > 0 && $state === $request->state,
	        InvalidArgumentException::class
	    );

	    $response = Http::asForm()->post("http://integrar.pro/oauth/token", [
	        "grant_type" => "authorization_code",
	        "client_id" => config("services.api.client_id"),
	        "client_secret" => config("services.api.client_secret"),
	        "redirect_uri" => "https://clienteexterno.pro/callback",
	        "code" => $request->code,
	    ]);

	    return $response->json();

	}

}