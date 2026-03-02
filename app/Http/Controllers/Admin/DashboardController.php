<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\InquiryAdminService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected InquiryAdminService $inquiryService)
    {
    }

    public function index(): View
    {
        return view('admin.dashboard', [
            'newInquiryCount' => $this->inquiryService->getNewInquiryCount(),
        ]);
    }
}
