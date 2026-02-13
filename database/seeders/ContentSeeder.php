<?php

namespace Database\Seeders;

use App\Models\{
    HeroBanner,
    Service,
    PopularDish,
    MenuCategory,
    MenuItem,
    Stat,
    Event,
    TeamMember,
    Testimonial,
    Faq
};
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Truncate tables
        HeroBanner::truncate();
        Service::truncate();
        PopularDish::truncate();
        MenuCategory::truncate();
        MenuItem::truncate();
        Stat::truncate();
        Event::truncate();
        TeamMember::truncate();
        Testimonial::truncate();
        Faq::truncate();

        // Enable foreign key checks
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        // Hero Banners - Using existing frontend images
        HeroBanner::create([
            'subtitle' => 'Authentic South Indian',
            'title' => 'Taste the Tradition',
            'description' => 'Experience the rich flavors of authentic South Indian cuisine crafted with love and tradition.',
            'button_text_1' => 'Book Now',
            'button_link_1' => '/booking',
            'button_text_2' => 'View Menu',
            'button_link_2' => '/menu',
            'image' => 'assets/images/hero/hero-slide-1.png',
            'is_active' => true,
            'order' => 1,
        ]);

        HeroBanner::create([
            'subtitle' => 'Celebrate Your Events',
            'title' => 'Perfect Catering for Every Occasion',
            'description' => 'From weddings to corporate events, we bring the finest catering experience to your special moments.',
            'button_text_1' => 'Our Events',
            'button_link_1' => '/events',
            'button_text_2' => 'Contact Us',
            'button_link_2' => '/contact',
            'image' => 'assets/images/hero/hero-slide-2.png',
            'is_active' => true,
            'order' => 2,
        ]);

        HeroBanner::create([
            'subtitle' => 'Premium Service',
            'title' => 'Excellence in Every Bite',
            'description' => 'Our expert chefs ensure every dish is a masterpiece, delivering unforgettable culinary experiences.',
            'button_text_1' => 'Get Quote',
            'button_link_1' => '/contact',
            'button_text_2' => 'About Us',
            'button_link_2' => '/about',
            'image' => 'assets/images/hero/hero-slide-3.jpg',
            'is_active' => true,
            'order' => 3,
        ]);

        // Services
        $services = [
            ['name' => 'Wedding Services', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/wedding.svg', 'desc' => 'Make your wedding day perfect with our exceptional catering services and elegant presentation.'],
            ['name' => 'Corporate Catering', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/corporate.svg', 'desc' => 'Professional catering solutions for your corporate events and business meetings.'],
            ['name' => 'Cocktail Reception', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/cocktail.svg', 'desc' => 'Elegant cocktail receptions with a variety of appetizers and beverages.'],
            ['name' => 'Bento Catering', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/bento.svg', 'desc' => 'Individually portioned bento boxes perfect for any occasion and dietary preference.'],
            ['name' => 'Buffet Catering', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/buffet.svg', 'desc' => 'All-you-can-eat buffet style catering with diverse menu options for large gatherings.'],
            ['name' => 'Sit-Down Catering', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/sit-down.svg', 'desc' => 'Formal sit-down dining experience with plated meals and professional table service.'],
            ['name' => 'Home Delivery', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/home.svg', 'desc' => 'Convenient home delivery service bringing quality catered meals to your doorstep.'],
            ['name' => 'Pub Party', 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/pub.svg', 'desc' => 'Casual pub-style catering perfect for relaxed gatherings and social events.']
        ];
        foreach ($services as $index => $service) {
            Service::create([
                'name' => $service['name'],
                'description' => $service['desc'],
                'icon' => $service['icon'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }

        // Popular Dishes
        for ($i = 1; $i <= 6; $i++) {
            PopularDish::create([
                'name' => 'Delicious Item ' . $i,
                'price' => 50 + ($i * 10),
                'image' => 'assets/images/main/dish/0' . $i . '.jpg',
                'rating' => 3.5,
                'is_active' => true,
                'order' => $i,
            ]);
        }

        // Menu Categories
        $categories = [
            ['name' => 'Evening Snacks', 'slug' => 'evening-snacks'],
            ['name' => 'Soup Varieties', 'slug' => 'soup-varieties'],
            ['name' => 'Fresh Juice Counter', 'slug' => 'fresh-juice-counter'],
            ['name' => 'Sweets & Desserts', 'slug' => 'sweets-desserts'],
            ['name' => 'Idly Varieties', 'slug' => 'idly-varieties'],
            ['name' => 'Biriyani & Pulao', 'slug' => 'biriyani-pulao'],
            ['name' => 'Bread Varieties', 'slug' => 'bread-varieties'],
            ['name' => 'Salads', 'slug' => 'salads'],
            ['name' => 'Pasta', 'slug' => 'pasta'],
            ['name' => 'Pizza & Burgers', 'slug' => 'pizza-burgers'],
            ['name' => 'Dosa / Roast Varieties', 'slug' => 'dosa-roast-varieties'],
            ['name' => 'Ice Cream Varieties', 'slug' => 'ice-cream-varieties'],
            ['name' => 'Variety Rice', 'slug' => 'variety-rice'],
        ];
        foreach ($categories as $index => $cat) {
            MenuCategory::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }

        // Menu Items - Starter
        $starters = [
            ['name' => 'Paneer', 'price' => 70, 'img' => '01.png'],
            ['name' => 'Gobi 65', 'price' => 60, 'img' => '06.png'],
            ['name' => 'Sweet Potato', 'price' => 20, 'img' => '02.png'],
            ['name' => 'Paneer Tikka', 'price' => 80, 'img' => '07.png'],
            ['name' => 'Sabudana Tikki', 'price' => 20, 'img' => '03.png'],
            ['name' => 'Blooming Onion', 'price' => 20, 'img' => '08.png'],
            ['name' => 'Crispy Corn', 'price' => 20, 'img' => '04.png'],
            ['name' => 'Sweet Corn', 'price' => 20, 'img' => '09.png'],
            ['name' => 'Veg Pizza', 'price' => 20, 'img' => '05.png'],
            ['name' => 'Corn Kebabs', 'price' => 20, 'img' => '10.png']
        ];
        foreach ($starters as $index => $item) {
            MenuItem::create([
                'category_id' => 1,
                'name' => $item['name'],
                'description' => 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.',
                'price' => $item['price'],
                'image' => 'assets/images/main/menu/' . $item['img'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }

        // Menu Items - Main Course
        for ($i = 1; $i <= 6; $i++) {
            MenuItem::create([
                'category_id' => 2,
                'name' => 'Main Course ' . $i,
                'description' => 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.',
                'price' => 40 + ($i * 10),
                'image' => 'assets/images/main/menu/main-course/0' . $i . '.png',
                'is_active' => true,
                'order' => $i,
            ]);
        }

        // Stats
        $stats = [
            ['title' => 'Happy Customers', 'value' => 786, 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/c1.svg'],
            ['title' => 'Expert Chefs', 'value' => 109, 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/c2.svg'],
            ['title' => 'Years Of Experience', 'value' => 23, 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/c3.svg'],
            ['title' => 'Events Completed', 'value' => 235, 'icon' => 'https://kamleshyadav.com/html/catering/html/assets/images/main/c4.svg'],
        ];
        foreach ($stats as $index => $stat) {
            Stat::create([
                'title' => $stat['title'],
                'value' => $stat['value'],
                'icon' => $stat['icon'],
                'order' => $index + 1,
            ]);
        }

        // Events - Wedding & Celebration Themed
        $events = [
            ['img' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=1200', 'category' => 'wedding', 'title' => 'Grand Wedding Ceremony'],
            ['img' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?auto=format&fit=crop&q=80&w=1200', 'category' => 'wedding', 'title' => 'Traditional South Indian Wedding'],
            ['img' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=1200', 'category' => 'wedding', 'title' => 'Royal Wedding Reception'],
            ['img' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=1200', 'category' => 'corporate', 'title' => 'Corporate Conference'],
            ['img' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&q=80&w=1200', 'category' => 'celebration', 'title' => 'Birthday Celebration'],
            ['img' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&q=80&w=1200', 'category' => 'celebration', 'title' => 'Anniversary Party'],
            ['img' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=1200', 'category' => 'gathering', 'title' => 'Family Gathering'],
            ['img' => 'https://images.unsplash.com/photo-1478146896981-b80fe463b330?auto=format&fit=crop&q=80&w=1200', 'category' => 'wedding', 'title' => 'Marriage Decoration'],
            ['img' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=1200', 'category' => 'corporate', 'title' => 'Business Seminar Catering'],
            ['img' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&q=80&w=1200', 'category' => 'wedding', 'title' => 'Wedding Feast Setup'],
            ['img' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&q=80&w=1200', 'category' => 'celebration', 'title' => 'Festival Celebration'],
            ['img' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&q=80&w=1200', 'category' => 'gathering', 'title' => 'Social Buffet Event']
        ];
        foreach ($events as $index => $event) {
            Event::create([
                'title' => $event['title'],
                'category' => $event['category'],
                'image' => $event['img'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }

        // Team Members
        $chefs = [
            ['name' => 'Jenny Disusa', 'role' => 'Decoration Chef', 'img' => '01.jpg'],
            ['name' => 'Robart Parker', 'role' => 'Executive Chef', 'img' => '02.jpg'],
            ['name' => 'Cathenna Sudh', 'role' => 'Kitchen Porter', 'img' => '03.jpg'],
            ['name' => 'Apolline Deo', 'role' => 'Head Chef', 'img' => '04.jpg']
        ];
        foreach ($chefs as $index => $chef) {
            TeamMember::create([
                'name' => $chef['name'],
                'role' => $chef['role'],
                'image' => 'assets/images/main/team/' . $chef['img'],
                'facebook_url' => '#',
                'twitter_url' => '#',
                'instagram_url' => '#',
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }

        // Testimonials
        $testimonials = [
            ['name' => 'John Brown', 'role' => 'BPO Manager', 'img' => '01.jpg', 'rating' => 3.5],
            ['name' => 'Robart Parker', 'role' => 'Executive Chef', 'img' => '02.jpg', 'rating' => 5.0],
            ['name' => 'Apolline Deo', 'role' => 'Kitchen Porter', 'img' => '03.jpg', 'rating' => 3.5],
            ['name' => 'Cathenna Sudh', 'role' => 'Head Chef', 'img' => '04.jpg', 'rating' => 4.5],
        ];
        foreach ($testimonials as $index => $testimonial) {
            Testimonial::create([
                'name' => $testimonial['name'],
                'role' => $testimonial['role'],
                'image' => 'assets/images/main/team/' . $testimonial['img'],
                'message' => 'The Vegetable Chettinad curry and Paneer Biriyani were outstanding! Manam brought the essence of traditional South Indian cuisine to our anniversary.',
                'rating' => $testimonial['rating'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }

        // FAQs
        for ($i = 1; $i <= 6; $i++) {
            Faq::create([
                'question' => 'Question ' . $i . ': What services do you offer?',
                'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
                'is_active' => true,
                'order' => $i,
            ]);
        }
    }
}
