# Sanjung Delights — AI Coding Agent Instructions

## Project Overview
Corporate catering website for **Sanjung Delights** (halal catering company in KL). Dark-and-gold premium aesthetic. Full-stack Laravel 12 application with custom admin panel. **Reference all implementation details from [docs/sanjung-delights-srs.md](../docs/sanjung-delights-srs.md)** — it is the source of truth. Implementation roadmap is in **[docs/implementation-plan.md](../docs/implementation-plan.md)**.

**Reference site:** https://sanjungdelights.com — rebuilt site must be indistinguishable in look and feel.

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

## Directory Structure (Complete)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Front/          # 8 controllers: Home, About, Menu, Gallery, TrackRecord, Certification, Contact, Client
│   │   └── Admin/          # 15 controllers: AdminAuth, Dashboard, Setting, Hero, Menu, MenuItem, Package,
│   │                       #   Gallery, GalleryCategory, Client, Certification, TrackRecord, Team, Inquiry, Sort
│   ├── Middleware/
│   │   └── AdminAuthenticated.php
│   └── Requests/
│       ├── ContactInquiryRequest.php
│       └── Admin/           # StoreMenuItemRequest, StoreHeroSlideRequest, StoreClientRequest
├── Models/                  # 15 models: Setting, HeroSlide, Menu, MenuCategory, MenuItem, Package,
│                           #   PackageItem, PackageImage, GalleryCategory, GalleryImage, Client,
│                           #   Certification, TrackRecord, TeamMember, ContactInquiry
├── Providers/
│   ├── AppServiceProvider.php
│   └── RepositoryServiceProvider.php   # Binds all 12 repositories
├── Repositories/            # 12 repos: Setting, Hero, Menu, MenuCategory, MenuItem, Package,
│                           #   Gallery, Client, Certification, TrackRecord, TeamMember, ContactInquiry
└── Services/
    ├── Front/              # 8 services: HomePage, AboutPage, Menu, Gallery, TrackRecord, Certification, Client, Contact
    └── Admin/              # 11 services: ImageUpload, Setting, HeroAdmin, MenuAdmin, PackageAdmin,
                            #   GalleryAdmin, ClientAdmin, CertificationAdmin, TrackRecordAdmin, TeamAdmin, InquiryAdmin
database/
├── factories/              # 14 factories for all domain models
├── migrations/             # 18 migrations (3 Laravel default + 15 domain tables)
└── seeders/                # AdminSeeder, SettingSeeder, MenuSeeder, HeroSlideSeeder, SampleDataSeeder
resources/views/
├── layouts/
│   ├── front.blade.php     # Public layout: header, sidebar, main, footer
│   └── admin.blade.php     # Admin layout: collapsible sidebar, flash messages
├── components/
│   ├── front/              # header, sidebar (video bg), footer, hero (reusable)
│   └── admin/              # sidebar (nav icons), header (toggle), image-upload (Alpine)
├── front/                  # 10 pages: home, about, contact, clients, gallery, certifications, track-record,
│   └── menu/               #   menu/index, menu/show, menu/package
└── admin/
    ├── auth/login.blade.php
    ├── dashboard.blade.php
    ├── settings/index.blade.php
    ├── hero-slides/        # index, create, edit
    ├── menus/              # index, create, edit
    ├── menu-items/         # index, create, edit
    ├── packages/           # index, create, edit
    ├── gallery/            # index, create, edit
    ├── gallery-categories/ # index, create, edit
    ├── clients/            # index, create, edit
    ├── certifications/     # index, create, edit
    ├── track-records/      # index, create, edit
    ├── team/               # index, create, edit
    └── inquiries/          # index, show
```

## Tech Stack Specifics

### Laravel 12
- Use `bootstrap/app.php` for middleware/exception config (not `app/Http/Kernel.php`)
- Middleware registered via `Application::configure()->withMiddleware()` — `admin.auth` alias → `AdminAuthenticated`
- Model casts use `casts()` method, not `$casts` property (check existing models)
- Run `php artisan test --compact` (Pest 3) for testing

### TailwindCSS v4 + Vite
- Uses new `@import 'tailwindcss'` directive in `resources/css/app.css`
- `@theme` block for custom tokens, `@source` for content paths
- Dark theme by default — avoid light mode classes
- Vite config includes `@tailwindcss/vite` plugin
- Changes require `npm run build` or active `npm run dev` / `composer run dev`

### Design Tokens (CRITICAL)
| Token | Value | Usage |
|-------|-------|-------|
| Gold | `#C9A84C` | Primary accent, CTAs, headings, active states |
| Gold Dark | `#B8973B` | Hover state for gold buttons |
| Gold Light | `#E5C97A` | Subtle highlights |
| BG Deep | `#0A0A0A` | Deepest background (sections) |
| BG Dark | `#0D0D0D` | Primary page background |
| BG Card | `#111111` | Card/panel backgrounds |
| BG Mid | `#1A1A1A` | Form inputs, subtle surfaces |
| WhatsApp | `#25D366` | WhatsApp CTAs |
| Font Body | Inter | Body text (300–700 weights) |
| Font Heading | Playfair Display | Headings (400, 600, 700, italic) |

**Common Patterns:**
```html
<!-- Hero Section -->
<div class="min-h-screen bg-[#0D0D0D] relative">
  <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-sm">Eyebrow</span>
  <h1 class="text-5xl md:text-7xl font-bold text-white font-serif">Headline</h1>
  <button class="border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm uppercase tracking-widest transition-all duration-300">CTA</button>
</div>

<!-- Image Card with Hover -->
<a class="group relative block overflow-hidden rounded-lg shadow-2xl">
  <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
  <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30"></div>
</a>

<!-- Admin Card -->
<div class="bg-[#111] border border-white/10 rounded-lg p-6">
  <input class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full" />
  <button class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">Save</button>
</div>
```

### Animations (8 keyframes defined in app.css)
`fadeInUp`, `fadeIn`, `slideInLeft`, `slideInRight`, `kenBurns`, `marquee`, `shimmer`, parallax via CSS class. Use `IntersectionObserver` for scroll-triggered animations with `data-animate` and `data-delay` attributes. See SRS Section 5 for the full 26-pattern catalog.

## Database Schema (15 Domain Tables)
`settings` (key-value), `hero_slides`, `menus`, `menu_categories`, `menu_items`, `packages`, `package_items`, `package_images`, `gallery_categories`, `gallery_images`, `clients`, `certifications`, `track_records`, `team_members`, `contact_inquiries`. See SRS Section 7 for column details. Use migrations for all schema changes.

## Routes (96 Total)

### Public Routes (11)
| Route | Name | Controller |
|-------|------|-----------|
| `/` | `home` | `Front\HomeController@index` |
| `/about` | `about` | `Front\AboutController@index` |
| `/menu` | `menu` | `Front\MenuController@index` |
| `/menu/{slug}` | `menu.show` | `Front\MenuController@show` |
| `/menu/packages/{slug}` | `menu.package` | `Front\MenuController@package` |
| `/gallery` | `gallery` | `Front\GalleryController@index` |
| `/track-record` | `track-record` | `Front\TrackRecordController@index` |
| `/certifications` | `certifications` | `Front\CertificationController@index` |
| `/clients` | `clients` | `Front\ClientController@index` |
| `GET /contact` | `contact` | `Front\ContactController@index` |
| `POST /contact` | `contact.submit` | `Front\ContactController@submit` |

### Admin Routes (prefix `/admin`, middleware `admin.auth`)
Resource routes for: `hero-slides`, `menus`, `menus/{menu}/items`, `packages`, `gallery`, `gallery-categories`, `clients`, `certifications`, `track-records`, `team`, `inquiries` (only index/show/destroy + status PATCH). Plus: `GET/POST admin/settings`, `POST admin/sort`, admin auth routes.

## Admin Panel
**Custom Laravel admin (NOT Filament/Nova).** Accessible at `/admin` with session-based auth. Dark UI matching site aesthetic.
- Admin login: `admin@sanjungdelights.com` / `password` (from AdminSeeder)
- Controllers in `app/Http/Controllers/Admin/`
- Use `ImageUploadService` for file uploads (Intervention Image, max 1920px width, 85% JPEG)
- Settings managed via `SettingRepository` with `Cache::remember()` layer
- SortableJS for drag-to-reorder via `POST admin/sort`

## Development Workflow

```bash
# Start all dev services
composer run dev            # Runs server + queue + vite concurrently

# Database
php artisan migrate --seed  # Create tables + seed admin/sample data
php artisan storage:link    # Symlink storage to public

# Build
npm run build               # Production asset build

# Tests
php artisan test --compact  # Pest 3

# Code style
vendor/bin/pint             # Auto-fix formatting
vendor/bin/pint --dirty     # Format only changed files
```

## Laravel Best Practices (Project-Specific)

- **Never use `env()` outside config files** — use `config('app.name')`
- **Avoid `DB::`** — use `Model::query()` or Repositories
- **Form validation:** Create FormRequest classes (e.g., `ContactInquiryRequest`) with custom error messages
- **Eager loading:** Prevent N+1 queries (e.g., `Menu::with('items.category')->get()`)
- **Named routes:** Use `route('admin.menus.index')`, not hardcoded URLs
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
7. **Route names** — Settings is `admin.settings` (not `admin.settings.index`). Menu items are nested: `admin.menus.items.index`

## File Naming Conventions

- **Controllers:** `{Domain}Controller.php` (e.g., `MenuController.php`)
- **Services:** `{Domain}Service.php` for admin, `{Page}Service.php` for front
- **Repositories:** `{Model}Repository.php` (e.g., `ClientRepository.php`)
- **Views:** `front/{page}.blade.php`, `admin/{resource}/index.blade.php`
- **Routes:** `/menu/malay`, `/admin/menus`, `/admin/settings` (kebab-case)

## Key Files to Reference

- **[docs/sanjung-delights-srs.md](../docs/sanjung-delights-srs.md)** — Complete specs (architecture, UI, database, animations)
- **[docs/implementation-plan.md](../docs/implementation-plan.md)** — 3-step implementation roadmap with checklists
- **[CLAUDE.md](../CLAUDE.md)** — Laravel Boost guidelines, PHP standards
- **composer.json** — Available scripts (`setup`, `dev`, `test`)
- **bootstrap/app.php** — Middleware, routing, exception handling config
- **routes/web.php** — All 96 route definitions

## Alpine.js Patterns

Used for interactive components (carousel, lightbox, mobile nav, gallery filters, tabs, counters):
```html
<!-- Carousel -->
<div x-data="{ current: 0, total: {{ count($packages) }} }">
  <button @click="current = (current - 1 + total) % total">Prev</button>
  <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (current * 100) + '%)'">
</div>

<!-- Filter tabs -->
<div x-data="{ filter: 'all' }">
  <button @click="filter = 'malay'" :class="{ 'border-[#C9A84C]': filter === 'malay' }">Malay</button>
  <div x-show="filter === 'all' || filter === 'malay'" x-transition>Content</div>
</div>

<!-- Lightbox -->
<div x-data="{ open: false, src: '' }">
  <img @click="open = true; src = '{{ $image->image_url }}'" class="cursor-pointer" />
  <div x-show="open" x-transition @keydown.escape.window="open = false" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center">
    <img :src="src" class="max-w-full max-h-full" />
    <button @click="open = false" class="absolute top-4 right-4 text-white">✕</button>
  </div>
</div>

<!-- Counter (scroll-triggered) -->
<div x-data="{ count: 0, target: {{ $stat }} }" x-intersect="let i = setInterval(() => { if(count >= target) clearInterval(i); else count++ }, 20)">
  <span x-text="count"></span>
</div>
```

## When Stuck

1. **Search Laravel docs** via Laravel Boost `search-docs` tool (version-specific)
2. **Check SRS** for UI specs (Section 4), animations (Section 5), database (Section 7), backend examples (Section 8)
3. **Inspect sibling files** for patterns (e.g., other Services/Repositories)
4. **Activate `pest-testing` skill** when writing tests
5. **Activate `tailwindcss-development` skill** when working on UI/styling
6. **Run `vendor/bin/pint`** to auto-fix code style issues
