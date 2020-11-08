<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class memeController extends Controller
{
    //
    public function index(){

        $response = Http::get('http://interview.funplay8.com/index.php?page=1')->body();
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($response);
        libxml_clear_errors();
        $doc->saveHTML();
        $xpath = new \DOMXpath($doc);

        $results = $xpath->query("//*[contains(@class, 'meme-img')]");
        $images = [];
        $name = [];

        foreach ($results as $key => $value) {
            array_push($images, $value->getAttribute('src')); 
            if($value->parentNode->parentNode->childNodes[3]->getAttribute('class') == 'meme-name'){
                array_push($name, $value->parentNode->parentNode->childNodes[3]->childNodes[1]->nodeValue); 
            }
            else{
                array_push($name, 'NA'); 
            }
            // 
        }
        dd($name);
        return view('meme');
    }
}
