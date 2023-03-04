<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    
    public function getRequestAPI(request $request){
        $username = 'candidate';
        $password = 'scandinaviantravel2023';        
        $basicAuth = base64_encode($username.':'.$password);
        $bearer = '1|DLZw2t9fpdbmFhjjqLZB0EfM882eV7fizMIkX6KQ';
        
        $client = new Client([
            'base_uri' => $request->apiUrl,
            'timeout'  => 2.0,
            'headers' => [
                'Authorization' => "Basic ".$basicAuth.", Bearer ".$bearer.""
            ]
        ]);
        $response = $client->request('GET', $request->apiRoute);
        $body = $response->getBody();
        return $body;

    }
}
