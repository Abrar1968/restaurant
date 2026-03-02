# Software Requirements Specification (SRS)
## Sanjung Delights — Full-Stack Corporate Catering Website
### Laravel 11 + TailwindCSS v4 + Alpine.js + Blade | Service Pattern Architecture

---

**Document Version:** 1.0  
**Prepared For:** Development Team  
**Reference Site:** https://sanjungdelights.com  
**Stack:** Laravel 11, TailwindCSS v4, Alpine.js, Blade Templates, MySQL  
**Architecture:** Service Pattern (Controllers → Services → Repositories → Models)  
**Admin Panel:** Custom Laravel Admin (no third-party panel)  
**Date:** 2026

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Tech Stack & Architecture](#2-tech-stack--architecture)
3. [Page Inventory & Sitemap](#3-page-inventory--sitemap)
4. [Frontend UI Specification (Per Page)](#4-frontend-ui-specification-per-page)
   - 4.1 Global Layout & Shared Components
   - 4.2 Home Page
   - 4.3 About Us Page
   - 4.4 Our Menu Page
   - 4.5 Cuisine Detail Pages (Malay / Chinese / Indian / Western)
   - 4.6 Special Package Pages (CNY / Christmas)
   - 4.7 Our Gallery Page
   - 4.8 Track Record Page
   - 4.9 Certifications Page
   - 4.10 Contact Page
   - 4.11 Clients Page
5. [Animation & Interaction Catalogue](#5-animation--interaction-catalogue)
6. [Design Tokens (Colors, Typography, Spacing)](#6-design-tokens)
7. [Database Schema](#7-database-schema)
8. [Backend Architecture (Service Pattern)](#8-backend-architecture)
9. [Admin Panel Specification](#9-admin-panel-specification)
10. [API / Route Map](#10-route-map)
11. [File & Media Management](#11-file--media-management)
12. [Responsive Breakpoint Rules](#12-responsive-breakpoint-rules)
13. [Security & Authentication](#13-security--authentication)
14. [Environment & Deployment Checklist](#14-environment--deployment-checklist)

---

## 1. Project Overview

Sanjung Delights is the consumer-facing website of Sanjung Waja Resources, a halal corporate catering company established in 2010 serving Kuala Lumpur and the Klang Valley. The website must be rebuilt as a fully dynamic, database-driven Laravel application where every piece of content — text, images, menus, client logos, certifications, gallery photos, track record entries — is manageable through a custom admin panel without touching code.

The site has a premium, dark-and-gold corporate aesthetic. Its design language communicates trust, prestige, and food excellence simultaneously. Every page uses full-viewport hero sections, smooth scroll-triggered animations, card hover effects, and an immersive sidebar navigation.

The rebuilt site must be indistinguishable in look and feel from the reference site, while being fully responsive, SEO-friendly, and backed by a clean Laravel service-pattern architecture.

---

## 2. Tech Stack & Architecture

**Backend:** Laravel 11, PHP 8.3+  
**Frontend:** TailwindCSS v4 (Vite), Alpine.js 3.x, Blade Templates  
**Database:** MySQL 8+  
**File Storage:** Laravel Storage (local disk, `public` symlink, or S3-compatible)  
**Image Processing:** Spatie Media Library or custom `ImageService` using Intervention Image  
**Auth:** Laravel Breeze (admin only, email+password, single admin user seeded)  
**Queue:** Laravel Queue (database driver) for image processing jobs  
**Caching:** Laravel Cache (file or Redis) for front-end data  

**Architectural Pattern — Service Layer:**
```
HTTP Request
  → Route
    → Controller (thin, delegates immediately)
      → Service Class (business logic, orchestration)
        → Repository (DB queries, Eloquent)
          → Model (Eloquent, casts, relationships)
```

Every major domain (Hero, Menu, Gallery, Clients, Certifications, etc.) has its own Service class. Controllers never talk to Eloquent directly.

---

## 3. Page Inventory & Sitemap

The public-facing website has the following pages, each corresponding to a Blade view and a set of backend data sources:

```
/ ...................... Home
/about ................. About Us
/menu .................. Menu Overview
/menu/malay ............ Malay Cuisine
/menu/chinese .......... Chinese Cuisine
/menu/indian ........... Indian Cuisine
/menu/western .......... Western Cuisine
/menu/packages/{slug} . Special Package (CNY, Christmas, etc.)
/gallery ............... Gallery
/track-record .......... Track Record
/certifications ........ Certifications
/contact ............... Contact
/clients ............... All Clients

/admin ................. Admin Dashboard (authenticated)
/admin/login ........... Admin Login
/admin/* ............... All admin CRUD routes
```

---

## 4. Frontend UI Specification (Per Page)

---

### 4.1 Global Layout & Shared Components

#### 4.1.1 — The Sidebar Navigation

The navigation is **not a top navbar** — it is a **fixed left sidebar** that is off-canvas by default on all screen sizes and slides in from the left when triggered.

**Structure:**
- A fixed sidebar overlay panel, `width: 320px` on desktop, `100vw` on mobile.
- Behind the sidebar content, a **fullscreen video** plays silently on loop (`autoplay muted loop playsinline`). The video (`sidebar-bg.mp4`) acts as the sidebar's background. It has a dark overlay (`rgba(0,0,0,0.65)`) on top so text is legible.
- The sidebar contains: large logo image at top, navigation `<ul>` with links, horizontal divider `<hr>`, "Contact Us" block (phone numbers, email addresses), WhatsApp CTA button, another `<hr>`, and "Office Business Hours" block.

**Sidebar Animation:**
- Default state: `transform: translateX(-100%)`, `opacity: 0`, `pointer-events: none`.
- Open state (Alpine.js `x-show` or class toggle): `transform: translateX(0)`, `opacity: 1`, transition `duration-300 ease-in-out`.
- A dark overlay covers the rest of the page (`fixed inset-0 bg-black/60 z-40`) when sidebar is open; clicking the overlay closes the sidebar.

**Sidebar Nav Links — hover state:**
- Each link has a left gold border indicator: `border-l-4 border-transparent` by default.
- On hover: `border-l-4 border-[#C9A84C] pl-4 text-[#C9A84C]` with `transition-all duration-200`.
- Active page link is always in gold: `text-[#C9A84C] border-l-4 border-[#C9A84C]`.

**WhatsApp Button:**
- Rounded pill button with WhatsApp green background `#25D366`, white text, WhatsApp icon (SVG).
- Hover: slight scale-up `hover:scale-105 transition-transform`.

#### 4.1.2 — The Top Header Bar

A narrow fixed top bar across the full viewport width. This bar holds the hamburger/menu trigger on the left, the logo in the center (white version), and optionally a phone number on the right (desktop only).

**Styling:**
- Background: `rgba(0,0,0,0.80)` with `backdrop-blur-sm`.
- Height: `72px` desktop, `60px` mobile.
- Position: `fixed top-0 left-0 right-0 z-50`.
- Logo: `height: 48px`, centered.
- Hamburger icon: 3 lines (`w-6 h-0.5 bg-white` with `space-y-1.5`), no border, no background.

**Hamburger Animation:**
- When menu open: top line rotates `rotate-45`, middle line `opacity-0`, bottom line `rotate-[-45deg]`. Use Alpine.js `x-bind:class` for this.
- Transition: `duration-300 ease-in-out` on each bar.

#### 4.1.3 — The Footer

A footer strip at the bottom of every page.

**Styling:**
- Background: `#111111` (very dark).
- Padding: `py-6 px-8`.
- Two columns on desktop: left = SST disclaimer text, right = copyright text.
- Single column on mobile, centered.
- Text color: `text-gray-400`, font size `text-sm`.
- A thin gold top border: `border-t border-[#C9A84C]/30`.

#### 4.1.4 — Global CSS Animations (Defined Once, Used Site-Wide)

These are defined in the main CSS file and re-used throughout:

```css
/* Fade up animation — used for section entries */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(40px); }
  to   { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
  animation: fadeInUp 0.7s ease forwards;
}

/* Fade in animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to   { opacity: 1; }
}
.animate-fade-in {
  animation: fadeIn 0.6s ease forwards;
}

/* Slide in from left */
@keyframes slideInLeft {
  from { opacity: 0; transform: translateX(-60px); }
  to   { opacity: 1; transform: translateX(0); }
}
.animate-slide-in-left {
  animation: slideInLeft 0.7s ease forwards;
}

/* Marquee scroll for client logos */
@keyframes marquee {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.animate-marquee {
  animation: marquee 30s linear infinite;
}
.animate-marquee:hover {
  animation-play-state: paused;
}
```

**Scroll-triggered animation trigger:** Use `IntersectionObserver` via Alpine.js or a small vanilla JS snippet. When an element with `data-animate` enters the viewport, add the animation class. Stagger delay using `data-delay` attribute (e.g., `0.1s`, `0.2s`, `0.3s`).

```javascript
// In app.js — scroll animation observer
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const el = entry.target;
      const delay = el.dataset.delay || '0s';
      el.style.animationDelay = delay;
      el.classList.add(el.dataset.animate);
      observer.unobserve(el);
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('[data-animate]').forEach(el => {
  el.style.opacity = '0';
  observer.observe(el);
});
```

---

### 4.2 Home Page (`/`)

The home page is the most complex page. It has multiple distinct sections stacked vertically.

#### Section 1: Hero / Banner (Full Viewport)

The hero occupies `100vh`. It has a large background image (set dynamically from admin). Over the image sits a dark overlay `bg-black/50`. Content is centered vertically and horizontally.

**Content:**
- Eyebrow label: small caps gold text `text-[#C9A84C] uppercase tracking-[0.3em] text-sm font-medium` — "Premier Halal Corporate Catering"
- H1 Headline: large white serif-weight text — "Halal Corporate Catering in KL & Klang Valley" — `text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight`
- Subheadline: `text-gray-300 text-lg md:text-xl max-w-2xl mx-auto mt-4`
- CTA Button: outlined ghost button — `border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300 mt-8`

**Animations:**
- Eyebrow text: `animate-fade-in` with `delay-0`.
- H1: `animate-fade-in-up` with `delay-200ms`.
- Subheadline: `animate-fade-in-up` with `delay-400ms`.
- CTA button: `animate-fade-in-up` with `delay-600ms`.
- Background image has a subtle `scale` Ken Burns effect: `animation: kenBurns 20s ease-in-out infinite alternate`.

```css
@keyframes kenBurns {
  from { transform: scale(1.0); }
  to   { transform: scale(1.08); }
}
```

**Scroll Down Indicator:**
- A bouncing chevron or arrow at the bottom center: `animate-bounce`, gold color.

#### Section 2: Second Hero / Feature Banner

A second full-width section (not necessarily full viewport, but tall — `min-h-[70vh]`) with its own background image.

**Content:**
- Smaller eyebrow in gold
- H2: "Fantastic Food Business Class Service" — `text-3xl md:text-5xl font-bold text-white`
- Body paragraph: `text-gray-300`
- CTA button (same style as above)

This section uses a **parallax scroll effect** on the background image. Implement via CSS `background-attachment: fixed` (desktop only; on mobile use `background-attachment: scroll` to avoid jank).

```css
.parallax-bg {
  background-attachment: fixed;
  background-size: cover;
  background-position: center;
}
@media (max-width: 768px) {
  .parallax-bg { background-attachment: scroll; }
}
```

#### Section 3: Promotional Package Banners (Slider/Carousel)

A horizontal scrollable carousel of promotional package images (CNY 2026, Christmas 2025, etc.). Managed from admin.

**Layout:** `overflow-x-auto` scroll container, or an Alpine.js carousel with arrow buttons.

**Card style:**
- Each card: `relative rounded-lg overflow-hidden shadow-xl cursor-pointer`
- Image fills the card.
- On hover: image scales `scale-105` with `transition-transform duration-500`.
- Bottom overlay: dark gradient `bg-gradient-to-t from-black/80 to-transparent`, shows package name.

**Carousel controls:**
- Left/right arrow buttons: `absolute top-1/2 -translate-y-1/2`, `w-10 h-10 bg-black/50 hover:bg-[#C9A84C] text-white rounded-full flex items-center justify-center transition-colors duration-200`.

**Alpine.js carousel state:**
```html
<div x-data="{ current: 0, total: packages.length }">
  <!-- slides, prev/next buttons, dot indicators -->
</div>
```

#### Section 4: Menu Teaser Card

A single wide card linking to the full menu page. Background image with overlay. Contains eyebrow "Explore Our", headline "Curated Menus", and a link.

**Hover effect:** The card image zooms subtly (`group-hover:scale-105 transition-transform duration-700`) and the overlay lightens slightly.

#### Section 5: About Section (Two-Column)

**Layout:** `grid grid-cols-1 lg:grid-cols-2 gap-12 items-start` inside a `max-w-7xl mx-auto px-6 py-20` container. Background: very dark near-black `#0D0D0D`.

**Left column:**
- Large section label in gold (vertical text on desktop, or small eyebrow label).
- H2: "Sanjung Delights" — large, white.
- Tagline: italic gold text.
- Body paragraphs: `text-gray-300 leading-relaxed`.
- Served client types list: each item has a gold bullet `·` or checkmark icon.
- CTA "More About Us" button.

**Right column:**
- Subheading "The Sanjung Standard in Corporate Catering" — `text-xl font-bold text-white`.
- Multiple body paragraphs in `text-gray-400`.
- A highlighted box: "Our Commitment to Halal Integrity" — `border border-[#C9A84C]/40 bg-[#C9A84C]/5 rounded-lg p-6 mt-6`.
- CTA "View Certificate" link in gold.

**Animations (scroll-triggered):**
- Left column: `data-animate="animate-slide-in-left"` with `data-delay="0s"`.
- Right column: `data-animate="animate-fade-in-up"` with `data-delay="0.2s"`.

#### Section 6: Cuisine Category Cards (Four Cards)

A 2×2 grid on desktop, single column on mobile. Each card links to a cuisine detail page.

**Card structure:**
```
<a href="/menu/{cuisine}" class="group relative block overflow-hidden rounded-lg shadow-2xl h-[380px]">
  <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
  <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent" />
  <div class="absolute bottom-0 left-0 right-0 p-6">
    <span class="text-[#C9A84C] text-xs uppercase tracking-widest font-medium">Halal Compliant</span>
    <h3 class="text-white text-2xl font-bold mt-1 group-hover:text-[#C9A84C] transition-colors duration-300">
      Malay Cuisine
    </h3>
  </div>
</a>
```

**Card animation:**
- Cards enter viewport one by one with stagger: each card has `data-animate="animate-fade-in-up"` and `data-delay="0s"`, `"0.15s"`, `"0.3s"`, `"0.45s"`.

#### Section 7: Client Logo Marquee

An infinite horizontal marquee of client logos on a dark background strip.

**Implementation:**
```html
<div class="overflow-hidden py-12 bg-[#0A0A0A]">
  <div class="flex animate-marquee whitespace-nowrap" style="width: 200%;">
    <!-- Logos duplicated for seamless loop -->
    @foreach($clients as $client)
      <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
           class="h-12 mx-10 object-contain grayscale hover:grayscale-0 transition-all duration-300 opacity-60 hover:opacity-100" />
    @endforeach
    <!-- Exact duplicate for seamless loop -->
    @foreach($clients as $client)
      <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
           class="h-12 mx-10 object-contain grayscale hover:grayscale-0 transition-all duration-300 opacity-60 hover:opacity-100" />
    @endforeach
  </div>
</div>
```

**"View All Clients" link** below the marquee: centered, gold color, underline on hover.

---

### 4.3 About Us Page (`/about`)

#### Hero Section
Same full-viewport hero structure as homepage but with different image and text: "About Sanjung Delights" as the headline.

#### Company Story Section
Two-column layout. Left: a high-quality food/team photo. Right: company story text including founding year (2010), mission statement, values. Both columns animate in on scroll.

**Photo styling:**
- `rounded-lg shadow-2xl`
- A decorative gold border frame offset behind it: achieved with `::before` pseudo-element or a div positioned `translate-x-3 translate-y-3 border-2 border-[#C9A84C] rounded-lg absolute inset-0`.

#### Mission / Vision / Values Section
Three cards in a row (`grid grid-cols-1 md:grid-cols-3 gap-8`).

**Card styling:**
- Background: `bg-[#111111]`
- Top gold accent line: `h-1 w-12 bg-[#C9A84C] mb-4`
- Icon: gold SVG icon `w-8 h-8 text-[#C9A84C]`
- Title: `text-white text-xl font-bold`
- Body: `text-gray-400`
- Border: `border border-white/5`
- Hover: `hover:border-[#C9A84C]/30 transition-colors duration-300`

#### Team Section (if configured in admin)
Grid of team member cards. Each card: profile photo (circle `rounded-full w-24 h-24 object-cover`), name, role. Cards animate in with stagger.

#### Stats Counter Section
A dark full-width band showing key numbers: "16+ Years Experience", "500+ Corporate Clients", "100% Halal Certified", etc.

**Counter animation:** When scrolled into view, numbers count up from 0 to target value using Alpine.js:
```html
<span x-data="{ count: 0, target: 500 }"
      x-init="
        const observer = new IntersectionObserver(entries => {
          if (entries[0].isIntersecting) {
            const interval = setInterval(() => {
              if (count < target) { count += Math.ceil(target/60); }
              else { count = target; clearInterval(interval); }
            }, 30);
            observer.disconnect();
          }
        });
        observer.observe($el);
      "
      x-text="count + '+'">
</span>
```

---

### 4.4 Our Menu Page (`/menu`)

#### Hero Section
Standard hero with "Our Menu" headline and food imagery background.

#### Menu Categories Grid
A large grid of cuisine category cards (same style as homepage cuisine cards, but larger and with more detail). Categories: Malay, Chinese, Indian, Western — each linking to their detail pages.

#### Special Packages Section
A horizontal card strip for seasonal and special packages. Each package card shows: the promotional image (landscape), package name, brief description, and a "View Package" button.

**Package card hover effect:**
- Image zoom `group-hover:scale-105`.
- A gold shimmer overlay animates across on hover:
```css
@keyframes shimmer {
  0%   { transform: translateX(-100%) skewX(-15deg); }
  100% { transform: translateX(200%) skewX(-15deg); }
}
.shimmer-effect::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(201,168,76,0.15) 50%, transparent 100%);
  animation: shimmer 0.8s ease forwards;
  opacity: 0;
}
.shimmer-effect:hover::after { opacity: 1; }
```

---

### 4.5 Cuisine Detail Pages (`/menu/{cuisine}`)

One Blade view handles all four cuisines. The `$cuisine` variable drives the content.

#### Hero Section
Cuisine-specific background image, cuisine name as H1.

#### Menu Items Section
Menu items displayed in a two-column grid on desktop. Each item card:
- A food photo on the left (`w-1/3 object-cover rounded-l-lg`).
- Details on the right: dish name (`text-white font-bold text-lg`), description (`text-gray-400 text-sm`), price in gold (`text-[#C9A84C] font-semibold`), dietary tags (badge: `bg-green-900/40 text-green-400 text-xs px-2 py-0.5 rounded-full`).
- Hover: card border changes `border border-white/5 hover:border-[#C9A84C]/40 transition-colors duration-300`.

#### Category Tabs
If the cuisine has sub-categories (e.g., Breakfast, Lunch, Dinner), show tab navigation:
```html
<div x-data="{ active: 'all' }" class="flex gap-4 border-b border-white/10 mb-8">
  <button @click="active = 'all'"
          :class="active === 'all' ? 'border-b-2 border-[#C9A84C] text-[#C9A84C]' : 'text-gray-400'"
          class="pb-3 px-2 text-sm font-medium transition-colors">All</button>
  <!-- More tabs -->
</div>
```

---

### 4.6 Special Package Pages (`/menu/packages/{slug}`)

Dynamic pages for seasonal packages like CNY 2026 or Christmas 2025.

#### Hero Section
Full-width promotional image (landscape). The image itself serves as the hero — no overlay text needed (the image is a designed promotional poster).

#### Package Details Section
Two-column: left = package description, inclusions list, pricing tiers; right = contact/inquiry form or WhatsApp CTA.

**Pricing Table:**
- Dark card with gold-accented table headers.
- Rows alternate: `bg-[#111]` and `bg-[#0D0D0D]`.
- Price column: `text-[#C9A84C] font-bold`.

#### Gallery of Package Dishes
If additional dish photos are uploaded, shown in a `masonry` grid (CSS columns) or a 3-col grid.

---

### 4.7 Gallery Page (`/gallery`)

#### Hero Section
Standard, with "Our Gallery" headline.

#### Filterable Gallery Grid
Alpine.js + CSS filter:
```html
<div x-data="{ activeFilter: 'all' }">
  <!-- Filter Buttons -->
  <div class="flex flex-wrap gap-3 justify-center mb-10">
    @foreach($categories as $cat)
      <button @click="activeFilter = '{{ $cat->slug }}'"
              :class="activeFilter === '{{ $cat->slug }}' 
                ? 'bg-[#C9A84C] text-black' 
                : 'bg-transparent border border-[#C9A84C] text-[#C9A84C]'"
              class="px-6 py-2 text-sm rounded-sm uppercase tracking-wider font-medium transition-all duration-300">
        {{ $cat->name }}
      </button>
    @endforeach
  </div>
  
  <!-- Grid -->
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($images as $image)
      <div x-show="activeFilter === 'all' || activeFilter === '{{ $image->category->slug }}'"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer"
           @click="openLightbox('{{ $image->url }}')">
        <img src="{{ $image->url }}" alt="{{ $image->caption }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300
                    flex items-center justify-center">
          <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <!-- Expand/zoom icon -->
          </svg>
        </div>
      </div>
    @endforeach
  </div>
</div>
```

#### Lightbox
Alpine.js lightbox overlay for full-size image viewing:
- `fixed inset-0 z-[100] bg-black/95 flex items-center justify-center`
- Image centered, `max-h-[90vh] max-w-[90vw] object-contain`
- Close button top-right corner
- Left/right navigation arrows for prev/next image
- `x-transition:enter="transition ease-out duration-200"` fade animations

---

### 4.8 Track Record Page (`/track-record`)

#### Hero Section
Standard hero with "Track Record" headline.

#### Timeline / List of Events
A chronological list of major events, partnerships, or milestones. Two layouts possible:

**Option A — Timeline (preferred):** Vertical timeline with alternating left/right entries on desktop, single column on mobile.

```
[Year] ───○─── [Event Title]
              [Description]
              [Client/Event Logo if any]
```

**Timeline styling:**
- Central vertical line: `border-l-2 border-[#C9A84C]/30` (centered on desktop, left-aligned on mobile).
- Timeline dot: `w-4 h-4 rounded-full bg-[#C9A84C] border-4 border-[#0D0D0D]`.
- Entry card: `bg-[#111] border border-white/5 rounded-lg p-6`.
- Year badge: `bg-[#C9A84C] text-black text-xs font-bold px-3 py-1 rounded-full`.

**Animation:** Each entry slides in from its respective side as it enters the viewport (`slideInLeft` for left entries, `slideInRight` for right entries).

#### Stats Strip
Numbers: total events catered, years in business, total guests served. Same counter animation as About page.

---

### 4.9 Certifications Page (`/certifications`)

#### Hero Section
Standard hero.

#### Certificates Grid
Grid of certification cards `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8`.

**Certificate card:**
- White card on dark background: `bg-white rounded-lg shadow-2xl overflow-hidden`.
- Certificate image fills top portion of card (the actual certificate scan/image).
- Bottom strip: `bg-[#0D0D0D] px-6 py-4`.
  - Certificate name: `text-white font-bold`.
  - Issuing body: `text-gray-400 text-sm`.
  - Validity period: `text-[#C9A84C] text-sm`.
  - "View Full" button that opens a lightbox/modal with the full certificate image.

**Hover effect:** card `hover:shadow-[0_0_30px_rgba(201,168,76,0.2)] transition-shadow duration-300`.

**Lightbox:** Same Alpine.js lightbox component as gallery.

---

### 4.10 Contact Page (`/contact`)

#### Hero Section
Standard hero.

#### Two-Column Layout
Left: contact information. Right: inquiry form.

**Left column — Contact Info:**
Each info block: icon (gold SVG) + label + value.
- Phone numbers (two numbers shown).
- Email addresses (two emails shown).
- Business hours: MON-FRI 9am–6pm, SAT 9am–1pm.
- Physical address if configured.
- WhatsApp CTA button (large, `#25D366`).
- Embedded Google Maps iframe (address managed from admin).

**Right column — Inquiry Form:**
```html
<form method="POST" action="/contact" class="space-y-5">
  @csrf
  <!-- Name -->
  <div>
    <label class="text-gray-300 text-sm font-medium block mb-2">Full Name</label>
    <input type="text" name="name"
           class="w-full bg-[#111] border border-white/10 text-white rounded-sm px-4 py-3
                  focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none
                  transition-colors duration-200" />
  </div>
  <!-- Company -->
  <div> <!-- same pattern --> </div>
  <!-- Email -->
  <div> <!-- same pattern, type="email" --> </div>
  <!-- Phone -->
  <div> <!-- same pattern, type="tel" --> </div>
  <!-- Event Type -->
  <div>
    <label class="text-gray-300 text-sm font-medium block mb-2">Event Type</label>
    <select name="event_type"
            class="w-full bg-[#111] border border-white/10 text-white rounded-sm px-4 py-3
                   focus:border-[#C9A84C] outline-none">
      <option>Corporate Meeting</option>
      <option>Conference / Seminar</option>
      <option>Company Gathering</option>
      <option>Other</option>
    </select>
  </div>
  <!-- Expected Guests -->
  <div> <!-- number input --> </div>
  <!-- Event Date -->
  <div> <!-- date input --> </div>
  <!-- Message -->
  <div>
    <textarea name="message" rows="5"
              class="w-full bg-[#111] border border-white/10 text-white rounded-sm px-4 py-3
                     focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none
                     transition-colors duration-200 resize-none"></textarea>
  </div>
  <!-- Submit -->
  <button type="submit"
          class="w-full bg-[#C9A84C] hover:bg-[#B8973B] text-black font-bold py-4 px-8
                 uppercase tracking-widest text-sm rounded-sm transition-colors duration-200">
    Send Inquiry
  </button>
</form>
```

**Form validation:** Alpine.js inline validation with error messages (`text-red-400 text-xs mt-1`).

**Success message:** After submit, show a success banner: `bg-green-900/30 border border-green-500/30 text-green-400 rounded-lg p-4`.

---

### 4.11 Clients Page (`/clients`)

#### Hero Section
Standard hero.

#### Client Logo Grid
All client logos in a grid `grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8`.

**Each logo cell:**
```html
<div class="flex items-center justify-center p-6 bg-[#111] rounded-lg border border-white/5
            hover:border-[#C9A84C]/30 transition-colors duration-300 group">
  <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
       class="h-12 object-contain grayscale group-hover:grayscale-0
              opacity-60 group-hover:opacity-100 transition-all duration-300" />
</div>
```

**Scroll animation:** Grid items animate in with stagger using IntersectionObserver.

#### Client Categories / Sectors
If categorized, show filterable tabs (same pattern as gallery).

---

## 5. Animation & Interaction Catalogue

This is the master reference for all animations used across the site.

| ID | Name | Where Used | CSS/JS Implementation |
|----|------|-----------|----------------------|
| A1 | Sidebar slide-in | All pages — nav open | `translateX(-100%)` → `translateX(0)`, `transition-transform duration-300` |
| A2 | Hamburger to X transform | All pages — nav toggle | Bar rotations via Alpine class binding |
| A3 | Page overlay fade | Sidebar open | `opacity-0` → `opacity-100`, `transition-opacity duration-300` |
| A4 | Hero content fade-in-up | All hero sections | `fadeInUp` keyframe, staggered delays on each element |
| A5 | Ken Burns background | Home hero | `scale(1)` → `scale(1.08)` over 20s, `alternate infinite` |
| A6 | Parallax scroll | Home second hero | CSS `background-attachment: fixed` |
| A7 | Section entry fade-up | All content sections | `IntersectionObserver` + `fadeInUp` class |
| A8 | Section entry slide-left | About left column, timeline | `IntersectionObserver` + `slideInLeft` class |
| A9 | Staggered card entry | Cuisine cards, client grid | Same as A7 with `data-delay` incrementing 0.15s |
| A10 | Card image zoom on hover | All image cards | `group-hover:scale-105` or `scale-110`, `transition-transform duration-500/700` |
| A11 | Gold border left nav hover | Sidebar nav links | `border-l-4 border-[#C9A84C]`, `transition-all duration-200` |
| A12 | Button hover state | All CTA buttons | Background fill or color shift, `transition-colors duration-200/300` |
| A13 | Client logo marquee | Home client strip | CSS `@keyframes marquee`, `translateX(0→-50%)`, `30s linear infinite` |
| A14 | Logo grayscale-to-color | Client logo grid & marquee | `grayscale → grayscale-0`, `opacity-60 → opacity-100` on hover |
| A15 | Gallery item reveal | Gallery grid | Alpine `x-show` + `x-transition` fade+scale |
| A16 | Lightbox open | Gallery, Certifications | `fixed inset-0` overlay fade in, `transition duration-200` |
| A17 | Gallery filter switch | Gallery | Alpine `x-show` with `x-transition` on each item |
| A18 | Number counter | About, Track Record | Alpine.js `setInterval` count-up on IntersectionObserver trigger |
| A19 | Shimmer on package card | Menu packages | `@keyframes shimmer` pseudo-element sweep on hover |
| A20 | Timeline entry slide-in | Track Record | Alternate `slideInLeft`/`slideInRight` on scroll |
| A21 | Tab underline transition | Menu tabs, Gallery filters | `border-b-2 border-[#C9A84C]` transition |
| A22 | Form field focus glow | Contact form | `focus:border-[#C9A84C] focus:ring-[#C9A84C]` |
| A23 | WhatsApp button scale | Sidebar, Contact | `hover:scale-105 transition-transform duration-200` |
| A24 | Certification card glow | Certifications | `hover:shadow-[0_0_30px_rgba(201,168,76,0.2)]` |
| A25 | Bounce scroll indicator | Home hero | `animate-bounce` on chevron SVG |
| A26 | Carousel slide | Promo packages | Alpine.js `translateX` on slide container, `transition-transform duration-500` |

---

## 6. Design Tokens

### Colors

```css
:root {
  --color-gold:       #C9A84C;   /* Primary accent — gold */
  --color-gold-dark:  #B8973B;   /* Gold hover/pressed */
  --color-gold-light: #E5C97A;   /* Gold light variant */
  --color-bg-deep:    #0A0A0A;   /* Deepest background (marquee strip) */
  --color-bg-dark:    #0D0D0D;   /* Primary dark background */
  --color-bg-card:    #111111;   /* Card/section background */
  --color-bg-mid:     #1A1A1A;   /* Slightly lighter dark */
  --color-text-white: #FFFFFF;   /* Primary text */
  --color-text-muted: #9CA3AF;   /* gray-400 — body text */
  --color-text-dim:   #6B7280;   /* gray-500 — secondary text */
  --color-border:     rgba(255,255,255,0.07); /* Subtle card borders */
  --color-border-gold: rgba(201,168,76,0.30); /* Gold card borders */
  --color-whatsapp:   #25D366;   /* WhatsApp green */
  --color-success:    #10B981;   /* Success state */
  --color-error:      #EF4444;   /* Error/validation */
}
```

### Typography

```css
/* Primary font: Inter (sans-serif) for body text */
/* Display font: Playfair Display (serif) for large headings */

font-family: 'Inter', sans-serif;       /* nav, body, labels, buttons */
font-family: 'Playfair Display', serif; /* h1, h2 hero headlines */
```

**Scale (using TailwindCSS v4 classes):**

| Usage | Class |
|-------|-------|
| Hero H1 | `text-5xl md:text-7xl font-bold` (Playfair) |
| Section H2 | `text-3xl md:text-5xl font-bold` (Playfair) |
| Card H3 | `text-xl md:text-2xl font-bold` (Inter) |
| Body | `text-base text-gray-400 leading-relaxed` |
| Small/Meta | `text-sm text-gray-500` |
| Eyebrow | `text-xs uppercase tracking-[0.3em] text-[#C9A84C] font-medium` |
| Button | `text-sm uppercase tracking-widest font-semibold` |

### Spacing

All major sections use `py-20 md:py-28` vertical padding and `px-6 md:px-12` horizontal padding. Max content width: `max-w-7xl mx-auto`.

### Border Radius

Cards: `rounded-lg`. Buttons: `rounded-sm` (very slight). Pills/badges: `rounded-full`.

### Shadows

Hero cards: `shadow-2xl`. Hover glow: `shadow-[0_0_30px_rgba(201,168,76,0.2)]`. Sidebar: `shadow-[4px_0_30px_rgba(0,0,0,0.8)]`.

---

## 7. Database Schema

### `settings` table
Stores all global site configuration as key-value pairs.
```sql
id, key VARCHAR(100) UNIQUE, value TEXT, created_at, updated_at
```
Keys include: `site_name`, `tagline`, `phone_1`, `phone_2`, `email_1`, `email_2`, `whatsapp_number`, `address`, `business_hours`, `google_maps_embed`, `sst_notice`, `copyright_text`, `hero_headline`, `hero_subtext`, `about_text`, etc.

### `hero_slides` table
```sql
id, page VARCHAR(50), image_path VARCHAR(255), headline TEXT,
subheadline TEXT, cta_text VARCHAR(100), cta_url VARCHAR(255),
sort_order INT, is_active BOOLEAN, created_at, updated_at
```

### `menus` table (cuisine categories)
```sql
id, name VARCHAR(100), slug VARCHAR(100) UNIQUE, cuisine_type ENUM('malay','chinese','indian','western','other'),
description TEXT, cover_image_path VARCHAR(255), is_active BOOLEAN,
sort_order INT, created_at, updated_at
```

### `menu_categories` table (sub-categories within a cuisine)
```sql
id, menu_id UNSIGN INT FK, name VARCHAR(100), sort_order INT
```

### `menu_items` table
```sql
id, menu_id UNSIGN INT FK, menu_category_id NULL FK,
name VARCHAR(200), description TEXT, price DECIMAL(8,2) NULL,
price_note VARCHAR(100), image_path VARCHAR(255) NULL,
tags JSON, /* ["vegetarian", "spicy"] etc. */
is_halal BOOLEAN DEFAULT true, is_available BOOLEAN DEFAULT true,
sort_order INT, created_at, updated_at
```

### `packages` table
```sql
id, name VARCHAR(200), slug VARCHAR(200) UNIQUE, tagline VARCHAR(255),
description TEXT, cover_image_path VARCHAR(255),
is_active BOOLEAN, sort_order INT, created_at, updated_at
```

### `package_items` table
```sql
id, package_id UNSIGNED INT FK, name VARCHAR(200), description TEXT,
price DECIMAL(8,2) NULL, price_label VARCHAR(100), sort_order INT
```

### `package_images` table
```sql
id, package_id UNSIGNED INT FK, image_path VARCHAR(255),
caption VARCHAR(255), sort_order INT
```

### `gallery_categories` table
```sql
id, name VARCHAR(100), slug VARCHAR(100) UNIQUE, sort_order INT
```

### `gallery_images` table
```sql
id, gallery_category_id NULL FK, image_path VARCHAR(255),
caption VARCHAR(255), alt_text VARCHAR(255), sort_order INT,
is_active BOOLEAN, created_at, updated_at
```

### `clients` table
```sql
id, name VARCHAR(200), logo_path VARCHAR(255),
sector VARCHAR(100) NULL, /* corp/edu/gov/industrial */
show_in_marquee BOOLEAN DEFAULT true,
show_in_clients_page BOOLEAN DEFAULT true,
sort_order INT, is_active BOOLEAN, created_at, updated_at
```

### `certifications` table
```sql
id, name VARCHAR(200), issuing_body VARCHAR(200),
certificate_image_path VARCHAR(255), valid_from DATE NULL,
valid_until DATE NULL, description TEXT NULL,
sort_order INT, is_active BOOLEAN, created_at, updated_at
```

### `track_records` table
```sql
id, year YEAR, title VARCHAR(255), description TEXT,
client_name VARCHAR(200) NULL, image_path VARCHAR(255) NULL,
sort_order INT, created_at, updated_at
```

### `team_members` table
```sql
id, name VARCHAR(200), role VARCHAR(200),
photo_path VARCHAR(255) NULL, bio TEXT NULL,
sort_order INT, is_active BOOLEAN, created_at, updated_at
```

### `contact_inquiries` table
```sql
id, name VARCHAR(200), company VARCHAR(200) NULL,
email VARCHAR(200), phone VARCHAR(50) NULL,
event_type VARCHAR(100) NULL, expected_guests INT NULL,
event_date DATE NULL, message TEXT,
status ENUM('new','read','replied') DEFAULT 'new',
created_at, updated_at
```

### `admins` table
Standard Laravel `users` table (or rename to `admins`):
```sql
id, name, email UNIQUE, password, remember_token, created_at, updated_at
```

---

## 8. Backend Architecture

### Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Front/
│   │   │   ├── HomeController.php
│   │   │   ├── AboutController.php
│   │   │   ├── MenuController.php
│   │   │   ├── GalleryController.php
│   │   │   ├── TrackRecordController.php
│   │   │   ├── CertificationController.php
│   │   │   ├── ContactController.php
│   │   │   └── ClientController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── SettingController.php
│   │       ├── HeroController.php
│   │       ├── MenuController.php
│   │       ├── PackageController.php
│   │       ├── GalleryController.php
│   │       ├── ClientController.php
│   │       ├── CertificationController.php
│   │       ├── TrackRecordController.php
│   │       ├── TeamController.php
│   │       └── InquiryController.php
│   ├── Requests/
│   │   ├── ContactInquiryRequest.php
│   │   ├── Admin/StoreMenuItemRequest.php
│   │   └── ... (one per form)
│   └── Middleware/
│       └── AdminAuthenticated.php
├── Services/
│   ├── Front/
│   │   ├── HomePageService.php
│   │   ├── MenuService.php
│   │   ├── GalleryService.php
│   │   ├── ClientService.php
│   │   └── ContactService.php
│   └── Admin/
│       ├── ImageUploadService.php
│       ├── SettingService.php
│       ├── MenuAdminService.php
│       └── ... (one per domain)
├── Repositories/
│   ├── HeroRepository.php
│   ├── MenuRepository.php
│   ├── GalleryRepository.php
│   ├── ClientRepository.php
│   ├── CertificationRepository.php
│   ├── TrackRecordRepository.php
│   ├── PackageRepository.php
│   ├── SettingRepository.php
│   └── ContactInquiryRepository.php
├── Models/
│   ├── HeroSlide.php
│   ├── Menu.php
│   ├── MenuCategory.php
│   ├── MenuItem.php
│   ├── Package.php
│   ├── PackageItem.php
│   ├── PackageImage.php
│   ├── GalleryCategory.php
│   ├── GalleryImage.php
│   ├── Client.php
│   ├── Certification.php
│   ├── TrackRecord.php
│   ├── TeamMember.php
│   ├── ContactInquiry.php
│   └── Setting.php
└── Providers/
    └── RepositoryServiceProvider.php  ← binds interfaces to implementations
```

### Service Example: `HomePageService`

```php
namespace App\Services\Front;

use App\Repositories\HeroRepository;
use App\Repositories\ClientRepository;
use App\Repositories\PackageRepository;
use App\Repositories\MenuRepository;

class HomePageService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected ClientRepository $clientRepo,
        protected PackageRepository $packageRepo,
        protected MenuRepository $menuRepo,
    ) {}

    public function getHomeData(): array
    {
        return [
            'hero'        => $this->heroRepo->getActiveForPage('home'),
            'packages'    => $this->packageRepo->getActivePackages(),
            'cuisines'    => $this->menuRepo->getActiveCuisines(),
            'clients'     => $this->clientRepo->getMarqueeClients(),
            'settings'    => $this->settingRepo->getAll(),
        ];
    }
}
```

### Controller Example: `HomeController`

```php
namespace App\Http\Controllers\Front;

use App\Services\Front\HomePageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected HomePageService $homeService) {}

    public function index()
    {
        $data = $this->homeService->getHomeData();
        return view('front.home', $data);
    }
}
```

### `ImageUploadService`

```php
namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUploadService
{
    public function upload(UploadedFile $file, string $folder, int $maxWidth = 1920): string
    {
        $filename = uniqid() . '.' . $file->extension();
        $image = Image::make($file)
                      ->resize($maxWidth, null, fn($c) => $c->aspectRatio())
                      ->encode('jpg', 85);

        Storage::disk('public')->put("uploads/{$folder}/{$filename}", $image);
        return "uploads/{$folder}/{$filename}";
    }

    public function delete(string $path): void
    {
        if ($path) Storage::disk('public')->delete($path);
    }
}
```

### `SettingRepository`

```php
namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingRepository
{
    public function getAll(): array
    {
        return Cache::remember('settings', 3600, fn() =>
            Setting::pluck('value', 'key')->toArray()
        );
    }

    public function set(string $key, string $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }
}
```

### `RepositoryServiceProvider`

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Repositories\MenuRepository::class);
        $this->app->bind(\App\Repositories\ClientRepository::class);
        // ... bind all repositories
    }
}
```

---

## 9. Admin Panel Specification

The admin panel is a fully custom Laravel Blade application, **not a third-party panel like Filament or Nova**, accessible only at `/admin` after login.

### Admin Login Page (`/admin/login`)

Dark-themed login page matching site aesthetic:
- Background: `#0D0D0D` with the site logo centered.
- Card: `bg-[#111] border border-white/5 rounded-lg shadow-2xl p-8 w-full max-w-md`.
- Email + Password inputs in site's dark input style.
- Submit: full-width gold button.
- Error: `text-red-400` inline.

### Admin Dashboard (`/admin`)

After login, the admin sees a dashboard with:
- Sidebar: fixed left navigation with links to each module.
- Sidebar styling: `bg-[#0D0D0D] border-r border-white/5 w-64`.
- Active link: `bg-[#C9A84C]/10 text-[#C9A84C] border-l-4 border-[#C9A84C]`.
- Stats cards: count of Menus, Gallery Images, Clients, Certifications, New Inquiries.
- Recent Inquiries table.

### Admin Modules

Every module follows the same CRUD pattern with the same Blade layout.

**Module: Hero Slides**
- List table: page, headline (truncated), status, sort order, actions.
- Form: Page selector (dropdown), Image upload (with preview), Headline, Subheadline, CTA Text, CTA URL, Sort Order, Active toggle.
- Image preview: shows uploaded image immediately using Alpine.js `@change` + `URL.createObjectURL`.

**Module: Site Settings**
- A single long form page organized into fieldsets:
  - General (site name, tagline, SST notice)
  - Contact Info (phone 1, phone 2, email 1, email 2, WhatsApp number)
  - Business Hours text
  - Address & Maps (address textarea, Google Maps embed code)
  - About Page (about text — rich textarea or simple textarea)

**Module: Menus (Cuisines)**
- List: shows all 4 cuisines + any custom.
- Form: Name, Slug, Type (dropdown), Description (textarea), Cover Image, Sort Order, Active.

**Module: Menu Items**
- Parent select (which cuisine).
- Sub-category select or create.
- Form: Name, Description, Price, Price Note, Image, Tags (comma-separated), Available toggle, Sort Order.
- List with drag-to-reorder (Alpine.js + SortableJS library).

**Module: Packages**
- List of all packages (CNY, Christmas, etc.).
- Form:
  - Basic: Name, Slug, Tagline, Description, Cover Image, Active, Sort Order.
  - Package Items section: dynamic add/remove rows (Alpine.js): Name | Price | Description.
  - Package Gallery: multiple image upload, preview grid.

**Module: Gallery**
- Gallery Categories sub-module (CRUD).
- Gallery Images: multiple image uploader, category assignment, caption, alt text, sort order.
- Grid preview of all images with delete buttons.

**Module: Clients**
- List with logo preview.
- Form: Name, Logo Upload, Sector, Show in Marquee (toggle), Show in Clients Page (toggle), Sort Order, Active.

**Module: Certifications**
- Form: Name, Issuing Body, Certificate Image, Valid From, Valid Until, Description, Sort Order, Active.

**Module: Track Record**
- Form: Year, Title, Description, Client Name, Image, Sort Order.

**Module: Team Members**
- Form: Name, Role, Photo, Bio, Sort Order, Active.

**Module: Contact Inquiries**
- Read-only list of submitted inquiries.
- Click to view full inquiry.
- Mark as Read / Replied status toggle.
- Delete button.
- Count badge on sidebar link for unread inquiries.

### Admin Image Upload Pattern (Universal)

All image fields across all admin forms follow this exact Alpine.js pattern:

```html
<div x-data="{ preview: '{{ $existingImage ?? '' }}' }">
  <!-- Preview -->
  <div x-show="preview" class="mb-3">
    <img :src="preview" class="h-32 w-auto rounded-lg object-cover border border-white/10" />
  </div>

  <!-- Upload button -->
  <label class="cursor-pointer flex items-center gap-3 bg-[#1A1A1A] border border-dashed 
                border-white/20 hover:border-[#C9A84C]/50 rounded-lg p-4 transition-colors">
    <svg class="w-5 h-5 text-[#C9A84C]"><!-- upload icon --></svg>
    <span class="text-gray-400 text-sm">Click to upload image</span>
    <input type="file" name="image" accept="image/*" class="hidden"
           @change="preview = URL.createObjectURL($event.target.files[0])" />
  </label>
</div>
```

### Admin Drag-to-Reorder Pattern

For any list that needs reordering (Menu Items, Gallery, Clients, etc.):

```html
<div x-data="sortableList()" x-init="init()">
  <div id="sortable-container">
    @foreach($items as $item)
      <div class="sortable-item flex items-center gap-4 p-3 bg-[#111] border border-white/5 
                  rounded-lg mb-2 cursor-grab" data-id="{{ $item->id }}">
        <span class="text-gray-500">⠿</span> <!-- drag handle -->
        {{ $item->name }}
        <!-- actions -->
      </div>
    @endforeach
  </div>
</div>

<script>
function sortableList() {
  return {
    init() {
      Sortable.create(document.getElementById('sortable-container'), {
        onEnd: (evt) => {
          const ids = [...document.querySelectorAll('.sortable-item')]
                      .map(el => el.dataset.id);
          fetch('/admin/sort', { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken}, body: JSON.stringify({ ids }) });
        }
      });
    }
  }
}
</script>
```

---

## 10. Route Map

### Public Routes (`routes/web.php`)

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{cuisine:slug}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/menu/packages/{package:slug}', [MenuController::class, 'package'])->name('menu.package');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record');
Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications');
Route::get('/clients', [ClientController::class, 'index'])->name('clients');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
```

### Admin Routes (`routes/web.php`)

```php
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Authenticated
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('hero-slides', HeroController::class);
        Route::resource('menus', Admin\MenuController::class);
        Route::resource('menus.items', MenuItemController::class);
        Route::resource('packages', PackageController::class);
        Route::resource('gallery', GalleryController::class);
        Route::resource('gallery-categories', GalleryCategoryController::class);
        Route::resource('clients', Admin\ClientController::class);
        Route::resource('certifications', Admin\CertificationController::class);
        Route::resource('track-records', TrackRecordController::class);
        Route::resource('team', TeamController::class);
        Route::resource('inquiries', InquiryController::class)->only(['index','show','destroy']);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/sort', [SortController::class, 'update'])->name('sort.update');
        Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
    });
});
```

---

## 11. File & Media Management

All uploaded files go through `ImageUploadService`. Files are stored in `storage/app/public/uploads/{folder}/`. Run `php artisan storage:link` to create the symlink.

**Folder structure:**
```
storage/app/public/uploads/
├── hero/
├── menus/
├── menu-items/
├── packages/
├── package-images/
├── gallery/
├── clients/
├── certifications/
├── team/
└── track-records/
```

**URL helper:** In Blade, always use `asset(Storage::url($model->image_path))` or create an accessor:
```php
// In Model:
public function getImageUrlAttribute(): string
{
    return $this->image_path 
        ? asset(Storage::url($this->image_path)) 
        : asset('images/placeholder.jpg');
}
```

**Important:** The SRS states no placeholder images should appear on the frontend. The `placeholder.jpg` is only a fallback shown in admin previews until a real image is uploaded. Frontend templates must only render image tags when `image_path` is not null.

---

## 12. Responsive Breakpoint Rules

Using TailwindCSS v4's default breakpoints:

| Breakpoint | Min Width | Layout Behavior |
|-----------|-----------|----------------|
| `sm` | 640px | 2-col grids begin |
| `md` | 768px | 2-col or 3-col layouts, sidebar narrower |
| `lg` | 1024px | Full 2-col about section, 4-col client grid |
| `xl` | 1280px | Max content width enforced by `max-w-7xl` |

**Mobile-specific rules:**
- Sidebar is 100vw wide on mobile.
- Hero H1: `text-4xl` (mobile) → `text-7xl` (desktop).
- Cuisine grid: `grid-cols-1` (mobile) → `grid-cols-2` (tablet) → `grid-cols-2` (desktop, each card taller).
- Client marquee: same on all sizes, speed unchanged.
- Admin panel: sidebar collapses to top-bar on mobile. Content becomes full width.
- Parallax background: disabled on mobile (use `bg-scroll`).
- Timeline: single column on mobile, alternating on desktop.

---

## 13. Security & Authentication

**Admin authentication:**
- Single admin user seeded via `DatabaseSeeder`.
- Laravel's built-in `Hash::make()` for passwords.
- Session-based (no tokens on the admin side).
- `AdminAuthenticated` middleware: checks `auth()->guard('admin')->check()`.
- Rate limiting on login: 5 attempts per minute via `RateLimiter`.

**CSRF:** All forms include `@csrf`. AJAX sort requests include `X-CSRF-TOKEN` header.

**Input validation:** All form inputs validated via Form Request classes. Image uploads: `mimes:jpg,jpeg,png,webp|max:5120` (5MB max).

**XSS:** All user-supplied text rendered with `{{ }}` (Blade auto-escapes). Only admin-controlled rich text may use `{!! !!}`.

**SQL injection:** Eloquent ORM used exclusively — no raw queries.

**File upload security:** Validate MIME type server-side (not just extension). Store outside webroot, serve via `Storage::url()`.

---

## 14. Environment & Deployment Checklist

```env
APP_NAME="Sanjung Delights"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sanjungdelights.com

DB_CONNECTION=mysql
DB_DATABASE=sanjung_delights
DB_USERNAME=...
DB_PASSWORD=...

FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_FROM_ADDRESS=sales@sanjungwaja.com
MAIL_FROM_NAME="Sanjung Delights"
```

**Post-deploy commands:**
```bash
php artisan migrate --seed          # Migrate DB and seed admin user + settings
php artisan storage:link            # Create public storage symlink
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build                       # Compile TailwindCSS v4 + Alpine.js via Vite
```

**Admin Seeder:**
```php
// database/seeders/AdminSeeder.php
Admin::create([
    'name'     => 'Sanjung Admin',
    'email'    => 'admin@sanjungdelights.com',
    'password' => Hash::make('ChangeThisPassword!2026'),
]);
```

**Required packages:**
```bash
composer require intervention/image
npm install alpinejs sortablejs
```

**Vite config (`vite.config.js`):**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true }),
    ],
});
```

**`resources/css/app.css` (TailwindCSS v4):**
```css
@import "tailwindcss";
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap');

/* Custom animations and design tokens here */
```

**`resources/js/app.js`:**
```javascript
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// IntersectionObserver scroll animations
// ... (as defined in Section 4.1.4)
```

---

## Appendix A — Blade Layout Structure

```
resources/views/
├── layouts/
│   ├── front.blade.php          ← Main public layout (header + sidebar + footer)
│   └── admin.blade.php          ← Admin layout (admin sidebar + content)
├── components/
│   ├── front/
│   │   ├── sidebar.blade.php
│   │   ├── header.blade.php
│   │   ├── footer.blade.php
│   │   ├── hero.blade.php       ← Reusable hero with @props
│   │   ├── cuisine-card.blade.php
│   │   ├── gallery-lightbox.blade.php
│   │   └── scroll-animate.blade.php
│   └── admin/
│       ├── sidebar.blade.php
│       ├── header.blade.php
│       ├── image-upload.blade.php
│       └── data-table.blade.php
├── front/
│   ├── home.blade.php
│   ├── about.blade.php
│   ├── menu/
│   │   ├── index.blade.php
│   │   ├── show.blade.php       ← cuisine detail
│   │   └── package.blade.php
│   ├── gallery.blade.php
│   ├── track-record.blade.php
│   ├── certifications.blade.php
│   ├── contact.blade.php
│   └── clients.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── auth/
    │   └── login.blade.php
    ├── settings/
    │   └── index.blade.php
    ├── menus/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── items/
    │       ├── index.blade.php
    │       ├── create.blade.php
    │       └── edit.blade.php
    ├── packages/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── gallery/
    │   ├── index.blade.php
    │   └── create.blade.php
    ├── clients/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── certifications/
    ├── track-records/
    ├── team/
    └── inquiries/
        ├── index.blade.php
        └── show.blade.php
```

---

*End of SRS Document — Sanjung Delights v1.0*
*All specifications derived from live reference site analysis at https://sanjungdelights.com*
