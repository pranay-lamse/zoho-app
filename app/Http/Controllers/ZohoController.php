<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    public function redirectToZoho()
    {
        $params = http_build_query([
            'scope' => 'aaaserver.profile.READ,ZohoCRM.modules.ALL,ZohoCRM.settings.ALL',

            'client_id' => env('ZOHO_CLIENT_ID'),
            'response_type' => 'code',
            'access_type' => 'offline',
            'redirect_uri' => env('ZOHO_REDIRECT_URI'),
        ]);

        return redirect("https://accounts.zoho." . env('ZOHO_REGION') . "/oauth/v2/auth?$params");
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');

        $response = Http::asForm()->post('https://accounts.zoho.' . env('ZOHO_REGION') . '/oauth/v2/token', [
            'code' => $code,
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'redirect_uri' => env('ZOHO_REDIRECT_URI'),
            'grant_type' => 'authorization_code',
        ]);

        $data = $response->json();



        file_put_contents(storage_path('zoho_tokens.json'), json_encode($data, JSON_PRETTY_PRINT));

        return "Zoho tokens saved successfully!";
    }

    // Refresh access token
    public static function getAccessToken()
    {
        $data = json_decode(file_get_contents(storage_path('zoho_tokens.json')), true);
        $response = Http::asForm()->post('https://accounts.zoho.' . env('ZOHO_REGION') . '/oauth/v2/token', [
            'refresh_token' => $data['refresh_token'],
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'grant_type' => 'refresh_token',
        ]);

        $data['access_token'] = $response->json()['access_token'];
        file_put_contents(storage_path('zoho_tokens.json'), json_encode($data, JSON_PRETTY_PRINT));

        return $data['access_token'];
    }
}
