<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'cover_image_path',
        'is_active',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get the items for this package.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class);
    }

    /**
     * Get the images for this package.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PackageImage::class);
    }

    /**
     * Get the full URL for the package cover image.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image_path
            ? asset('storage/' . $this->cover_image_path)
            : null;
    }
}
