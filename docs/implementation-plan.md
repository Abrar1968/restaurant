# Sanjung Delights — 3-Step Implementation Plan

> Complete roadmap for implementing the Sanjung Delights SRS from scaffolded codebase to production-ready application.

---

## Step 1: Foundation & Core Backend (Current — Completed)

**Goal:** Establish the full application architecture, database, and foundational code so every subsequent feature has a solid base.

### 1.1 Project Scaffolding ✅
- [x] Laravel 12 project with TailwindCSS v4, Vite, Alpine.js
- [x] Service Layer architecture: `Controller → Service → Repository → Model`
- [x] Directory structure per SRS Section 8
- [x] Dependencies: `intervention/image-laravel`, `laravel/breeze`, `alpinejs`, `sortablejs`

### 1.2 Database Layer ✅
- [x] 15 migrations covering all domain tables (settings, hero_slides, menus, menu_categories, menu_items, packages, package_items, package_images, gallery_categories, gallery_images, clients, certifications, track_records, team_members, contact_inquiries)
- [x] 15 Eloquent models with typed relationships, `casts()` methods, `$fillable` arrays, image URL accessors
- [x] 12 repository classes encapsulating all DB queries
- [x] 14 model factories with realistic fake data
- [x] 5 seeders (Admin, Settings, Menus, HeroSlides, SampleData) + DatabaseSeeder

### 1.3 Backend Services & Controllers ✅
- [x] 8 Front-end services (HomePageService, AboutPageService, MenuService, GalleryService, TrackRecordService, CertificationService, ClientService, ContactService)
- [x] 11 Admin services (ImageUploadService, SettingService, HeroAdminService, MenuAdminService, PackageAdminService, GalleryAdminService, ClientAdminService, CertificationAdminService, TrackRecordAdminService, TeamAdminService, InquiryAdminService)
- [x] 8 Front-end controllers (thin, delegate to services)
- [x] 15 Admin controllers with full CRUD operations
- [x] AdminAuthenticated middleware
- [x] 4 Form Request classes (ContactInquiryRequest, StoreMenuItemRequest, StoreHeroSlideRequest, StoreClientRequest)
- [x] RepositoryServiceProvider binding all repositories
- [x] Complete route definitions (96 routes total)

### 1.4 Design System & Layouts ✅
- [x] TailwindCSS v4 with custom `@theme` tokens (gold #C9A84C, dark backgrounds, fonts)
- [x] 8 animation keyframes (fadeInUp, fadeIn, slideInLeft, slideInRight, kenBurns, marquee, shimmer)
- [x] Alpine.js with IntersectionObserver for scroll-triggered animations
- [x] Front layout with header, sidebar (video bg), footer, hero component
- [x] Admin layout with collapsible sidebar, header, image-upload component

### What You Now Have
A fully scaffolded Laravel 12 application with every model, migration, service, controller, repository, factory, seeder, route, layout, and component in place. The app can boot, routes resolve, and assets compile.

---

## Step 2: Frontend UI & Content Integration

**Goal:** Transform the scaffolded views into pixel-perfect, animated pages that match the [reference site](https://sanjungdelights.com) — "indistinguishable in look and feel."

### 2.1 Database Setup & Content Population
- [ ] Run `php artisan migrate --seed` to create all tables and seed initial data
- [ ] Create `php artisan storage:link` for public file access
- [ ] Populate real content: hero slides, menu categories, menu items, packages, gallery images, client logos, certifications, track records
- [ ] Upload and optimize images via ImageUploadService (max 1920px, 85% JPEG)

### 2.2 Frontend Page Refinement (Per SRS Sections 4.2–4.11)
Each page view is already created. This step involves refining them against the reference site:

| Page | View File | SRS Section | Key Features to Verify |
|------|-----------|-------------|----------------------|
| Home | `front/home.blade.php` | 4.2 | Hero (Ken Burns), parallax banner, package carousel, cuisine cards (2×2), client marquee |
| About | `front/about.blade.php` | 4.3 | Company story layout, mission/vision/values cards, team grid, stats counter animation |
| Menu Index | `front/menu/index.blade.php` | 4.4 | Cuisine category cards, special packages with shimmer effect |
| Menu Show | `front/menu/show.blade.php` | 4.5 | Category tabs (Alpine.js), menu item cards with price, dietary tags |
| Package Detail | `front/menu/package.blade.php` | 4.6 | Package hero, pricing table, dish gallery with lightbox |
| Gallery | `front/gallery.blade.php` | 4.7 | Filter buttons, 4-col grid, hover zoom, full lightbox (Alpine.js) |
| Track Record | `front/track-record.blade.php` | 4.8 | Alternating timeline, year badges, animated entries |
| Certifications | `front/certifications.blade.php` | 4.9 | Certificate cards, lightbox, gold glow hover |
| Contact | `front/contact.blade.php` | 4.10 | Contact info + inquiry form, Google Maps embed, WhatsApp CTA |
| Clients | `front/clients.blade.php` | 4.11 | Logo grid, grayscale-to-color hover |

### 2.3 Animation & Interaction Polish (Per SRS Section 5)
- [ ] Verify all 26 animation patterns from SRS work correctly
- [ ] Ken Burns effect on hero backgrounds (continuous zoom/pan)
- [ ] Parallax scrolling on feature sections
- [ ] Staggered fade-in-up on card grids with `data-delay`
- [ ] Infinite marquee for client logos (no gaps, no flicker)
- [ ] Alpine.js carousels with swipe support on mobile
- [ ] Lightbox with keyboard navigation (Esc, arrows)
- [ ] Smooth scroll-to-section behavior
- [ ] Counter animation (counts up when scrolled into view)

### 2.4 Responsive Design Verification
- [ ] Mobile hamburger menu → sidebar slide-in
- [ ] Stack grids to single column on mobile
- [ ] Touch-friendly tap targets (min 44×44px)
- [ ] Test at breakpoints: 320px, 640px, 768px, 1024px, 1280px
- [ ] Image srcset/sizes for responsive images

### 2.5 SEO & Meta
- [ ] Dynamic `<title>` and `<meta description>` per page from $settings
- [ ] Open Graph tags for social sharing
- [ ] Structured data (JSON-LD) for LocalBusiness
- [ ] Sitemap generation (`php artisan sitemap:generate` or manual)
- [ ] robots.txt configuration

---

## Step 3: Admin Panel, Testing & Deployment

**Goal:** Complete the admin CRUD functionality, achieve comprehensive test coverage, and deploy to production.

### 3.1 Admin Panel Completion
All admin views are scaffolded. This step involves wiring everything together:

- [ ] Admin login/logout flow with Breeze auth (session-based)
- [ ] Dashboard with real stats from database
- [ ] Settings CRUD (key-value store with cache invalidation)
- [ ] Hero Slides CRUD with image upload/preview
- [ ] Menu Categories CRUD with slug auto-generation
- [ ] Menu Items CRUD with category assignment, price, dietary tags
- [ ] Packages CRUD with cover image, pricing, items
- [ ] Gallery CRUD with category filtering, bulk upload consideration
- [ ] Client Logos CRUD with marquee toggle
- [ ] Certifications CRUD with validity dates
- [ ] Track Records CRUD with year/event management
- [ ] Team Members CRUD with photo upload
- [ ] Contact Inquiries management (view, status change, reply link)
- [ ] Drag-to-reorder (SortableJS) via SortController endpoint
- [ ] Image optimization pipeline (Intervention Image: resize, compress)

### 3.2 Testing (Pest 3)
Write feature tests following project conventions:

```bash
php artisan make:test --pest HomePageTest
php artisan make:test --pest ContactFormTest
php artisan make:test --pest AdminMenuCrudTest
```

| Test Area | Coverage Target |
|-----------|----------------|
| Public pages load (200 OK) | All 10 pages |
| Contact form submission | Validation, storage, redirect |
| Admin authentication | Login, logout, middleware redirect |
| Admin CRUD operations | Create, read, update, delete for each module |
| Image upload/delete | Upload, resize, delete from storage |
| Settings cache | Set, get, cache invalidation |
| API/Route tests | Named routes resolve correctly |

### 3.3 Performance Optimization
- [ ] Eager loading verification (no N+1 queries)
- [ ] Settings cache layer (`Cache::remember()` in SettingRepository)
- [ ] Image lazy loading with `loading="lazy"` on below-fold images
- [ ] Asset optimization (Vite build, CSS/JS minification)
- [ ] Database indexing on frequently queried columns (slug, is_active, sort_order)

### 3.4 Security Hardening
- [ ] CSRF protection on all forms (already via `@csrf`)
- [ ] XSS prevention (Blade `{{ }}` escaping)
- [ ] SQL injection prevention (Eloquent parameterized queries)
- [ ] File upload validation (mime types, max size)
- [ ] Rate limiting on contact form
- [ ] Admin route protection via middleware

### 3.5 Deployment Checklist
- [ ] Set `APP_ENV=production`, `APP_DEBUG=false`
- [ ] Configure production database credentials
- [ ] Run `php artisan migrate --force` on production
- [ ] Run `php artisan config:cache`, `route:cache`, `view:cache`
- [ ] Run `npm run build` for production assets
- [ ] Set up `php artisan storage:link`
- [ ] Configure queue worker for image processing jobs
- [ ] Set up SSL certificate
- [ ] Configure backup strategy
- [ ] DNS configuration and domain pointing
- [ ] Verify all pages render correctly on production
- [ ] Monitor error logs (`storage/logs/laravel.log`)

---

## Summary Timeline

| Step | Focus | Status |
|------|-------|--------|
| **Step 1** | Foundation & Core Backend | ✅ Complete |
| **Step 2** | Frontend UI & Content Integration | 🔲 Ready to Start |
| **Step 3** | Admin Panel, Testing & Deployment | 🔲 Pending Step 2 |

---

## Key Commands Reference

```bash
# Development
composer run dev           # Start all dev services (server + queue + vite)
npm run build              # Production asset build
php artisan migrate --seed # Setup database with sample data
php artisan storage:link   # Symlink storage to public

# Testing
php artisan test --compact           # Run all tests
php artisan test --filter=HomePage   # Run specific test

# Code Quality
vendor/bin/pint            # Fix code formatting
vendor/bin/pint --dirty    # Format only changed files

# Production
php artisan config:cache   # Cache configuration
php artisan route:cache    # Cache routes
php artisan view:cache     # Cache compiled views
```
