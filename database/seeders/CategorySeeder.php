<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Delete old placeholder categories
        Category::whereIn('name', ['Category 1', 'Category 2', 'Category 3'])->delete();

        // 2️⃣ Insert new categories using updateOrCreate to avoid duplicates
        $categories = [
            ['name' => 'Electronics', 'description' => 'Phones, laptops, gadgets, and accessories.'],
            ['name' => 'Appliances', 'description' => 'Refrigerators, microwaves, washing machines, and other home appliances.'],
            ['name' => 'Furniture', 'description' => 'Chairs, tables, cabinets, and office furniture.'],
            ['name' => 'Clothing & Apparel', 'description' => 'Shirts, pants, jackets, uniforms, and apparel.'],
            ['name' => 'Footwear', 'description' => 'Shoes, sandals, and boots.'],
            ['name' => 'Health & Personal Care', 'description' => 'Medicines, supplements, personal care products.'],
            ['name' => 'PPE & Safety Equipment', 'description' => 'Masks, gloves, helmets, sanitizers, protective equipment.'],
            ['name' => 'Stationery & Office Supplies', 'description' => 'Pens, paper, notebooks, printers, and office materials.'],
            ['name' => 'Food & Beverages', 'description' => 'Snacks, drinks, packaged food items.'],
            ['name' => 'Tools & Hardware', 'description' => 'Hand tools, power tools, building materials.'],
            ['name' => 'Automotive', 'description' => 'Car parts, oils, tires, and automotive accessories.'],
            ['name' => 'Toys & Games', 'description' => 'Board games, educational toys, outdoor toys.'],
            ['name' => 'Cleaning & Maintenance', 'description' => 'Detergents, mops, cleaning equipment, supplies.'],
            ['name' => 'Sports & Outdoors', 'description' => 'Fitness equipment, camping gear, bicycles, outdoor products.'],
            ['name' => 'Miscellaneous', 'description' => 'Items that do not fit in other categories.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']], // check if name exists
                ['description' => $category['description']] // update or insert
            );
        }
    }
}
