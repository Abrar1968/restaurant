<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\InquiryAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function __construct(protected InquiryAdminService $inquiryAdminService)
    {
    }

    public function index(): View
    {
        return view('admin.inquiries.index', [
            'inquiries' => $this->inquiryAdminService->getPaginated(),
        ]);
    }

    public function show(int $id): View
    {
        $inquiry = $this->inquiryAdminService->findOrFail($id);

        $this->inquiryAdminService->markAsRead($id);

        return view('admin.inquiries.show', [
            'inquiry' => $inquiry,
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $this->inquiryAdminService->updateStatus($id, $request->input('status'));

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->inquiryAdminService->delete($id);

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
