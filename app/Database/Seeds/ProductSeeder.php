<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Java Chip Frappuccino',
                'description' => 'Mocha sauce and Frappuccino® chips blended with coffee, milk and ice, then topped with whipped cream and mocha drizzle.',
                'price' => 441.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/100501.jpg',
                'category' => 'Drinks',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Picco Cappuccino',
                'description' => 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam.',
                'price' => 200.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/112539.jpg',
                'category' => 'Coffee',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Iced Caffe Latte',
                'description' => 'Our dark, rich espresso is combined with milk and served over ice.',
                'price' => 372.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/100385.jpg',
                'category' => 'Drinks',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Cold Coffee',
                'description' => 'Our signature rich in flavour espresso blended with delicate milk and ice.',
                'price' => 299.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/105468.jpg',
                'category' => 'Drinks',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Smoked Chicken Sandwich',
                'description' => 'A hearty Smoked Chicken & Salami Sandwich with tender smoked chicken.',
                'price' => 399.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/101729.png',
                'category' => 'Food',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Kosha Mangsho Wrap',
                'description' => 'A traditional mutton preparation packed in a parantha wrap.',
                'price' => 367.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/114059.jpg',
                'category' => 'Food',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Double Frappuccino',
                'description' => 'Rich mocha-flavored sauce meets up with chocolaty chips, milk and ice.',
                'price' => 420.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/103515.jpg',
                'category' => 'Drinks',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Chicken Sandwich',
                'description' => 'Marinated tandoori chicken filling, sliced cheese, and whole wheat bread.',
                'price' => 283.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/100100_1.png',
                'category' => 'Food',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Cookie Creme Latte',
                'description' => 'Handcrafted espresso from the world\'s top 3% Arabica with steamed milk.',
                'price' => 430.00,
                'image' => 'https://starbucksstatic.cognizantorderserv.com/Items/Small/115751_1.png',
                'category' => 'Coffee',
                'page' => 'menu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'India Exclusive Gift Card',
                'description' => 'Bring in the festive season and make each celebration memorable.',
                'price' => 99.00,
                'image' => 'https://preprodtsbstorage.blob.core.windows.net/cms/uploads/TSB_GC_indiacard_1_1_28dafb2bb6.png',
                'category' => 'Gift Cards',
                'page' => 'gift',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Starbucks Coffee Gift Card',
                'description' => 'Starbucks is best when shared. Treat your pals to a good cup of coffee.',
                'price' => 88.00,
                'image' => 'https://preprodtsbstorage.blob.core.windows.net/cms/uploads/71d3780c_be6e_46b1_ab01_8a2bce244a7f_1_1_2d1afadaa0.png',
                'category' => 'Gift Cards',
                'page' => 'gift',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Keep Me Warm Gift Card',
                'description' => 'Captivating, cosy, coffee. Gift your loved ones this Starbucks Gift Card.',
                'price' => 50.00,
                'image' => 'https://preprodtsbstorage.blob.core.windows.net/cms/uploads/7c6f7c64_3f89_4ba2_9af8_45fc6d94ad35_1_1bdd3bf075.webp',
                'category' => 'Gift Cards',
                'page' => 'gift',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
