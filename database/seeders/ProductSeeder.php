<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Features 6.1-inch Super Retina XDR display.',
                'sku' => 'IPH15PRO001',
                'price' => 999.99,
                'stock' => 50,
                'category_id' => $categories->where('slug', 'electronics')->first()?->id,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Flagship Android smartphone with AI-powered features, 50MP camera, and 120Hz display. Perfect for photography enthusiasts.',
                'sku' => 'SGS24001',
                'price' => 899.99,
                'stock' => 30,
                'category_id' => $categories->where('slug', 'electronics')->first()?->id,
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with Max Air unit for superior cushioning. Breathable mesh upper and durable rubber outsole.',
                'sku' => 'NAM270001',
                'price' => 150.00,
                'stock' => 100,
                'category_id' => $categories->where('slug', 'clothing')->first()?->id,
            ],
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald. A timeless story of love, wealth, and the American Dream in the Jazz Age.',
                'sku' => 'TGG001',
                'price' => 12.99,
                'stock' => 200,
                'category_id' => $categories->where('slug', 'books')->first()?->id,
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete 10-piece gardening tool set including trowel, pruners, weeder, and more. Perfect for home gardening enthusiasts.',
                'sku' => 'GTS001',
                'price' => 89.99,
                'stock' => 25,
                'category_id' => $categories->where('slug', 'home-garden')->first()?->id,
            ],
            [
                'name' => 'Wilson Tennis Racket',
                'description' => 'Professional-grade tennis racket with carbon fiber frame. Lightweight design for improved control and power.',
                'sku' => 'WTR001',
                'price' => 199.99,
                'stock' => 15,
                'category_id' => $categories->where('slug', 'sports')->first()?->id,
            ],
        ];

        foreach ($products as $product) {
            if ($product['category_id']) {
                Product::create($product);
            }
        }
    }
}