<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class memeController extends Controller
{
    //
    public function index(){

        $page = 1;
        $response = Http::get("http://interview.funplay8.com/index.php?page={$page}")->body();
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($response);
        libxml_clear_errors();
        $doc->saveHTML();
        $xpath = new \DOMXpath($doc);

        $results = $xpath->query("//*[contains(@class, 'meme-img')]");
        $meme = [];

        foreach ($results as $key => $value) {
            $meme[$key]['id'] = $key + 1 + (9 * ($page - 1));
            $meme[$key]['image'] = $value->getAttribute('src'); 
            if($value->parentNode->parentNode->childNodes[3]->getAttribute('class') == 'meme-name'){
                $meme[$key]['name'] = $value->parentNode->parentNode->childNodes[3]->childNodes[1]->nodeValue; 
            }
            else{
                $meme[$key]['name'] = 'NA'; 
            }

            // 
        }
        dd($meme);
        return view('meme');
    }
}
