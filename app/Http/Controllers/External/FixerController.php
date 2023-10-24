<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FixerController extends Controller
{
    public function proxy(Request $request, $path)
    {
        $request_data = $request->all();
        if (!$path) {
            return response()->json(['error' => 'No Fixer path specified'], 400);
        }

        $result = $this->postToFixer($path, $request_data, $request->isMethod('get'));

        Log::debug('Request successfully forwarded to Fixer');
        return $result;
    }

    public function postToFixer($request_url, $data, $is_post=true)
    {
        //example URL -> http://data.fixer.io/api/latest?access_key=0216211d10b5b9ec2ec3012735dbd207

        $fixer_url = getenv('FIXER_BASE_URL');
        $key_query_param = getenv('FIXER_KEY');

        if (!$is_post) {
            $result = Http::get($fixer_url. $request_url .'?access_key='.$key_query_param);
        } else {
            $result = Http::post($fixer_url. $request_url .'?access_key='.$key_query_param, $data);
        }

        if ($result->failed()) {
            Log::error($result->body());
            return null;
        }
        Log::debug('Request successfully posted to Fixer');
        return $result->json();
    }

}
