<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\client\HomeService;

class HomeController extends Controller
{
	protected $home;

	public function __construct(HomeService $home)
	{
		$this->home = $home;
	}

    public function home()
    {
    	return view('client.pages.home', $this->home->home());
    }
}
