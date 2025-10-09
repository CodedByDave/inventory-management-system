<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // Remove old placeholder brands
        Brand::whereIn('name', ['Brand A', 'Brand B', 'Brand C'])->delete();

        // Insert brands with category_id
        $brands = [
            ['name' => 'Samsung', 'description' => 'Electronics and appliances.', 'category_id' => Category::where('name', 'Electronics')->first()->id],
            ['name' => 'Apple', 'description' => 'Smartphones, laptops, and gadgets.', 'category_id' => Category::where('name', 'Electronics')->first()->id],
            ['name' => 'Nike', 'description' => 'Sportswear and footwear.', 'category_id' => Category::where('name', 'Footwear')->first()->id],
            ['name' => 'Adidas', 'description' => 'Sportswear and footwear.', 'category_id' => Category::where('name', 'Footwear')->first()->id],
            ['name' => 'Sony', 'description' => 'Electronics, audio, and gaming.', 'category_id' => Category::where('name', 'Electronics')->first()->id],
            ['name' => 'LG', 'description' => 'Home appliances and electronics.', 'category_id' => Category::where('name', 'Appliances')->first()->id],
            ['name' => 'Bosch', 'description' => 'Tools, hardware, and appliances.', 'category_id' => Category::where('name', 'Tools & Hardware')->first()->id],
            ['name' => 'Unbranded', 'description' => 'Products without a specific brand.', 'category_id' => null],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name']],
                ['description' => $brand['description'], 'category_id' => $brand['category_id']]
            );
        }
    }
}
