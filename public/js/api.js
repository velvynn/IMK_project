// ==================== API CONNECTION LAYER ====================
const API_BASE = '/api';

class API {
    // ==================== AUTHENTICATION ====================
    static async login(email, password) {
        try {
            const response = await fetch(`${API_BASE}/auth/login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            return await response.json();
        } catch (error) {
            console.error('Login error:', error);
            return { success: false, message: 'Koneksi error' };
        }
    }
    
    static async register(name, email, password) {
        try {
            const response = await fetch(`${API_BASE}/auth/register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, password })
            });
            return await response.json();
        } catch (error) {
            console.error('Register error:', error);
            return { success: false, message: 'Koneksi error' };
        }
    }
    
    static async logout() {
        try {
            const response = await fetch(`${API_BASE}/auth/logout`, {
                method: 'POST'
            });
            return await response.json();
        } catch (error) {
            console.error('Logout error:', error);
            return { success: false };
        }
    }
    
    static async checkSession() {
        try {
            const response = await fetch(`${API_BASE}/auth/check`);
            return await response.json();
        } catch (error) {
            console.error('Session check error:', error);
            return { success: false };
        }
    }
    
    static async updateProfile(profileData) {
        try {
            const response = await fetch(`${API_BASE}/auth/update-profile`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(profileData)
            });
            return await response.json();
        } catch (error) {
            console.error('Update profile error:', error);
            return { success: false };
        }
    }
    
    static async changePassword(passwordData) {
        try {
            const response = await fetch(`${API_BASE}/auth/change-password`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(passwordData)
            });
            return await response.json();
        } catch (error) {
            console.error('Change password error:', error);
            return { success: false };
        }
    }
    
    static async getUserAddress() {
        try {
            const response = await fetch(`${API_BASE}/auth/address`);
            return await response.json();
        } catch (error) {
            console.error('Get address error:', error);
            return { success: false };
        }
    }
    
    static async saveUserAddress(addressData) {
        try {
            const response = await fetch(`${API_BASE}/auth/address`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(addressData)
            });
            return await response.json();
        } catch (error) {
            console.error('Save address error:', error);
            return { success: false };
        }
    }
    
    // ==================== PRODUCTS ====================
    static async getProducts(limit = 100, page = 1, filters = {}) {
        try {
            let url = `${API_BASE}/products?limit=${limit}&page=${page}`;
            if (filters.category) url += `&category=${filters.category}`;
            if (filters.search) url += `&search=${encodeURIComponent(filters.search)}`;
            if (filters.min_price) url += `&min_price=${filters.min_price}`;
            if (filters.max_price) url += `&max_price=${filters.max_price}`;
            if (filters.brand) url += `&brand=${filters.brand}`;
            if (filters.sort) url += `&sort=${filters.sort}`;
            
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error('Get products error:', error);
            return { success: false, data: [] };
        }
    }
    
    static async getProductById(id) {
        try {
            const response = await fetch(`${API_BASE}/products/${id}`);
            return await response.json();
        } catch (error) {
            console.error('Get product error:', error);
            return { success: false };
        }
    }
    
    static async getProductBySlug(slug) {
        try {
            const response = await fetch(`${API_BASE}/products/slug/${slug}`);
            return await response.json();
        } catch (error) {
            console.error('Get product by slug error:', error);
            return { success: false };
        }
    }
    
    static async getProductsByCategory(category) {
        try {
            const response = await fetch(`${API_BASE}/products/category/${category}`);
            return await response.json();
        } catch (error) {
            console.error('Get products by category error:', error);
            return { success: false, data: [] };
        }
    }
    
    static async getFlashSaleProducts() {
        try {
            const response = await fetch(`${API_BASE}/products/flash-sale`);
            return await response.json();
        } catch (error) {
            console.error('Get flash sale error:', error);
            return { success: false, data: [] };
        }
    }
    
    static async searchProducts(keyword) {
        try {
            const response = await fetch(`${API_BASE}/products/search?q=${encodeURIComponent(keyword)}`);
            return await response.json();
        } catch (error) {
            console.error('Search error:', error);
            return { success: false, data: [] };
        }
    }
    
    static async getBrands() {
        try {
            const response = await fetch(`${API_BASE}/brands`);
            return await response.json();
        } catch (error) {
            console.error('Get brands error:', error);
            return { success: false, data: [] };
        }
    }
    
    // ==================== CART ====================
    static async getCart() {
        try {
            const response = await fetch(`${API_BASE}/cart`);
            return await response.json();
        } catch (error) {
            console.error('Get cart error:', error);
            return { success: false, data: [], subtotal: 0 };
        }
    }
    
    static async addToCart(productId, quantity = 1, variantSelected = null) {
        try {
            const response = await fetch(`${API_BASE}/cart`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId, quantity, variant_selected: variantSelected })
            });
            return await response.json();
        } catch (error) {
            console.error('Add to cart error:', error);
            return { success: false, message: 'Gagal menambahkan ke keranjang' };
        }
    }
    
    static async updateCartItem(cartId, quantity) {
        try {
            const response = await fetch(`${API_BASE}/cart/${cartId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ quantity })
            });
            return await response.json();
        } catch (error) {
            console.error('Update cart error:', error);
            return { success: false };
        }
    }
    
    static async removeFromCart(cartId) {
        try {
            const response = await fetch(`${API_BASE}/cart/${cartId}`, {
                method: 'DELETE'
            });
            return await response.json();
        } catch (error) {
            console.error('Remove from cart error:', error);
            return { success: false };
        }
    }
    
    static async clearCart() {
        try {
            const response = await fetch(`${API_BASE}/cart`, {
                method: 'DELETE'
            });
            return await response.json();
        } catch (error) {
            console.error('Clear cart error:', error);
            return { success: false };
        }
    }
    
    static async syncCart(items) {
        try {
            const response = await fetch(`${API_BASE}/cart/sync`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ items })
            });
            return await response.json();
        } catch (error) {
            console.error('Sync cart error:', error);
            return { success: false };
        }
    }
    
    // ==================== ORDERS ====================
    static async getOrders() {
        try {
            const response = await fetch(`${API_BASE}/orders`);
            return await response.json();
        } catch (error) {
            console.error('Get orders error:', error);
            return { success: false, data: [] };
        }
    }
    
    static async getOrderById(id) {
        try {
            const response = await fetch(`${API_BASE}/orders/${id}`);
            return await response.json();
        } catch (error) {
            console.error('Get order error:', error);
            return { success: false };
        }
    }
    
    static async getOrderByNumber(orderNumber) {
        try {
            const response = await fetch(`${API_BASE}/orders/number/${orderNumber}`);
            return await response.json();
        } catch (error) {
            console.error('Get order by number error:', error);
            return { success: false };
        }
    }
    
    static async createOrder(orderData) {
        try {
            const response = await fetch(`${API_BASE}/orders`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(orderData)
            });
            return await response.json();
        } catch (error) {
            console.error('Create order error:', error);
            return { success: false, message: 'Gagal membuat pesanan' };
        }
    }
    
    static async cancelOrder(orderId) {
        try {
            const response = await fetch(`${API_BASE}/orders/${orderId}/cancel`, {
                method: 'POST'
            });
            return await response.json();
        } catch (error) {
            console.error('Cancel order error:', error);
            return { success: false };
        }
    }
    
    static async confirmPayment(orderId, formData) {
        try {
            const response = await fetch(`${API_BASE}/orders/${orderId}/confirm-payment`, {
                method: 'POST',
                body: formData
            });
            return await response.json();
        } catch (error) {
            console.error('Confirm payment error:', error);
            return { success: false };
        }
    }
    
    // ==================== VOUCHERS ====================
    static async validateVoucher(code, subtotal) {
        try {
            const response = await fetch(`${API_BASE}/vouchers/validate`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ code, subtotal })
            });
            return await response.json();
        } catch (error) {
            console.error('Validate voucher error:', error);
            return { success: false, message: 'Gagal memvalidasi voucher' };
        }
    }
    
    static async getVouchers() {
        try {
            const response = await fetch(`${API_BASE}/vouchers`);
            return await response.json();
        } catch (error) {
            console.error('Get vouchers error:', error);
            return { success: false, data: [] };
        }
    }
}

// Export ke global
window.API = API;
console.log('✅ API.js loaded');