<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Crypto;

class ItemController extends Controller
{



    public function getData(Request $request)
    {
        $response = Http::get('https://api.coingecko.com/api/v3/coins/list?include_platform=true');



        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $key => $row) {
                $insert = Crypto::create([
                    'cid' => $row['id'],
                    'symbol' => $row['symbol'],
                    'name' => $row['name'],
                    'platform' => serialize($row['platforms'])
                ]);
            }

            dd($insert);
        } else {
            // Handle API request failure
            $statusCode = $response->status();
            $errorMessage = $response->body();
            // Handle the error accordingly
        }
    }
}
