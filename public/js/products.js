// ==================== PRODUCTS.JS ====================
// Data Produk Lengkap untuk VINTARA

const products = [
    {
        id: 1,
        name: "iPhone 16 Pro Max",
        category: "handphone",
        category_slug: "handphone",
        brand: "Apple",
        price: 18000000,
        original_price: 25000000,
        rating: 4.8,
        sold: 1234,
        stock: 50,
        main_image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 28,
        description: "iPhone 16 Pro Max dengan chip A18 Pro, kamera 48MP, dan baterai tahan seharian.",
        reviews: [
            { user_name: "Anthino xi", rating: 5, comment: "HP-nya keren banget! Desainnya simpel tapi kelihatan mahal." },
            { user_name: "Bento", rating: 4, comment: "Bagus banget, cepet banget kirimnya." }
        ]
    },
    {
        id: 2,
        name: "Samsung Galaxy S24 Ultra",
        category: "handphone",
        category_slug: "handphone",
        brand: "Samsung",
        price: 19000000,
        original_price: 24000000,
        rating: 4.7,
        sold: 2345,
        stock: 45,
        main_image: "https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 21,
        description: "Samsung Galaxy S24 Ultra dengan AI intelligence, kamera 200MP, dan S-Pen."
    },
    {
        id: 3,
        name: "Xiaomi 14 Pro",
        category: "handphone",
        category_slug: "handphone",
        brand: "Xiaomi",
        price: 12000000,
        original_price: 16000000,
        rating: 4.6,
        sold: 3456,
        stock: 60,
        main_image: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop",
        is_flash_sale: false,
        discount: 0,
        description: "Xiaomi 14 Pro dengan kamera Leica, Snapdragon 8 Gen 3."
    },
    {
        id: 4,
        name: "Google Pixel 8 Pro",
        category: "handphone",
        category_slug: "handphone",
        brand: "Google",
        price: 16000000,
        original_price: 22000000,
        rating: 4.7,
        sold: 4567,
        stock: 30,
        main_image: "https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 27,
        description: "Google Pixel 8 Pro dengan kamera AI terbaik, Tensor G3."
    },
    {
        id: 5,
        name: "OnePlus 12",
        category: "handphone",
        category_slug: "handphone",
        brand: "OnePlus",
        price: 11000000,
        original_price: 15000000,
        rating: 4.6,
        sold: 2345,
        stock: 55,
        main_image: "https://images.unsplash.com/photo-1616348436168-de43ad0db179?w=400&h=400&fit=crop",
        is_flash_sale: false,
        discount: 0,
        description: "OnePlus 12 dengan layar 2K 120Hz, Snapdragon 8 Gen 3."
    },
    {
        id: 6,
        name: "iPhone 15 Pro",
        category: "handphone",
        category_slug: "handphone",
        brand: "Apple",
        price: 15000000,
        original_price: 20000000,
        rating: 4.7,
        sold: 5678,
        stock: 40,
        main_image: "https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop",
        is_flash_sale: false,
        discount: 0,
        description: "iPhone 15 Pro dengan chip A17 Pro, titanium design, dan USB-C."
    },
    {
        id: 7,
        name: "Samsung Galaxy Z Fold 5",
        category: "handphone",
        category_slug: "handphone",
        brand: "Samsung",
        price: 25000000,
        original_price: 30000000,
        rating: 4.8,
        sold: 1234,
        stock: 25,
        main_image: "https://images.unsplash.com/photo-1610792516307-ea5acd5c3b3a?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 17,
        description: "Samsung Galaxy Z Fold 5 dengan layar lipat 7.6 inch."
    },
    {
        id: 8,
        name: "Xiaomi 13T Pro",
        category: "handphone",
        category_slug: "handphone",
        brand: "Xiaomi",
        price: 8000000,
        original_price: 11000000,
        rating: 4.5,
        sold: 7890,
        stock: 80,
        main_image: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop",
        is_flash_sale: false,
        discount: 0,
        description: "Xiaomi 13T Pro dengan kamera Leica, Dimensity 9200+."
    },
    {
        id: 9,
        name: "MacBook Air M3",
        category: "laptop",
        category_slug: "laptop",
        brand: "Apple",
        price: 35000000,
        original_price: 42000000,
        rating: 4.9,
        sold: 567,
        stock: 30,
        main_image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=400&fit=crop",
        is_flash_sale: false,
        discount: 0,
        description: "MacBook Air dengan chip M3, layar Liquid Retina 13.6 inch."
    },
    {
        id: 10,
        name: "ASUS ROG Zephyrus G14",
        category: "laptop",
        category_slug: "laptop",
        brand: "Asus",
        price: 22000000,
        original_price: 28000000,
        rating: 4.7,
        sold: 789,
        stock: 25,
        main_image: "https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 21,
        description: "Laptop gaming compact dengan AMD Ryzen 9, RTX 4060."
    },
    {
        id: 11,
        name: "Sony WH-1000XM5",
        category: "headset",
        category_slug: "headset",
        brand: "Sony",
        price: 7000000,
        original_price: 9500000,
        rating: 4.9,
        sold: 1234,
        stock: 45,
        main_image: "https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 26,
        description: "Headphone noise cancelling terbaik dengan suara premium."
    },
    {
        id: 12,
        name: "AirPods Pro 2",
        category: "headset",
        category_slug: "headset",
        brand: "Apple",
        price: 3500000,
        original_price: 4500000,
        rating: 4.8,
        sold: 3456,
        stock: 100,
        main_image: "https://images.unsplash.com/photo-1600294037681-c80b4a3b4b19?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 22,
        description: "Earbuds dengan noise cancellation terbaik untuk Apple ecosystem."
    },
    {
        id: 13,
        name: "Apple Watch Ultra 2",
        category: "smartwatch",
        category_slug: "smartwatch",
        brand: "Apple",
        price: 12000000,
        original_price: 15000000,
        rating: 4.9,
        sold: 567,
        stock: 25,
        main_image: "https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 20,
        description: "Smartwatch premium untuk outdoor dengan battery tahan lama."
    },
    {
        id: 14,
        name: "JBL Flip 6",
        category: "headset",
        category_slug: "headset",
        brand: "JBL",
        price: 1800000,
        original_price: 2800000,
        rating: 4.8,
        sold: 4567,
        stock: 150,
        main_image: "https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=400&h=400&fit=crop",
        is_flash_sale: false,
        discount: 0,
        description: "Speaker portable dengan suara stereo, waterproof IPX7."
    },
    {
        id: 15,
        name: "Samsung Galaxy Watch 6 Classic",
        category: "smartwatch",
        category_slug: "smartwatch",
        brand: "Samsung",
        price: 6000000,
        original_price: 8000000,
        rating: 4.7,
        sold: 1234,
        stock: 50,
        main_image: "https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=400&h=400&fit=crop",
        is_flash_sale: true,
        discount: 25,
        description: "Smartwatch dengan rotating bezel klasik."
    }
];

// Simpan ke localStorage jika belum ada
if (!localStorage.getItem('vintara_products')) {
    localStorage.setItem('vintara_products', JSON.stringify(products));
    console.log('✅ Products saved to localStorage:', products.length);
}

// ==================== FUNCTIONS ====================
function formatRupiah(price) {
    if (!price && price !== 0) return 'Rp 0';
    return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function generateStarRating(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    let stars = '';
    for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
    if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
    for (let i = 0; i < 5 - Math.ceil(rating); i++) stars += '<i class="far fa-star"></i>';
    return stars;
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

function getAllProducts() {
    const saved = localStorage.getItem('vintara_products');
    if (saved) {
        return JSON.parse(saved);
    }
    return products;
}

function getProductById(id) {
    const allProducts = getAllProducts();
    return allProducts.find(p => p.id === parseInt(id));
}

function getProductsByCategory(categorySlug) {
    const allProducts = getAllProducts();
    return allProducts.filter(p => p.category_slug === categorySlug);
}

function getFlashSaleProducts() {
    const allProducts = getAllProducts();
    return allProducts.filter(p => p.is_flash_sale === true);
}

function searchProducts(keyword) {
    const allProducts = getAllProducts();
    if (!keyword.trim()) return allProducts;
    return allProducts.filter(product => 
        product.name.toLowerCase().includes(keyword.toLowerCase()) ||
        (product.brand && product.brand.toLowerCase().includes(keyword.toLowerCase()))
    );
}

function updateProductStock(productId, quantity, isReducing = true) {
    let allProducts = getAllProducts();
    const productIndex = allProducts.findIndex(p => p.id === productId);
    
    if (productIndex !== -1) {
        if (isReducing) {
            allProducts[productIndex].stock -= quantity;
            allProducts[productIndex].sold = (allProducts[productIndex].sold || 0) + quantity;
        } else {
            allProducts[productIndex].stock += quantity;
            allProducts[productIndex].sold = Math.max(0, (allProducts[productIndex].sold || 0) - quantity);
        }
        localStorage.setItem('vintara_products', JSON.stringify(allProducts));
        console.log(`📦 Stok ${allProducts[productIndex].name}: ${allProducts[productIndex].stock}`);
        return true;
    }
    return false;
}

function goToProductDetail(productId) {
    window.location.href = `/product-detail.html?id=${productId}`;
}

// Export ke global
window.products = products;
window.getAllProducts = getAllProducts;
window.getProductById = getProductById;
window.getProductsByCategory = getProductsByCategory;
window.getFlashSaleProducts = getFlashSaleProducts;
window.searchProducts = searchProducts;
window.updateProductStock = updateProductStock;
window.formatRupiah = formatRupiah;
window.generateStarRating = generateStarRating;
window.escapeHtml = escapeHtml;
window.goToProductDetail = goToProductDetail;

console.log('✅ products.js loaded with', products.length, 'products');