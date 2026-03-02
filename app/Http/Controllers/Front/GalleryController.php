<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\GalleryService;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(protected GalleryService $galleryService) {}

    public function index(): View
    {
        return view('front.gallery', $this->galleryService->getGalleryData());
    }
}
