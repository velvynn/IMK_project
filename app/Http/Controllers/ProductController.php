<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get all products with filtering
     */
    public function index(Request $request)
    {
        $query = Product::with('images')->where('is_active', true);
        
        // Filter by category
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        
        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', (int)$request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', (int)$request->max_price);
        }
        
        // Filter by brand
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }
        
        // Filter by rating
        if ($request->has('min_rating')) {
            $query->where('rating', '>=', (float)$request->min_rating);
        }
        
        // Sort
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('sold', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $limit = $request->input('limit', 100);
        $page = $request->input('page', 1);
        $products = $query->paginate($limit, ['*'], 'page', $page);
        
        foreach ($products as $product) {
            $rating = $this->getProductRating($product->id);
            $product->avg_rating = $rating['average'];
            $product->total_reviews = $rating['total'];
        }
        
        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
        ]);
    }

    /**
     * Get single product by ID
     */
    public function show($id)
    {
        $product = Product::with(['images', 'variants', 'reviews.user'])->find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
        
        $rating = $this->getProductRating($product->id);
        $product->avg_rating = $rating['average'];
        $product->total_reviews = $rating['total'];
        
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Get product by slug
     */
    public function showBySlug($slug)
    {
        $product = Product::with(['images', 'variants', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
        
        $rating = $this->getProductRating($product->id);
        $product->avg_rating = $rating['average'];
        $product->total_reviews = $rating['total'];
        
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Get products by category slug
     */
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
        
        $products = Product::with('images')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach ($products as $product) {
            $rating = $this->getProductRating($product->id);
            $product->avg_rating = $rating['average'];
        }
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get flash sale products
     */
    public function flashSale()
    {
        $products = Product::with('images')
            ->where('is_flash_sale', true)
            ->where('flash_sale_end', '>', now())
            ->where('is_active', true)
            ->orderBy('discount', 'desc')
            ->get();
        
        foreach ($products as $product) {
            $rating = $this->getProductRating($product->id);
            $product->avg_rating = $rating['average'];
        }
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        
        if (strlen($keyword) < 2) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
        
        $products = Product::with('images')
            ->where('is_active', true)
            ->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('brand', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            })
            ->orderBy('sold', 'desc')
            ->limit(20)
            ->get();
        
        foreach ($products as $product) {
            $rating = $this->getProductRating($product->id);
            $product->avg_rating = $rating['average'];
        }
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get all unique brands
     */
    public function getBrands()
    {
        $brands = Product::where('is_active', true)
            ->select('brand')
            ->distinct()
            ->whereNotNull('brand')
            ->orderBy('brand')
            ->pluck('brand');
        
        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Get product rating
     */
    private function getProductRating($productId)
    {
        $review = Review::where('product_id', $productId)
            ->selectRaw('COALESCE(AVG(rating), 0) as avg_rating, COUNT(*) as total')
            ->first();
        
        return [
            'average' => round($review->avg_rating ?? 0, 1),
            'total' => $review->total ?? 0
        ];
    }

    /**
     * Create new product (Admin)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'price' => $request->price,
            'original_price' => $request->original_price ?? $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'is_flash_sale' => $request->is_flash_sale ?? false,
            'discount' => $request->discount ?? 0,
            'flash_sale_end' => $request->flash_sale_end,
            'is_active' => true,
        ]);

        // Handle images
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imageUrl,
                    'is_main' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        // Handle variants
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => $variant['type'],
                    'value' => $variant['value'],
                    'stock' => $variant['stock'] ?? null,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    }

    /**
     * Update product (Admin)
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->update($request->only([
            'name', 'category_id', 'brand', 'price', 'original_price',
            'stock', 'description', 'is_flash_sale', 'discount',
            'flash_sale_end', 'is_active'
        ]));

        if ($request->has('name') && $request->name !== $product->getOriginal('name')) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $product->slug = $slug;
            $product->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Delete product (Soft delete by setting inactive)
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->is_active = false;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}