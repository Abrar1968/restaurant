<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHeroSlideRequest;
use App\Services\Admin\HeroAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function __construct(protected HeroAdminService $heroAdminService) {}

    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => $this->heroAdminService->getAll(),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(StoreHeroSlideRequest $request): RedirectResponse
    {
        $this->heroAdminService->create(
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.hero-slides.edit', [
            'slide' => $this->heroAdminService->findOrFail($id),
        ]);
    }

    public function update(StoreHeroSlideRequest $request, int $id): RedirectResponse
    {
        $this->heroAdminService->update(
            $id,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->heroAdminService->delete($id);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide deleted successfully.');
    }
}
