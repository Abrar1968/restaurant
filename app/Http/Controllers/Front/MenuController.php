<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\MenuService;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __construct(protected MenuService $menuService) {}

    public function index(): View
    {
        return view('front.menu.index', $this->menuService->getMenuIndexData());
    }

    public function show(string $slug): View
    {
        return view('front.menu.show', $this->menuService->getCuisineData($slug));
    }

    public function package(string $slug): View
    {
        return view('front.menu.package', $this->menuService->getPackageData($slug));
    }
}
