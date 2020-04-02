<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\client\NewsSoureService;

class NewsSoureController extends Controller
{
	protected $newsSoure;

	public function __construct(NewsSoureService $newsSoure)
	{
		$this->newsSoure = $newsSoure;
	}

    public function newsSoure($web)
    {
    	$data = $this->newsSoure->newsSoure($web);

    	if (!empty($data)) {
    		return view('client.pages.news_soure', $data);
    	} else {
    		return redirect()->route('client.home');
    	}
    }

    public function keywordSearch(Request $request)
	{
		$data = $this->newsSoure->keywordSearch($request->key);

    	if (!empty($data)) {
    		return view('client.pages.news_soure', $data);
    	} else {
    		return redirect()->route('client.home');
    	}
	}
}
