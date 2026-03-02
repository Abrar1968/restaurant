<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCertificationRequest;
use App\Services\Admin\CertificationAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificationController extends Controller
{
    public function __construct(protected CertificationAdminService $certificationAdminService) {}

    public function index(): View
    {
        return view('admin.certifications.index', [
            'certifications' => $this->certificationAdminService->getAll(),
        ]);
    }

    public function create(): View
    {
        return view('admin.certifications.create');
    }

    public function store(StoreCertificationRequest $request): RedirectResponse
    {
        $this->certificationAdminService->create(
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.certifications.index')->with('success', 'Certification created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.certifications.edit', [
            'certification' => $this->certificationAdminService->findOrFail($id),
        ]);
    }

    public function update(StoreCertificationRequest $request, int $id): RedirectResponse
    {
        $this->certificationAdminService->update(
            $id,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.certifications.index')->with('success', 'Certification updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->certificationAdminService->delete($id);

        return redirect()->route('admin.certifications.index')->with('success', 'Certification deleted successfully.');
    }
}
