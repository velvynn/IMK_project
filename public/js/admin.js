// resources/js/admin.js

// ==================== Sidebar Toggle ====================
const sidebar = document.getElementById('adminSidebar');
const sidebarToggle = document.getElementById('sidebarToggle');

if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        document.querySelector('.admin-main').classList.toggle('expanded');
    });
}

// ==================== User Dropdown ====================
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const avatar = document.querySelector('.admin-avatar');
    
    if (dropdown && avatar && !avatar.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

// ==================== Global Search ====================
const globalSearch = document.getElementById('globalSearch');
if (globalSearch) {
    let searchTimeout;
    globalSearch.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = e.target.value;
            if (query.length > 2) {
                searchGlobal(query);
            }
        }, 500);
    });
}

function searchGlobal(query) {
    fetch(`/admin/api/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            showSearchResults(data);
        })
        .catch(error => console.error('Search error:', error));
}

// ==================== Toast Notification ====================
function showToast(message, type = 'success') {
    const toast = document.getElementById('toastMessage');
    toast.textContent = message;
    toast.className = `toast-notification ${type}`;
    toast.classList.add('show');
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// ==================== Delete Confirmation ====================
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
    return confirm(message);
}

// ==================== Bulk Actions ====================
function toggleSelectAll(checkboxClass, itemClass) {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll(`.${itemClass}`);
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
}

// ==================== Status Update ====================
function updateStatus(url, status, callback) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Status berhasil diupdate!');
            if (callback) callback();
        } else {
            showToast(data.message || 'Gagal mengupdate status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

// ==================== Export Data ====================
function exportData(url, format = 'excel') {
    window.location.href = `${url}?format=${format}`;
}

// ==================== Print Invoice ====================
function printInvoice(orderId) {
    window.open(`/admin/orders/${orderId}/print-invoice`, '_blank');
}

function printResi(orderId) {
    window.open(`/admin/orders/${orderId}/print-resi`, '_blank');
}

// ==================== Chart Initialization ====================
function initSalesChart(canvasId, labels, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: data,
                borderColor: '#1F1B5B',
                backgroundColor: 'rgba(31, 27, 91, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1F1B5B',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
}

// ==================== File Upload Preview ====================
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!preview || !input.files || !input.files[0]) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

function previewMultipleImages(input, containerId) {
    const container = document.getElementById(containerId);
    if (!container || !input.files) return;
    
    container.innerHTML = '';
    Array.from(input.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'image-preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${index + 1}">
                <button type="button" class="remove-image" data-index="${index}">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

// ==================== Auto-refresh Notifications ====================
function initNotifications() {
    setInterval(() => {
        fetch('/admin/api/notifications/unread')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count > 9 ? '9+' : data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }, 30000);
}

// ==================== Form Validation ====================
function validateForm(formId, rules) {
    const form = document.getElementById(formId);
    if (!form) return true;
    
    let isValid = true;
    const errors = {};
    
    for (const [field, rule] of Object.entries(rules)) {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            const value = input.value;
            
            if (rule.required && !value) {
                errors[field] = `${rule.label} wajib diisi`;
                isValid = false;
            }
            
            if (rule.min && value.length < rule.min) {
                errors[field] = `${rule.label} minimal ${rule.min} karakter`;
                isValid = false;
            }
            
            if (rule.email && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                errors[field] = 'Format email tidak valid';
                isValid = false;
            }
            
            if (rule.number && value && isNaN(value)) {
                errors[field] = `${rule.label} harus berupa angka`;
                isValid = false;
            }
        }
    }
    
    // Display errors
    for (const [field, message] of Object.entries(errors)) {
        const errorEl = document.getElementById(`${field}_error`);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    }
    
    return isValid;
}

// ==================== Initialize on DOM Load ====================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(el => {
        el.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            tooltip.style.left = rect.left + (rect.width - tooltip.offsetWidth) / 2 + 'px';
            
            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            });
        });
    });
    
    // Initialize data tables
    const dataTables = document.querySelectorAll('.data-table');
    dataTables.forEach(table => {
        // Add sorting functionality
        const headers = table.querySelectorAll('th.sortable');
        headers.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.column;
                const currentDir = this.dataset.dir || 'asc';
                const newDir = currentDir === 'asc' ? 'desc' : 'asc';
                
                // Update header indicators
                headers.forEach(h => {
                    h.classList.remove('sort-asc', 'sort-desc');
                    h.dataset.dir = '';
                });
                this.classList.add(`sort-${newDir}`);
                this.dataset.dir = newDir;
                
                // Sort table
                sortTable(table, column, newDir);
            });
        });
    });
    
    // Initialize notifications
    initNotifications();
});

function sortTable(table, column, dir) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aVal = a.querySelector(`td:nth-child(${parseInt(column) + 1})`).textContent;
        const bVal = b.querySelector(`td:nth-child(${parseInt(column) + 1})`).textContent;
        
        if (dir === 'asc') {
            return aVal.localeCompare(bVal);
        } else {
            return bVal.localeCompare(aVal);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// Export to global
window.showToast = showToast;
window.confirmDelete = confirmDelete;
window.updateStatus = updateStatus;
window.exportData = exportData;
window.printInvoice = printInvoice;
window.printResi = printResi;
window.initSalesChart = initSalesChart;
window.previewImage = previewImage;
window.previewMultipleImages = previewMultipleImages;
window.validateForm = validateForm;
window.toggleUserMenu = toggleUserMenu;