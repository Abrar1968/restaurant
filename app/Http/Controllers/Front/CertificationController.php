<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\CertificationService;
use Illuminate\View\View;

class CertificationController extends Controller
{
    public function __construct(protected CertificationService $certificationService) {}

    public function index(): View
    {
        return view('front.certifications', $this->certificationService->getCertificationData());
    }
}
