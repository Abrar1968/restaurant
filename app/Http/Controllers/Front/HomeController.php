<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\HomePageService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(protected HomePageService $homeService) {}

    public function index(): View
    {
        return view('front.home', $this->homeService->getHomeData());
    }
}
