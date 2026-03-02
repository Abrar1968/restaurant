<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Client;
use App\Models\ContactInquiry;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\HeroSlide;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Package;
use App\Models\PackageImage;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\TrackRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Path to the image collection folder.
     */
    protected string $imageSource;

    /**
     * @var array<string, string>
     */
    protected array $imageMap = [];

    public function run(): void
    {
        $this->imageSource = base_path('image_collection');
        $this->loadImageMap();
        $this->createUploadDirectories();

        $this->seedSettings();
        $this->seedHeroSlides();
        $this->seedMenusWithItems();
        $this->seedPackages();
        $this->seedGallery();
        $this->seedClients();
        $this->seedCertifications();
        $this->seedTrackRecords();
        $this->seedTeamMembers();
        $this->seedSampleInquiries();

        $this->command->info('Comprehensive seeding completed successfully!');
    }

    /**
     * Load all images from image_collection into a numbered map.
     */
    protected function loadImageMap(): void
    {
        if (! File::isDirectory($this->imageSource)) {
            $this->command->warn('image_collection directory not found. Seeding without images.');

            return;
        }

        $files = File::files($this->imageSource);
        foreach ($files as $file) {
            $name = $file->getFilename();
            if (preg_match('/^img_(\d{5})_/', $name, $matches)) {
                $this->imageMap[(int) $matches[1]] = $file->getPathname();
            }
        }

        $this->command->info('Found '.count($this->imageMap).' images in image_collection.');
    }

    /**
     * Create all upload directories.
     */
    protected function createUploadDirectories(): void
    {
        $folders = ['hero', 'menus', 'menu-items', 'packages', 'package-images', 'gallery', 'clients', 'certifications', 'team', 'track-records'];
        foreach ($folders as $folder) {
            Storage::disk('public')->makeDirectory("uploads/{$folder}");
        }
    }

    /**
     * Copy an image from image_collection to storage.
     */
    protected function copyImage(int $imageNumber, string $folder): ?string
    {
        if (! isset($this->imageMap[$imageNumber])) {
            return null;
        }

        $sourcePath = $this->imageMap[$imageNumber];
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $filename = Str::random(12).'_'.time().'.'.$extension;
        $destPath = "uploads/{$folder}/{$filename}";

        Storage::disk('public')->put($destPath, File::get($sourcePath));

        return $destPath;
    }

    protected function seedSettings(): void
    {
        $settings = [
            'site_name' => 'Sanjung Delights',
            'tagline' => 'Halal Corporate Catering in KL & Klang Valley',
            'phone_1' => '+60 16-220 4535',
            'phone_2' => '+60 3-8322 4535',
            'email_1' => 'sales@sanjungwaja.com',
            'email_2' => 'info@sanjungdelights.com',
            'whatsapp_number' => '60162204535',
            'address' => 'Wisma Suria, Pentagon Suite, Jalan Teknokrat 6, Cyber 5, 63000 Cyberjaya, Selangor',
            'business_hours' => 'MON-FRI: 9:00 AM – 6:00 PM | SAT: 9:00 AM – 1:00 PM',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.6!2d101.6!3d2.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sCyberjaya!5e0!3m2!1sen!2smy!4v1700000000000',
            'sst_notice' => 'All menu/food items price shown are subject to additional 6% SST.',
            'copyright_text' => '© 2026 SANJUNG WAJA RESOURCES. All Rights Reserved.',
            'about_text' => 'Established in 2010 under Sanjung Waja Resources, Sanjung Delights began with a clear mission: to elevate Malaysia\'s food and beverage experience through integrity, quality and innovation. What started as a modest operation has grown into a respected name in corporate & industrial catering, cafeteria management, food chandelling, and retail food services.',
            'hero_headline' => 'Halal Corporate Catering in KL & Klang Valley',
            'hero_subtext' => 'Your trusted partner for corporate events, training sessions, and seminars. Professional service with 100% halal-compliant cuisine.',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    protected function seedHeroSlides(): void
    {
        $slides = [
            ['page' => 'home', 'headline' => 'Halal Corporate Catering in KL & Klang Valley', 'subheadline' => 'Your trusted partner for corporate events, training sessions, and seminars. Professional service with 100% halal-compliant cuisine.', 'cta_text' => 'Explore More', 'cta_url' => '/about', 'image_num' => 1, 'sort_order' => 0],
            ['page' => 'home', 'headline' => 'Fantastic Food, Business Class Service', 'subheadline' => 'Refining corporate hospitality with a passion for excellence. We treat your business with the same dedication we treat our food.', 'cta_text' => 'View Our Menu', 'cta_url' => '/menu', 'image_num' => 2, 'sort_order' => 1],
            ['page' => 'about', 'headline' => 'About Sanjung Delights', 'subheadline' => 'Premium halal-compliant corporate catering in Klang Valley. Specialized in corporate events, training sessions, and special occasions.', 'cta_text' => null, 'cta_url' => null, 'image_num' => 3, 'sort_order' => 0],
            ['page' => 'menu', 'headline' => 'Our Menus', 'subheadline' => 'Diverse culinary offerings for every taste and occasion', 'cta_text' => null, 'cta_url' => null, 'image_num' => 4, 'sort_order' => 0],
            ['page' => 'gallery', 'headline' => 'Corporate Events Photo Gallery', 'subheadline' => 'Showcasing our halal-compliant corporate catering excellence across Malaysia\'s leading companies and organizations.', 'cta_text' => null, 'cta_url' => null, 'image_num' => 5, 'sort_order' => 0],
            ['page' => 'track-record', 'headline' => 'Our Legacy & Growth', 'subheadline' => 'Building trust through culinary excellence since 2012', 'cta_text' => 'Partner With Us', 'cta_url' => '/contact', 'image_num' => 6, 'sort_order' => 0],
            ['page' => 'certifications', 'headline' => 'Our Certifications', 'subheadline' => 'Commitment to Quality, Safety, and Halal Integrity.', 'cta_text' => null, 'cta_url' => null, 'image_num' => 7, 'sort_order' => 0],
            ['page' => 'contact', 'headline' => 'Contact Us', 'subheadline' => 'Get in touch for your corporate catering needs', 'cta_text' => null, 'cta_url' => null, 'image_num' => 8, 'sort_order' => 0],
            ['page' => 'clients', 'headline' => 'Trusted by Industry Leaders', 'subheadline' => 'Serving excellence to Malaysia\'s leading corporations', 'cta_text' => 'Join Our Clients', 'cta_url' => '/contact', 'image_num' => 9, 'sort_order' => 0],
        ];

        foreach ($slides as $slide) {
            HeroSlide::query()->updateOrCreate(
                ['page' => $slide['page'], 'headline' => $slide['headline']],
                [
                    'image_path' => $this->copyImage($slide['image_num'], 'hero'),
                    'subheadline' => $slide['subheadline'],
                    'cta_text' => $slide['cta_text'],
                    'cta_url' => $slide['cta_url'],
                    'sort_order' => $slide['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedMenusWithItems(): void
    {
        $menus = [
            [
                'name' => 'Malay Cuisine',
                'slug' => 'malay',
                'cuisine_type' => 'malay',
                'description' => "Sanjung Delights celebrates Malaysia's rich culinary heritage with a menu that honours tradition. Our Halal-compliant Malay cuisine combines authentic spices and time-honoured recipes to deliver a dining experience that is both nostalgic and refined, perfect for any corporate or private gathering.",
                'image_num' => 10,
                'categories' => [
                    'Rice & Noodle Dishes' => ['Nasi Lemak', 'Nasi Tomato', 'Nasi Minyak', 'Nasi Hujan Panas', 'Nasi Briyani', 'Mee Goreng Mamak', 'Bee Hoon Goreng', 'Kuey Teow Goreng', 'Lontong', 'Laksa'],
                    'Poultry Dishes' => ['Ayam Masak Merah', 'Ayam Rendang', 'Ayam Percik', 'Ayam Masak Kicap', 'Ayam Goreng Berempah', 'Ayam Goreng Kunyit', 'Ayam Masak Kurma', 'Ayam Masak Lemak Cili Padi', 'Sambal Ayam', 'Gulai Ayam'],
                    'Seafood & Fish Dishes' => ['Asam Pedas Ikan', 'Ikan Bakar', 'Ikan Goreng Kunyit', 'Gulai Ikan', 'Sambal Ikan', 'Sambal Udang', 'Udang Goreng Kunyit', 'Sambal Sotong', 'Sotong Goreng Kunyit', 'Sambal Kerang'],
                    'Meat Dishes' => ['Rendang Daging', 'Daging Goreng Kunyit', 'Gulai Daging', 'Daging Masak Kicap', 'Sambal Daging', 'Kambing Kurma', 'Gulai Kambing', 'Rendang Kambing', 'Sambal Paru', 'Dalca'],
                    'Vegetable Dishes' => ['Sayur Lodeh', 'Sayur Campur', 'Acar Jelatah', 'Acar Timun Nenas', 'Kerabu Mangga', 'Kerabu Kacang Botol', 'Sambal Terung', 'Sambal Tempe & Tauhu', 'Telur Sambal', 'Caru'],
                    'Condiments & Sides' => ['Sambal Belacan', 'Sambal Kicap', 'Serunding Daging', 'Serunding Ayam', 'Ikan Bilis Goreng', 'Kacang Goreng', 'Keropok', 'Papadom'],
                ],
            ],
            [
                'name' => 'Chinese Cuisine',
                'slug' => 'chinese',
                'cuisine_type' => 'chinese',
                'description' => 'Sanjung Delights brings you the best of Chinese culinary traditions, prepared with adherence to strict Halal standards. From wok-fried specialties to delicate steamed dishes, our menus are crafted to provide a harmonious and flavorful addition to your event.',
                'image_num' => 11,
                'categories' => [
                    'Rice & Noodle Dishes' => ['Yang Chow Fried Rice', 'Golden Fried Rice', 'Egg Fried Rice', 'Salted Fish Fried Rice', 'Tomato Fried Rice', 'Fried Hor Fun', 'Cantonese Fried Noodle', 'Hong Kong Noodle', 'Yee Mee with Silken Sauce', 'Stir Fried Kuey Teow'],
                    'Chicken Dishes' => ['Steamed Herbal Chicken', 'Kung Po Chicken', 'Sweet & Sour Chicken', 'Oyster Sauce Chicken', 'Sesame Marmite Chicken', 'Lemon Chicken', 'Orange Chicken', 'Black Pepper Chicken', 'Butter Chicken', 'Ginger Soy Chicken'],
                    'Seafood Dishes' => ['Sweet & Sour Fish Fillet', 'Steamed Fish with Ginger', 'Fish Fillet with Salted Egg Sauce', 'Kung Po Fish', 'Thai Style Fish', 'Kung Po Prawns', 'Salted Egg Prawns', 'Sweet & Sour Prawns', 'Black Pepper Prawns', 'Butter Prawns'],
                    'Meat Dishes' => ['Black Pepper Beef', 'Oyster Sauce Beef', 'Mongolian Beef', 'Ginger Beef', 'Broccoli Beef', 'Kam Heong Lamb', 'Mongolian Lamb', 'Black Pepper Lamb', 'Ginger Lamb', 'Sizzling Lamb'],
                    'Vegetable & Tofu Dishes' => ['Mixed Vegetables with Oyster Sauce', 'Stir Fried Kailan', 'Pak Choy with Garlic', 'Four Season Vegetables', 'Mushroom with Vegetables', 'Braised Tofu', 'Japanese Tofu with Mushroom', 'Silken Tofu with Egg', 'Mapo Tofu', 'Bean Curd Rolls'],
                    'Soups' => ['Hot & Sour Soup', 'Sweet Corn Soup', 'Egg Drop Soup', 'Winter Melon Soup', 'Chicken Mushroom Soup', 'Seafood Tofu Soup', 'Watercress Soup', 'Herbal Chicken Soup'],
                ],
            ],
            [
                'name' => 'Indian Cuisine',
                'slug' => 'indian',
                'cuisine_type' => 'indian',
                'description' => 'Immerse your guests in the aromatic world of Indian cuisine with Sanjung Delights. Our chefs expertly blend spices to create fragrant biryanis, rich curries, and tandoori classics, offering a vibrant and authentic taste of India for your special occasion.',
                'image_num' => 12,
                'categories' => [
                    'Rice & Bread' => ['Chicken Briyani', 'Mutton Briyani', 'Vegetable Briyani', 'Nasi Kandar', 'Lemon Rice', 'Chapati', 'Naan', 'Roti Canai', 'Thosai', 'Papadom'],
                    'Chicken Dishes' => ['Butter Chicken', 'Chicken Tikka Masala', 'Tandoori Chicken', 'Chicken Korma', 'Chicken Vindaloo', 'Chicken Curry', 'Palak Chicken', 'Chicken Madras', 'Chicken Jalfrezi', 'Chicken 65'],
                    'Meat Dishes' => ['Mutton Korma', 'Mutton Curry', 'Mutton Rogan Josh', 'Mutton Vindaloo', 'Keema Masala', 'Lamb Curry', 'Lamb Madras', 'Beef Curry', 'Dalca', 'Rendang (Indian Style)'],
                    'Seafood Dishes' => ['Fish Masala', 'Fish Curry', 'Tandoori Fish', 'Fish Tikka', 'Prawn Masala', 'Butter Prawns', 'Prawn Curry', 'Tandoori Prawns'],
                    'Vegetarian Dishes' => ['Palak Paneer', 'Paneer Tikka Masala', 'Paneer Butter Masala', 'Aloo Gobi', 'Mixed Vegetable Curry', 'Chana Masala', 'Dal Tadka', 'Dal Makhani', 'Baingan Bharta', 'Bhindi Masala', 'Vegetable Jalfrezi', 'Kadai Vegetables'],
                    'Accompaniments' => ['Raita (Yogurt Salad)', 'Mint Chutney', 'Mango Chutney', 'Tamarind Chutney', 'Cucumber Raita', 'Pickle (Achar)', 'Onion Salad', 'Vadai'],
                ],
            ],
            [
                'name' => 'Western Cuisine',
                'slug' => 'western',
                'cuisine_type' => 'western',
                'description' => "Sanjung Delights presents a sophisticated selection of Western favorites. Whether it's succulent grilled meats, creamy pastas, or hearty sides, our Western cuisine menu is designed to offer comfort and elegance, perfectly suited for modern corporate dining.",
                'image_num' => 13,
                'categories' => [
                    'Chicken Dishes' => ['Roasted Chicken', 'Grilled Chicken Chop', 'Chicken Cordon Bleu', 'Lemon Herb Chicken', 'BBQ Chicken', 'Chicken Schnitzel', 'Honey Mustard Chicken', 'Mushroom Chicken', 'Black Pepper Chicken', 'Teriyaki Chicken'],
                    'Seafood & Fish' => ['Grilled Fish with Lemon Butter', 'Baked Fish with Herbs', 'Fish & Chips', 'Creamy Dory Fish', 'Salmon Steak', 'Grilled Prawns', 'Garlic Butter Prawns', 'Creamy Seafood', 'Seafood Aglio Olio', 'Prawn Scampi'],
                    'Meat Dishes' => ['Beef Steak', 'Grilled Beef', 'Beef Stroganoff', 'Black Pepper Beef', 'Beef Bolognese', 'Lamb Chop', 'Lamb Stew', 'Roasted Lamb', 'BBQ Ribs', 'Meatballs'],
                    'Pasta Selections' => ['Spaghetti Carbonara', 'Spaghetti Bolognese', 'Spaghetti Aglio Olio', 'Penne Alfredo', 'Penne Arrabbiata', 'Seafood Pasta', 'Chicken Pasta', 'Lasagna', 'Mac & Cheese', 'Fettuccine'],
                    'Soups' => ['Cream of Mushroom', 'Cream of Chicken', 'Cream of Tomato', 'Pumpkin Soup', 'Minestrone', 'Vegetable Soup', 'Seafood Chowder', 'French Onion Soup'],
                    'Sides & Salads' => ['Garlic Herb Potatoes', 'Mashed Potatoes', 'French Fries', 'Grilled Vegetables', 'Sautéed Mushrooms', 'Caesar Salad', 'Garden Salad', 'Coleslaw', 'Garlic Bread', 'Dinner Rolls'],
                ],
            ],
        ];

        $menuImageCounter = 10;
        foreach ($menus as $menuData) {
            $menu = Menu::query()->updateOrCreate(
                ['slug' => $menuData['slug']],
                [
                    'name' => $menuData['name'],
                    'cuisine_type' => $menuData['cuisine_type'],
                    'description' => $menuData['description'],
                    'cover_image_path' => $this->copyImage($menuData['image_num'], 'menus'),
                    'is_active' => true,
                    'sort_order' => $menuImageCounter - 10,
                ]
            );

            $catOrder = 0;
            foreach ($menuData['categories'] as $categoryName => $items) {
                $category = MenuCategory::query()->updateOrCreate(
                    ['menu_id' => $menu->id, 'name' => $categoryName],
                    ['sort_order' => $catOrder++]
                );

                $itemOrder = 0;
                foreach ($items as $itemName) {
                    MenuItem::query()->updateOrCreate(
                        ['menu_id' => $menu->id, 'name' => $itemName],
                        [
                            'menu_category_id' => $category->id,
                            'description' => null,
                            'price' => null,
                            'price_note' => null,
                            'is_halal' => true,
                            'is_available' => true,
                            'sort_order' => $itemOrder++,
                        ]
                    );
                }
            }

            $menuImageCounter++;
        }
    }

    protected function seedPackages(): void
    {
        $packages = [
            [
                'name' => 'The Blazing Horse 2026 CNY Catering Package',
                'slug' => 'cny-catering-package-2026',
                'tagline' => 'Celebrate the Year of the Horse with our exquisite Halal-compliant catering selections.',
                'description' => 'Ring in the Chinese New Year with Sanjung Delights\' specially curated CNY Catering Package. Our halal-compliant menu features a delightful fusion of traditional Chinese New Year dishes, perfect for corporate celebrations and festive gatherings.',
                'image_num' => 14,
            ],
            [
                'name' => '2025 Christmas Catering Menu',
                'slug' => 'christmas-catering-package-2025',
                'tagline' => 'Festive Halal-compliant catering for the holiday season.',
                'description' => 'Celebrate the festive season with Sanjung Delights\' Christmas Catering Menu. Featuring a premium selection of Western and fusion dishes, our holiday menu is designed to bring warmth and joy to your corporate Christmas celebrations.',
                'image_num' => 15,
            ],
            [
                'name' => 'Seasonal & Festive Menus',
                'slug' => 'seasonal-menus',
                'tagline' => 'Special menus for celebrations and festive occasions',
                'description' => 'From Hari Raya to Deepavali, Christmas to Chinese New Year — our seasonal menus bring festive flavors to your corporate celebrations, all prepared with strict halal compliance.',
                'image_num' => 16,
            ],
        ];

        foreach ($packages as $index => $packageData) {
            $package = Package::query()->updateOrCreate(
                ['slug' => $packageData['slug']],
                [
                    'name' => $packageData['name'],
                    'tagline' => $packageData['tagline'],
                    'description' => $packageData['description'],
                    'cover_image_path' => $this->copyImage($packageData['image_num'], 'packages'),
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );

            // Add package images
            for ($i = 0; $i < 2; $i++) {
                $imgNum = $packageData['image_num'] + $i + 3;
                $imgPath = $this->copyImage($imgNum, 'package-images');
                if ($imgPath) {
                    PackageImage::query()->updateOrCreate(
                        ['package_id' => $package->id, 'sort_order' => $i],
                        ['image_path' => $imgPath, 'caption' => $packageData['name'].' - Image '.($i + 1)]
                    );
                }
            }
        }
    }

    protected function seedGallery(): void
    {
        $categories = [
            ['name' => 'Corporate', 'slug' => 'corporate'],
            ['name' => 'Events', 'slug' => 'events'],
            ['name' => 'Clients', 'slug' => 'clients'],
            ['name' => 'Food & Buffet', 'slug' => 'food-buffet'],
        ];

        $createdCategories = [];
        foreach ($categories as $index => $cat) {
            $createdCategories[$cat['slug']] = GalleryCategory::query()->updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'sort_order' => $index]
            );
        }

        // Map images 25-65 to gallery categories
        $galleryImages = [
            ['num' => 25, 'cat' => 'corporate', 'caption' => 'Corporate Event Setup'],
            ['num' => 26, 'cat' => 'corporate', 'caption' => 'Professional Catering Service'],
            ['num' => 27, 'cat' => 'events', 'caption' => 'Corporate Event Catering'],
            ['num' => 28, 'cat' => 'events', 'caption' => 'Hirose Opening Ceremony'],
            ['num' => 29, 'cat' => 'food-buffet', 'caption' => 'Hirose Opening Food Display'],
            ['num' => 30, 'cat' => 'food-buffet', 'caption' => 'Premium Buffet Setup'],
            ['num' => 31, 'cat' => 'food-buffet', 'caption' => 'Corporate Lunch Spread'],
            ['num' => 32, 'cat' => 'food-buffet', 'caption' => 'Traditional Kuih-Muih'],
            ['num' => 33, 'cat' => 'food-buffet', 'caption' => 'Makmur Pandan'],
            ['num' => 34, 'cat' => 'food-buffet', 'caption' => 'Makmur Putih'],
            ['num' => 35, 'cat' => 'corporate', 'caption' => 'Mini Mart Setup'],
            ['num' => 36, 'cat' => 'food-buffet', 'caption' => 'Nasi Beriani Display'],
            ['num' => 37, 'cat' => 'food-buffet', 'caption' => 'Nasi Briyani Serving'],
            ['num' => 38, 'cat' => 'food-buffet', 'caption' => 'Nasi Lemak Preparation'],
            ['num' => 39, 'cat' => 'events', 'caption' => 'Team Service in Action'],
            ['num' => 40, 'cat' => 'corporate', 'caption' => 'Corporate Dining Setup'],
            ['num' => 41, 'cat' => 'food-buffet', 'caption' => 'Fine Dining Presentation'],
            ['num' => 42, 'cat' => 'events', 'caption' => 'Seminar Catering'],
            ['num' => 43, 'cat' => 'food-buffet', 'caption' => 'Western Menu Display'],
            ['num' => 44, 'cat' => 'corporate', 'caption' => 'Conference Catering'],
            ['num' => 45, 'cat' => 'food-buffet', 'caption' => 'Dessert Station'],
            ['num' => 46, 'cat' => 'events', 'caption' => 'Training Session Lunch'],
            ['num' => 47, 'cat' => 'food-buffet', 'caption' => 'Premium Meat Dishes'],
            ['num' => 48, 'cat' => 'clients', 'caption' => 'Industrial Canteen Service'],
            ['num' => 49, 'cat' => 'clients', 'caption' => 'Factory Cafeteria Management'],
            ['num' => 50, 'cat' => 'events', 'caption' => 'Gala Dinner Catering'],
            ['num' => 51, 'cat' => 'food-buffet', 'caption' => 'Seafood Delights'],
            ['num' => 52, 'cat' => 'corporate', 'caption' => 'Annual Dinner Event'],
            ['num' => 53, 'cat' => 'food-buffet', 'caption' => 'Chinese Cuisine Spread'],
            ['num' => 54, 'cat' => 'events', 'caption' => 'Award Ceremony Dinner'],
            ['num' => 55, 'cat' => 'food-buffet', 'caption' => 'Pastry & Bakery Items'],
        ];

        foreach ($galleryImages as $index => $imageData) {
            $imgPath = $this->copyImage($imageData['num'], 'gallery');
            if ($imgPath) {
                GalleryImage::query()->updateOrCreate(
                    ['caption' => $imageData['caption']],
                    [
                        'gallery_category_id' => $createdCategories[$imageData['cat']]->id,
                        'image_path' => $imgPath,
                        'alt_text' => $imageData['caption'].' - Sanjung Delights',
                        'sort_order' => $index,
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    protected function seedClients(): void
    {
        $clients = [
            ['name' => 'DRB-HICOM', 'sector' => 'corp', 'image_num' => 56],
            ['name' => 'Shin-Etsu Chemical', 'sector' => 'industrial', 'image_num' => 57],
            ['name' => 'Mitsui Copper Foil (MCF)', 'sector' => 'industrial', 'image_num' => 58],
            ['name' => 'Panasonic', 'sector' => 'industrial', 'image_num' => 59],
            ['name' => 'Perodua Manufacturing', 'sector' => 'industrial', 'image_num' => 60],
            ['name' => 'Johor Port', 'sector' => 'gov', 'image_num' => 61],
            ['name' => 'Avery Dennison', 'sector' => 'industrial', 'image_num' => 62],
            ['name' => 'CCM Chemical', 'sector' => 'industrial', 'image_num' => 63],
            ['name' => 'Hospital Banting', 'sector' => 'gov', 'image_num' => 64],
            ['name' => 'Adient Automotive', 'sector' => 'industrial', 'image_num' => 65],
            ['name' => 'KATO Manufacturing', 'sector' => 'industrial', 'image_num' => 66],
            ['name' => 'Idemitsu SM', 'sector' => 'industrial', 'image_num' => 67],
        ];

        foreach ($clients as $index => $clientData) {
            Client::query()->updateOrCreate(
                ['name' => $clientData['name']],
                [
                    'logo_path' => $this->copyImage($clientData['image_num'], 'clients'),
                    'sector' => $clientData['sector'],
                    'show_in_marquee' => true,
                    'show_in_clients_page' => true,
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedCertifications(): void
    {
        $certs = [
            [
                'name' => 'JAKIM Halal Certification',
                'issuing_body' => 'Jabatan Kemajuan Islam Malaysia (JAKIM)',
                'description' => 'Official Halal certification ensuring all food preparation processes meet the highest Halal standards.',
                'valid_from' => '2024-01-01',
                'valid_until' => '2026-12-31',
                'image_num' => 68,
            ],
            [
                'name' => 'FOSIM Compliance',
                'issuing_body' => 'Ministry of Health Malaysia',
                'description' => 'Food Safety Information System of Malaysia compliance certification.',
                'valid_from' => '2024-01-01',
                'valid_until' => '2026-12-31',
                'image_num' => 69,
            ],
            [
                'name' => 'MOF Registered – Bidang Masakan Islam',
                'issuing_body' => 'Ministry of Finance Malaysia',
                'description' => 'Registered with the Ministry of Finance under Bidang Masakan Islam category.',
                'valid_from' => '2024-01-01',
                'valid_until' => '2026-12-31',
                'image_num' => 70,
            ],
        ];

        foreach ($certs as $index => $certData) {
            Certification::query()->updateOrCreate(
                ['name' => $certData['name']],
                [
                    'issuing_body' => $certData['issuing_body'],
                    'certificate_image_path' => $this->copyImage($certData['image_num'], 'certifications'),
                    'valid_from' => $certData['valid_from'],
                    'valid_until' => $certData['valid_until'],
                    'description' => $certData['description'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedTrackRecords(): void
    {
        $records = [
            ['year' => 2026, 'title' => 'Future Goal', 'description' => 'Targeting 5,000 pax/day as In-House Canteen Operator & Preferred Corporate Caterer in Klang Valley.', 'client_name' => null],
            ['year' => 2023, 'title' => 'Major Expansion', 'description' => 'Expanded operations with significant new partnerships. Total: 2,200 pax/day', 'client_name' => null],
            ['year' => 2022, 'title' => 'CSR & Community', 'description' => 'Conducted CSR food programs for hospitals, giving back to the community during critical times.', 'client_name' => null],
            ['year' => 2022, 'title' => 'Southern Region Entry', 'description' => 'Entered Southern Region with a massive 1,200 pax/day industrial catering contract, marking our territorial expansion.', 'client_name' => null],
            ['year' => 2021, 'title' => 'Post-Pandemic Rebound', 'description' => "Strong recovery with 5 new corporate contracts signed. Launched new 'Healthy Eating' corporate menu options to adapt to post-Covid wellness trends.", 'client_name' => null],
            ['year' => 2020, 'title' => 'Central Kitchen Optimization', 'description' => 'Adopted Central Kitchen model to increase efficiency and consistency across all sites. Increased daily production capacity to 3,500 pax.', 'client_name' => null],
            ['year' => 2019, 'title' => 'Pandemic Resilience', 'description' => 'Continued full operations as an essential service provider using rigorous safety protocols. Provided daily meals for frontliners and factory workers.', 'client_name' => null],
            ['year' => 2017, 'title' => 'Halal Certification', 'description' => 'Rebranded as Sanjung Delights. Achieved official Halal Certification from JAKIM, solidifying trust with Muslim clientele.', 'client_name' => 'JAKIM'],
            ['year' => 2016, 'title' => 'New Markets', 'description' => 'Expanded into wedding catering and event services. Secured contract with a Japanese electronics multinational in Shah Alam (1,500 pax/day).', 'client_name' => null],
            ['year' => 2015, 'title' => 'Industrial Expansion', 'description' => 'Started new operation for a semiconductor factory in Shah Alam (800 pax/day). Awarded "A" Grading for canteen cleanliness.', 'client_name' => null],
            ['year' => 2013, 'title' => 'Rapid Growth', 'description' => 'Expanded to 2,300 pax/day for a US-based medical device manufacturer in Kulim, establishing our capability for large-scale operations.', 'client_name' => null],
            ['year' => 2012, 'title' => 'The Beginning', 'description' => 'Launched first soup stall at USJ 19. Soon began 500 pax/day in-house catering for a medical device plant in Kulim.', 'client_name' => null],
        ];

        foreach ($records as $index => $record) {
            TrackRecord::query()->updateOrCreate(
                ['year' => $record['year'], 'title' => $record['title']],
                [
                    'description' => $record['description'],
                    'client_name' => $record['client_name'],
                    'image_path' => ($index < 3) ? $this->copyImage(71 + $index, 'track-records') : null,
                    'sort_order' => $index,
                ]
            );
        }
    }

    protected function seedTeamMembers(): void
    {
        $members = [
            ['name' => 'Ahmad Razif', 'role' => 'Managing Director', 'bio' => 'With over 15 years of experience in the food & beverage industry, Ahmad leads the company with a passion for culinary excellence and business growth.', 'image_num' => 74],
            ['name' => 'Siti Nurhaliza', 'role' => 'Operations Manager', 'bio' => 'Siti oversees all catering operations, ensuring seamless delivery and consistent quality across every event.', 'image_num' => 75],
            ['name' => 'Chef Kamal', 'role' => 'Head Chef', 'bio' => 'Chef Kamal brings decades of culinary expertise, crafting authentic Malaysian, Chinese, Indian and Western menus that delight corporate clients.', 'image_num' => 76],
        ];

        foreach ($members as $index => $member) {
            TeamMember::query()->updateOrCreate(
                ['name' => $member['name']],
                [
                    'role' => $member['role'],
                    'photo_path' => $this->copyImage($member['image_num'], 'team'),
                    'bio' => $member['bio'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedSampleInquiries(): void
    {
        $inquiries = [
            ['name' => 'Sarah Tan', 'company' => 'DRB-HICOM Berhad', 'email' => 'sarah.tan@drbhicom.com', 'phone' => '+60 12-345-6789', 'event_type' => 'Conference / Seminar', 'expected_guests' => 200, 'event_date' => now()->addDays(30)->toDateString(), 'message' => 'We would like to arrange catering for our annual conference. Please share your menu options.', 'status' => 'new'],
            ['name' => 'Raj Kumar', 'company' => 'Panasonic Malaysia', 'email' => 'raj.kumar@panasonic.com.my', 'phone' => '+60 13-456-7890', 'event_type' => 'Company Gathering', 'expected_guests' => 500, 'event_date' => now()->addDays(45)->toDateString(), 'message' => 'Looking for catering services for our year-end gathering. Need both Malay and Indian cuisine.', 'status' => 'read'],
            ['name' => 'Lim Wei', 'company' => 'Shin-Etsu Chemical', 'email' => 'lim.wei@shinetsu.com', 'phone' => '+60 19-876-5432', 'event_type' => 'Corporate Meeting', 'expected_guests' => 50, 'event_date' => now()->addDays(14)->toDateString(), 'message' => 'Need corporate lunch catering for an executive meeting. Budget: RM30 per pax.', 'status' => 'replied'],
        ];

        foreach ($inquiries as $inquiry) {
            ContactInquiry::query()->updateOrCreate(
                ['email' => $inquiry['email'], 'event_type' => $inquiry['event_type']],
                $inquiry
            );
        }
    }
}
