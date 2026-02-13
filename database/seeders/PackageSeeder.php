<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Package::count() > 0) {
            return;
        }

        $packages = [
            [
                'name' => 'Royal Veg Delight',
                'description' => 'A premium vegetarian feast suitable for weddings and grand receptions.',
                'price' => 450.00,
                'type' => 'Veg',
                'features' => [
                    'Welcome Drink (2 Varieties)',
                    '3 Starters',
                    'Main Course (Paneer + Dal + 2 Sabzi)',
                    'Rice & Breads (Assorted)',
                    '2 Desserts + Ice Cream'
                ],
                'menu_content' => [
                    [
                        'category' => 'Welcome Drinks',
                        'items' => ['Fruit Punch', 'Mint Mojito']
                    ],
                    [
                        'category' => 'Starters',
                        'items' => ['Paneer Tikka', 'Hara Bhara Kebab', 'Corn Cheese Balls']
                    ],
                    [
                        'category' => 'Main Course',
                        'items' => ['Paneer Butter Masala', 'Dal Makhani', 'Mix Veg', 'Aloo Gobi']
                    ],
                     [
                        'category' => 'Breads & Rice',
                        'items' => ['Butter Naan', 'Jeera Rice', 'Veg Biryani']
                    ],
                     [
                        'category' => 'Desserts',
                        'items' => ['Gulab Jamun', 'Rasmalai', 'Vanilla Ice Cream']
                    ]
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Classic Non-Veg Feast',
                'description' => 'A balanced menu featuring popular chicken and mutton delicacies.',
                'price' => 650.00,
                'type' => 'Non-Veg',
                'features' => [
                    'Welcome Drink',
                    '4 Starters (2 Veg + 2 Non-Veg)',
                    'Chicken Curry + Mutton Rogan Josh',
                    'Biryani (Chicken/Mutton)',
                    'Exquisite Desserts'
                ],
                 'menu_content' => [
                    [
                        'category' => 'Welcome Drinks',
                        'items' => ['Blue Lagoon']
                    ],
                    [
                        'category' => 'Starters',
                        'items' => ['Chicken 65', 'Mutton Seekh Kebab', 'Gobi Manchurian', 'Spring Rolls']
                    ],
                    [
                        'category' => 'Main Course',
                        'items' => ['Butter Chicken', 'Mutton Rogan Josh', 'Dal Tadka']
                    ],
                     [
                        'category' => 'Breads & Rice',
                        'items' => ['Tandoori Roti', 'Chicken Biryani', 'Steamed Rice']
                    ],
                     [
                        'category' => 'Desserts',
                        'items' => ['Gajar Halwa', 'Chocolate Brownie']
                    ]
                ],
                'is_active' => true,
            ],
             [
                'name' => 'Budget Friendly Standard',
                'description' => 'Perfect for small gatherings and birthday parties.',
                'price' => 350.00,
                'type' => 'Mixed',
                'features' => [
                    '1 Welcome Drink',
                    '2 Starters',
                    'Simple Main Course',
                    'Ice Cream'
                ],
                 'menu_content' => [
                    [
                        'category' => 'Welcome Drinks',
                        'items' => ['Fresh Lime Soda']
                    ],
                    [
                        'category' => 'Starters',
                        'items' => ['Veg Manchurian', 'Chicken Lollipop']
                    ],
                    [
                        'category' => 'Main Course',
                        'items' => ['Chicken Curry', 'Paneer Kadai', 'Dal Fry']
                    ],
                     [
                        'category' => 'Breads & Rice',
                        'items' => ['Chapati', 'Veg Pulao']
                    ],
                     [
                        'category' => 'Desserts',
                        'items' => ['Vanilla Ice Cream']
                    ]
                ],
                'is_active' => true,
            ]
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }
}
