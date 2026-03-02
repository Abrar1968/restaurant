<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SortController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

        $modelClass = $this->resolveModelClass($request->input('model'));

        if (! $modelClass) {
            return response()->json(['message' => 'Invalid model type.'], 422);
        }

        DB::transaction(function () use ($modelClass, $request): void {
            foreach ($request->input('ids') as $sortOrder => $id) {
                $modelClass::where('id', $id)->update(['sort_order' => $sortOrder]);
            }
        });

        return response()->json(['message' => 'Sort order updated successfully.']);
    }

    /**
     * @return class-string|null
     */
    private function resolveModelClass(string $type): ?string
    {
        $allowedModels = [
            'hero_slides' => \App\Models\HeroSlide::class,
            'menu_items' => \App\Models\MenuItem::class,
            'packages' => \App\Models\Package::class,
            'gallery_images' => \App\Models\GalleryImage::class,
            'clients' => \App\Models\Client::class,
            'certifications' => \App\Models\Certification::class,
            'track_records' => \App\Models\TrackRecord::class,
            'team_members' => \App\Models\TeamMember::class,
        ];

        return $allowedModels[$type] ?? null;
    }
}
