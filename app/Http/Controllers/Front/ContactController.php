<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactInquiryRequest;
use App\Services\Front\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService) {}

    public function index(): View
    {
        return view('front.contact', $this->contactService->getContactData());
    }

    public function submit(ContactInquiryRequest $request): RedirectResponse
    {
        $this->contactService->submitInquiry($request->validated());

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully. We will get back to you soon.');
    }
}
