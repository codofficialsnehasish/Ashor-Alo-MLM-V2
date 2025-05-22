<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\ComboItem;

class ProductsApiController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variations', 'comboItems.product', 'comboItems.variation', 'media'])
            ->where('is_visible',1)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return apiResponse(true, 'All Active Products', ['products'=>$products], 200);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'variations', 'comboItems.product', 'comboItems.variation', 'media'])
            ->find($id);

        if (!$product) {
            return apiResponse(false, 'Product Not Found', null, 200);
        }

        return apiResponse(true, 'Product Details', ['product'=>$this->formatProduct($product)], 200);
    }

    protected function formatProduct($product)
    {
        $formatted = [
            'id' => $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'product_type' => $product->product_type,
            'price' => $product->price,
            'discount_rate' => $product->discount_rate,
            'discounted_price' => $product->discounted_price,
            'gst_rate' => $product->gst_rate,
            'gst_amount' => $product->gst_amount,
            'total_price' => $product->total_price,
            'stock' => $product->stock,
            'is_visible' => $product->is_visible,
            'is_bestseller' => $product->is_bestseller,
            'short_desc' => $product->short_desc,
            'description' => $product->description,
            'meta_title' => $product->meta_title,
            'meta_keyword' => $product->meta_keyword,
            'meta_description' => $product->meta_description,
            'combo_price' => $product->combo_price,
            'category' => null,
            'variations' => [],
            'combo_items' => [],
            'image' => null,
        ];

        // Add category if it exists
        if ($product->category) {
            $formatted['category'] = [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug
            ];
        }

        // Add variations if they exist
        if ($product->variations->count() > 0) {
            $formatted['variations'] = $product->variations->map(function ($variation) {
                return [
                    'id' => $variation->id,
                    'attribute' => $variation->attribute,
                    'value' => $variation->value,
                    'price_override' => $variation->price_override,
                    'stock' => $variation->stock,
                    'sku' => $variation->sku
                ];
            });
        }

        // Add combo items if it's a combo product
        if ($product->product_type === 'combo' && $product->comboItems->count() > 0) {
            $formatted['combo_items'] = $product->comboItems->map(function ($comboItem) {
                $item = [
                    'product_id' => $comboItem->product_id,
                    'product_title' => $comboItem->product->title ?? null,
                    'product_sku' => $comboItem->product->sku ?? null,
                    'quantity' => $comboItem->quantity,
                    'price_override' => $comboItem->price_override
                ];

                if ($comboItem->variation) {
                    $item['variation'] = [
                        'id' => $comboItem->variation->id,
                        'attribute' => $comboItem->variation->attribute,
                        'value' => $comboItem->variation->value,
                        'sku' => $comboItem->variation->sku
                    ];
                }

                return $item;
            });
        }

        // Get the first media item (since each product has only one image)
        $media = $product->getFirstMedia('products');
        if ($media) {
            $formatted['image'] = $media->getFullUrl();
        }

        return $formatted;
    }
}