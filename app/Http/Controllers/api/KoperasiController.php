<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class KoperasiController extends Controller
{
    public function check_koperasi()
    {
        $user = config('config-absensi.koperasi.user');
        $pass = config('config-absensi.koperasi.pass');
        $phone = Auth::user()->mobile_phone;
        if (substr($phone, 0, 2) === "62") {
            // If yes, replace them with "0"
            $phone = "0" . substr($phone, 2);
        }
        $md_5 = md5($pass . ":SAKTI.Link:" . $user);
        $client = new Client();
        $apiUrl = config('config-absensi.koperasi.url');

        try {
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    // 'Authorization' => 'Bearer ' . yourAccessToken,
                ],
                'form_params' => [
                    'userid' => $user,
                    'hashpass' => $md_5,
                    'account_number' => $phone,
                    // Add any form data fields you need to send.
                ],
            ]);

            // Process the API response, e.g., retrieve and handle the response content.
            $responseData = json_decode($response->getBody(), true);

            // Handle the response data as needed.

            return response()->json($responseData);
        } catch (\Exception $e) {
            // Handle exceptions, e.g., API request failed.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
