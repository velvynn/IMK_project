<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Voucher;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('images')
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            $products = collect();
        }
        
        try {
            $categories = Category::all();
        } catch (\Exception $e) {
            $categories = collect();
        }
        
        try {
            $flashSales = Product::with('images')
                ->where('is_flash_sale', true)
                ->where('flash_sale_end', '>', now())
                ->where('is_active', true)
                ->limit(4)
                ->get();
        } catch (\Exception $e) {
            $flashSales = collect();
        }
        
        return view('index', compact('products', 'categories', 'flashSales'));
    }

    public function kategori($slug = null)
    {
        try {
            $categories = Category::all();
        } catch (\Exception $e) {
            $categories = collect();
        }
        
        $selectedCategory = null;
        $products = collect();
        
        try {
            $query = Product::with('images')->where('is_active', true);
            
            if ($slug) {
                $selectedCategory = Category::where('slug', $slug)->first();
                if ($selectedCategory) {
                    $query = $query->where('category_id', $selectedCategory->id);
                }
            }
            
            $products = $query->orderBy('created_at', 'desc')->get();
            
        } catch (\Exception $e) {
            $products = collect();
        }
        
        return view('kategori', compact('products', 'categories', 'selectedCategory'));
    }

    public function productDetail($slug)
    {
        try {
            $product = Product::with(['images', 'variants', 'reviews.user'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
            
            $relatedProducts = Product::with('images')
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->limit(4)
                ->get();
                
            $reviews = $product->reviews;
            $totalReviews = $reviews->count();
            $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
            
            $ratingDistribution = [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ];
            
        } catch (\Exception $e) {
            abort(404, 'Product not found');
        }
        
        return view('product-detail', compact('product', 'relatedProducts', 'reviews', 'totalReviews', 'averageRating', 'ratingDistribution'));
    }

    public function productDetailById(Request $request)
    {
        $id = $request->query('id');
        
        if (!$id) {
            abort(404, 'Product ID required');
        }
        
        try {
            $product = Product::with(['images', 'variants', 'reviews.user'])
                ->where('id', $id)
                ->where('is_active', true)
                ->firstOrFail();
            
            return redirect()->route('product.detail', ['slug' => $product->slug]);
            
        } catch (\Exception $e) {
            abort(404, 'Product not found');
        }
    }

    public function cart()
    {
        $sessionId = Session::getId();
        
        $cartItems = Cart::with('product.images')
            ->where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();
        
        if ($cartItems->isEmpty()) {
            $cartItems = collect([
                (object)[
                    'id' => 1,
                    'product' => (object)[
                        'id' => 1,
                        'name' => 'Baseus Blade 100W',
                        'price' => 700000,
                        'main_image' => 'https://placehold.co/400x400/1F1B5B/white?text=Baseus'
                    ],
                    'quantity' => 1,
                    'variant_selected' => null
                ],
                (object)[
                    'id' => 2,
                    'product' => (object)[
                        'id' => 2,
                        'name' => 'Belkin BoostCharge Pro',
                        'price' => 1200000,
                        'main_image' => 'https://placehold.co/400x400/1F1B5B/white?text=Belkin'
                    ],
                    'quantity' => 1,
                    'variant_selected' => null
                ]
            ]);
        }
        
        return view('cart', compact('cartItems'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function orderSuccess()
    {
        return view('order-success');
    }

    public function orderDetail(Request $request, $id = null)
    {
        $orderId = $id ?? $request->query('id');
        return view('order-detail', compact('orderId'));
    }

    public function profile()
    {
        return view('profile');
    }

    public function deals()
    {
        try {
            $flashSales = Product::with('images')
                ->where('is_flash_sale', true)
                ->where('flash_sale_end', '>', now())
                ->where('is_active', true)
                ->get();
        } catch (\Exception $e) {
            $flashSales = collect();
        }
        
        try {
            $vouchers = Voucher::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>', now());
                })
                ->get();
        } catch (\Exception $e) {
            $vouchers = collect();
        }
        
        return view('deals', compact('flashSales', 'vouchers'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function shop()
    {
        try {
            $products = Product::with('images')
                ->where('is_active', true)
                ->get();
        } catch (\Exception $e) {
            $products = collect();
        }
        
        return view('shop', compact('products'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
}