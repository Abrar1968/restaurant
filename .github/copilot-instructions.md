# Sanjung Delights — AI Coding Agent Instructions

## Project Overview
Corporate catering website for Sanjung Delights (halal catering company in KL). Dark-and-gold premium aesthetic. Full-stack Laravel 12 application with custom admin panel. **Reference all implementation details from [docs/sanjung-delights-srs.md](../docs/sanjung-delights-srs.md)** — it is the source of truth.

## Architecture Pattern — Service Layer (MANDATORY)

**Never bypass this structure.** All backend code follows:
```
Route → Controller (thin) → Service → Repository → Model
```

**Example Implementation:**
```php
// Controller delegates immediately
class HomeController extends Controller {
    public function __construct(protected HomePageService $homeService) {}
    
    public function index() {
        return view('front.home', $this->homeService->getHomeData());
    }
}

// Service orchestrates business logic
class HomePageService {
    public function __construct(
        protected HeroRepository $heroRepo,
        protected ClientRepository $clientRepo,
    ) {}
    
    public function getHomeData(): array {
        return [
            'hero' => $this->heroRepo->getActiveForPage('home'),
            'clients' => $this->clientRepo->getMarqueeClients(),
        ];
    }
}

// Repository handles DB queries
class HeroRepository {
    public function getActiveForPage(string $page): ?HeroSlide {
        return HeroSlide::where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();
    }
}
```

**Directory Structure:**
- `app/Services/Front/` — Public-facing services (HomePageService, MenuService, etc.)
- `app/Services/Admin/` — Admin services (ImageUploadService, MenuAdminService, etc.)
- `app/Repositories/` — Database query logic (HeroRepository, MenuRepository, etc.)
- Controllers must use constructor property promotion for dependency injection

## Tech Stack Specifics

### Laravel 12
- Use `bootstrap/app.php` for middleware/exception config (not `app/Http/Kernel.php`)
- Middleware registered via `Application::configure()->withMiddleware()`
- Model casts use `casts()` method, not `$casts` property (check existing models)
- Run `php artisan test --compact` (Pest 3) for testing

### TailwindCSS v4 + Vite
- Uses new `@import 'tailwindcss'` directive in `resources/css/app.css`
- `@theme` block for custom tokens, `@source` for content paths
- Dark theme by default — avoid light mode classes
- Vite config includes `@tailwindcss/vite` plugin
- Changes require `npm run build` or active `npm run dev` / `composer run dev`

### Design Tokens (CRITICAL)
**Gold:** `#C9A84C` (primary accent), **Backgrounds:** `#0A0A0A` (deep), `#0D0D0D` (primary), `#111111` (cards), **Typography:** Inter (body), Playfair Display (headings)

**Common Patterns:**
```html
<!-- Hero Section -->
<div class="min-h-screen bg-[#0D0D0D] relative">
  <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-sm">Eyebrow</span>
  <h1 class="text-5xl md:text-7xl font-bold text-white">Headline</h1>
  <button class="border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm uppercase tracking-widest">CTA</button>
</div>

<!-- Image Card with Hover -->
<a class="group relative block overflow-hidden rounded-lg shadow-2xl">
  <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
  <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30"></div>
</a>
```

**Animations:** See SRS Section 5 for 26 animation patterns (fade-in-up, Ken Burns, parallax, marquee, etc.). Use `IntersectionObserver` for scroll-triggered animations with `data-animate` and `data-delay` attributes.

## Database Schema
**Key tables:** `settings` (key-value config), `hero_slides`, `menus`, `menu_items`, `packages`, `gallery_images`, `clients`, `certifications`, `track_records`, `contact_inquiries`. See SRS Section 7 for complete schema. Use migrations for all schema changes.

## Admin Panel
**Custom Laravel admin (NOT Filament/Nova).** Accessible at `/admin` with Breeze auth. Dark UI matching site aesthetic:
- Controllers in `app/Http/Controllers/Admin/`
- Use `ImageUploadService` for file uploads (Intervention Image, max 1920px width, 85% JPEG)
- Settings managed via `SettingRepository` with cache layer
- Reference SRS Section 9 for admin UI specs

## Development Workflow

**Start dev environment:**
```bash
composer run dev  # Runs server + queue + vite concurrently
```

**Run tests:**
```bash
php artisan test --compact  # Pest 3 syntax
```

**Code formatting:**
```bash
vendor/bin/pint  # Run before finalizing changes (Laravel Pint)
```

**Database:**
```bash
php artisan migrate
php artisan db:seed  # Seed admin user + sample data
```

## Laravel Best Practices (Project-Specific)

- **Never use `env()` outside config files** — use `config('app.name')`
- **Avoid `DB::`** — use `Model::query()` or Repositories
- **Form validation:** Create FormRequest classes (e.g., `ContactInquiryRequest`) with custom error messages
- **Eager loading:** Prevent N+1 queries (e.g., `Menu::with('items.category')->get()`)
- **Named routes:** Use `route('admin.menu.index')`, not hardcoded URLs
- **Queue jobs:** Implement `ShouldQueue` for image processing
- **File storage:** Use `Storage::disk('public')` with symlink to `public/storage`

## Testing with Pest 3

**Feature tests preferred over unit tests.** Use factories for model creation:
```php
test('home page displays active hero', function () {
    $hero = HeroSlide::factory()->active()->create(['page' => 'home']);
    
    $this->get(route('home'))
        ->assertOk()
        ->assertSee($hero->headline);
});
```

Check `database/factories/` for custom states before manually creating models. Use `RefreshDatabase` trait (currently commented in `tests/Pest.php`).

## Common Pitfalls

1. **Don't skip the Service layer** — Controllers should never call Repositories or Models directly
2. **Reference SRS first** — All UI specs, animations, colors are documented there
3. **Use exact design tokens** — Don't approximate colors (`#C9A84C`, not `yellow-600`)
4. **Test frontend changes** — Requires `npm run build` or active `composer run dev`
5. **Cache settings** — Use `SettingRepository` pattern with `Cache::remember()`
6. **Image optimization** — Always resize via `ImageUploadService` (max 1920px, JPEG 85%)

## File Naming Conventions

- **Controllers:** `{Domain}Controller.php` (e.g., `MenuController.php`)
- **Services:** `{Domain}Service.php` for admin, `{Page}Service.php` for front
- **Repositories:** `{Model}Repository.php` (e.g., `ClientRepository.php`)
- **Views:** `front/{page}.blade.php`, `admin/{resource}/index.blade.php`
- **Routes:** `/menu/malay`, `/admin/menus`, `/admin/settings` (kebab-case)

## Key Files to Reference

- **[docs/sanjung-delights-srs.md](../docs/sanjung-delights-srs.md)** — Complete specs (architecture, UI, database, animations)
- **[CLAUDE.md](../CLAUDE.md)** — Laravel Boost guidelines, PHP standards
- **composer.json** — Available scripts (`setup`, `dev`, `test`)
- **bootstrap/app.php** — Middleware, routing, exception handling config

## Alpine.js Patterns

Used for interactive components (carousel, lightbox, mobile nav, gallery filters):
```html
<!-- Carousel -->
<div x-data="{ current: 0, total: {{ count($packages) }} }">
  <button @click="current = (current - 1 + total) % total">Prev</button>
</div>

<!-- Filter tabs -->
<div x-data="{ filter: 'all' }">
  <button @click="filter = 'malay'" :class="{ 'border-[#C9A84C]': filter === 'malay' }">Malay</button>
  <div x-show="filter === 'all' || filter === 'malay'" x-transition>Content</div>
</div>
```

## When Stuck

1. **Search Laravel docs** via Laravel Boost `search-docs` tool (version-specific)
2. **Check SRS Section 8** for backend architecture examples
3. **Inspect sibling files** for patterns (e.g., other Services/Repositories)
4. **Activate `pest-testing` skill** when writing tests
5. **Run `vendor/bin/pint`** to auto-fix code style issues
