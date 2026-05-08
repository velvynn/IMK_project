@extends('layouts.app')

@section('title', 'Semua Produk - VINTARA')

@section('content')
<div class="shop-page" style="padding: 60px 0; background: var(--bg-light); min-height: 60vh;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
        <div class="shop-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
            <h1 style="color: var(--primary); font-size: 32px;">Semua Produk</h1>
            <div class="sort-section" style="display: flex; align-items: center; gap: 12px;">
                <span>Urutkan:</span>
                <select id="sortShopProducts" class="sort-select" style="padding: 8px 16px; border-radius: 30px; border: 1px solid var(--border); background: white;">
                    <option value="default">Rekomendasi</option>
                    <option value="price-asc">Termurah</option>
                    <option value="price-desc">Termahal</option>
                    <option value="rating">Rating Tertinggi</option>
                    <option value="popular">Terlaris</option>
                </select>
            </div>
        </div>
        
        <div class="shop-products-grid" id="shopProductsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">
            @if(isset($products) && $products->count() > 0)
                @foreach($products as $product)
                <div class="product-card" onclick="window.location.href='{{ url('/product/' . $product->slug) }}'" style="cursor: pointer; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s;">
                    @if($product->is_flash_sale)
                        <div class="product-badge flash" style="position: absolute; top: 12px; left: 12px; background: #ff4757; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; z-index: 1;">🔥 Flash Sale -{{ $product->discount }}%</div>
                    @endif
                    <div class="product-image" style="height: 200px; overflow: hidden; background: #f5f5f5;">
                        <img src="{{ $product->main_image ?? 'https://placehold.co/400x400/e9ecef/1F1B5B?text=' . urlencode($product->name) }}" 
                             alt="{{ $product->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.src='https://placehold.co/400x400/e9ecef/1F1B5B?text=No+Image'">
                    </div>
                    <div class="product-info" style="padding: 16px;">
                        <h4 class="product-title" style="font-weight: 600; margin-bottom: 5px; font-size: 15px;">{{ $product->name }}</h4>
                        <div class="product-rating" style="margin: 5px 0;">
                            {!! generateStarRating($product->rating ?? 0) !!}
                            <span style="margin-left: 5px;">({{ number_format($product->rating ?? 0, 1) }})</span>
                        </div>
                        <div class="product-price" style="font-size: 18px; font-weight: 700; color: var(--primary); margin: 8px 0;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                            @if($product->original_price && $product->original_price > $product->price)
                                <span class="product-old-price" style="font-size: 14px; color: var(--text-gray); text-decoration: line-through; margin-left: 8px;">
                                    Rp {{ number_format($product->original_price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        <div class="product-sold" style="font-size: 12px; color: var(--text-gray); margin-bottom: 10px;">
                            <i class="fas fa-shopping-bag"></i> Terjual {{ number_format($product->sold ?? 0) }}+
                        </div>
                        <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart({{ $product->id }})" style="width: 100%; padding: 10px; background: var(--primary); color: white; border: none; border-radius: 30px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 20px;">
                    <i class="fas fa-box-open" style="font-size: 60px; color: var(--text-light);"></i>
                    <h3 style="margin-top: 15px;">Belum Ada Produk</h3>
                    <p>Silakan cek kembali nanti</p>
                </div>
            @endif
        </div>
        
        @if(isset($products) && method_exists($products, 'links'))
        <div class="pagination-container" style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('sortShopProducts')?.addEventListener('change', function(e) {
        const sortValue = e.target.value;
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    });
</script>
@endsection