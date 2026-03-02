<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\AboutPageService;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(protected AboutPageService $aboutService) {}

    public function index(): View
    {
        return view('front.about', $this->aboutService->getAboutData());
    }
}
