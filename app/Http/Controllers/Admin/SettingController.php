<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(protected SettingService $settingService) {}

    public function index(): View
    {
        return view('admin.settings.index', [
            'settings' => $this->settingService->getAll(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->settingService->update($request->except('_token'));

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
