<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTrackRecordRequest;
use App\Services\Admin\TrackRecordAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrackRecordController extends Controller
{
    public function __construct(protected TrackRecordAdminService $trackRecordAdminService) {}

    public function index(): View
    {
        return view('admin.track-records.index', [
            'trackRecords' => $this->trackRecordAdminService->getAll(),
        ]);
    }

    public function create(): View
    {
        return view('admin.track-records.create');
    }

    public function store(StoreTrackRecordRequest $request): RedirectResponse
    {
        $this->trackRecordAdminService->create(
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.track-records.index')->with('success', 'Track record created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.track-records.edit', [
            'trackRecord' => $this->trackRecordAdminService->findOrFail($id),
        ]);
    }

    public function update(StoreTrackRecordRequest $request, int $id): RedirectResponse
    {
        $this->trackRecordAdminService->update(
            $id,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.track-records.index')->with('success', 'Track record updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->trackRecordAdminService->delete($id);

        return redirect()->route('admin.track-records.index')->with('success', 'Track record deleted successfully.');
    }
}
