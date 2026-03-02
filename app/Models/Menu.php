<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
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
        'cuisine_type',
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
     * Get the categories for this menu.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(MenuCategory::class);
    }

    /**
     * Get the items for this menu.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get the full URL for the menu cover image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->cover_image_path
            ? asset('storage/'.$this->cover_image_path)
            : null;
    }
}
