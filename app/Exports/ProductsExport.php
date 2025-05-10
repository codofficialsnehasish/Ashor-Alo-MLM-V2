<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    public function collection()
    {
        return Product::with('category')->get()->map(function ($product, $key) {
            return [
                'SL. No' => $key + 1,  // Add SL. No (1, 2, 3, etc.)
                'Title' => $product->title,
                'Category' => $product->category->name ?? 'N/A',
                'Price' => $product->price,
                'Image' => $product->getFirstMediaUrl('products') ? 'Image Available' : 'No Image', // Check for image
                'Visibility' => $product->is_visible ? 'Visible' : 'Hidden',
            ];
        });
    }
}

