/**
 * AURA - E-Commerce JavaScript
 */

(function () {
    'use strict';

    const AURA = {
        init() {
            this.cart = {
                count: parseInt(document.querySelector('.cart-count')?.textContent || '0'),
            };
            this.wishlist = {
                count: parseInt(document.querySelector('.wishlist-count')?.textContent || '0'),
            };

            this.cacheDOM();
            this.bindEvents();
            this.initTooltips();
            this.refreshCounts();
        },

        cacheDOM() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            this.searchInput = document.getElementById('searchInput');
            this.searchResults = document.getElementById('searchResults');
            this.toastContainer = this.createToastContainer();
        },

        createToastContainer() {
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            return container;
        },

        bindEvents() {
            document.addEventListener('click', (e) => {
                const addBtn = e.target.closest('.add-to-cart-btn');
                if (addBtn) {
                    if (addBtn.hasAttribute('onclick')) return;
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.addToCart(addBtn);
                }

                const wishBtn = e.target.closest('.wishlist-btn');
                if (wishBtn) {
                    if (wishBtn.hasAttribute('onclick')) return;
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.toggleWishlist(wishBtn);
                }

                const qvBtn = e.target.closest('.quick-view-btn');
                if (qvBtn) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.quickView(qvBtn);
                }

                const qtyInput = e.target.closest('.quantity-input');
                if (qtyInput) {
                    e.stopImmediatePropagation();
                    this.handleQuantityChange(qtyInput);
                }

                const removeBtn = e.target.closest('.remove-cart-item');
                if (removeBtn) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    this.removeFromCart(removeBtn);
                }
            });

            document.addEventListener('change', (e) => {
                const qtyInput = e.target.closest('.quantity-input');
                if (qtyInput) {
                    this.handleQuantityChange(qtyInput);
                }
            });

            document.addEventListener('submit', (e) => {
                const newsletterForm = e.target.closest('#newsletterForm');
                if (newsletterForm) {
                    e.preventDefault();
                    this.handleNewsletter(newsletterForm);
                }
            });

            if (this.searchInput) {
                let debounceTimer;
                this.searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => this.liveSearch(), 350);
                });

                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.search-input') && !e.target.closest('#searchResults')) {
                        this.hideSearchResults();
                    }
                });
            }

            document.addEventListener('cart-updated', (e) => {
                if (e.detail && e.detail.cart_count !== undefined) {
                    this.cart.count = e.detail.cart_count;
                }
                this.updateCartBadge();
            });
            document.addEventListener('wishlist-updated', (e) => {
                if (e.detail && e.detail.wishlist_count !== undefined) {
                    this.wishlist.count = e.detail.wishlist_count;
                }
                this.updateWishlistBadge();
            });
        },

        initTooltips() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                tooltips.forEach((el) => new bootstrap.Tooltip(el));
            }
        },

        /* ==============================================
           Cart Functions
           ============================================== */

        addToCart(btn) {
            const productId = btn.dataset.productId;
            const productName = btn.dataset.productName;
            const productPrice = btn.dataset.productPrice;
            const productImage = btn.dataset.productImage;

            if (btn.classList.contains('btn-loading')) return;

            btn.classList.add('btn-loading');

            const formData = new FormData();
            formData.append('_token', this.csrfToken);
            formData.append('product_id', productId);
            formData.append('quantity', 1);

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then((res) => {
                    if (res.status === 401) {
                        window.location.href = '/login';
                        return null;
                    }
                    if (!res.ok) throw new Error('Request failed');
                    return res.json();
                })
                .then((data) => {
                    if (!data) return;
                    if (data.success) {
                        if (data.in_cart) {
                            btn.innerHTML = '<i class="fas fa-check me-1"></i> Remove from Cart';
                            btn.classList.add('in-cart');
                            this.showToast('Added to Cart', 'success');
                        } else {
                            btn.innerHTML = '<i class="fas fa-shopping-bag me-1"></i> Add to Cart';
                            btn.classList.remove('in-cart');
                            this.showToast('Removed from Cart', 'info');
                        }
                        this.cart.count = data.cart_count ?? this.cart.count;
                        this.updateCartBadge();
                        document.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                    } else {
                        this.showToast(data.message || 'Failed to add to cart', 'error');
                    }
                })
                .catch(() => {
                    this.showToast('Something went wrong. Please try again.', 'error');
                })
                .finally(() => {
                    btn.classList.remove('btn-loading');
                });
        },

        removeFromCart(btn) {
            const cartId = btn.dataset.cartId;
            if (!confirm('Remove this item from cart?')) return;

            const formData = new FormData();
            formData.append('_token', this.csrfToken);
            formData.append('cart_id', cartId);

            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        this.cart.count = data.cart_count ?? Math.max(0, this.cart.count - 1);
                        this.updateCartBadge();
                        const row = btn.closest('.cart-item');
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.transform = 'translateX(50px)';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                        this.showToast('Removed from Cart', 'info');
                        document.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                    } else {
                        this.showToast(data.message || 'Failed to remove item', 'error');
                    }
                })
                .catch(() => {
                    this.showToast('Something went wrong.', 'error');
                });
        },

        handleQuantityChange(input) {
            const cartId = input.dataset.cartId;
            const qty = parseInt(input.value) || 1;

            if (qty < 1) {
                input.value = 1;
                return;
            }

            const formData = new FormData();
            formData.append('_token', this.csrfToken);
            formData.append('cart_id', cartId);
            formData.append('quantity', qty);

            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        this.cart.count = data.cart_count ?? this.cart.count;
                        this.updateCartBadge();

                        if (data.subtotal && data.total) {
                            const subtotalEl = document.querySelector('.cart-subtotal');
                            const totalEl = document.querySelector('.cart-total');
                            if (subtotalEl) subtotalEl.textContent = data.subtotal;
                            if (totalEl) totalEl.textContent = data.total;
                        }

                        document.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
                    }
                })
                .catch(() => {
                    this.showToast('Failed to update quantity', 'error');
                });
        },

        updateCartBadge() {
            setCartBadge(this.cart.count);
        },

        /* ==============================================
           Wishlist Functions
           ============================================== */

        toggleWishlist(btn) {
            const productId = btn.dataset.productId;

            if (btn.classList.contains('btn-loading')) return;
            btn.classList.add('btn-loading');

            const formData = new FormData();
            formData.append('_token', this.csrfToken);
            formData.append('product_id', productId);

            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then((res) => {
                    if (res.status === 401) {
                        window.location.href = '/login';
                        return null;
                    }
                    if (!res.ok) throw new Error('Request failed');
                    return res.json();
                })
                .then((data) => {
                    if (!data) return;
                    if (data.success) {
                        btn.classList.toggle('active', data.in_wishlist);
                        const icon = btn.querySelector('i');
                        icon.className = data.in_wishlist ? 'fas fa-heart' : 'far fa-heart';
                        this.wishlist.count = data.wishlist_count ?? this.wishlist.count;
                        this.updateWishlistBadge();
                        this.showToast(data.in_wishlist ? 'Added to Wishlist' : 'Removed from Wishlist', data.in_wishlist ? 'success' : 'info');
                        document.dispatchEvent(new CustomEvent('wishlist-updated', { detail: data }));
                    } else {
                        this.showToast(data.message || 'Unable to update wishlist', 'error');
                    }
                })
                .catch(() => {
                    this.showToast('Something went wrong.', 'error');
                })
                .finally(() => {
                    btn.classList.remove('btn-loading');
                });
        },

        updateWishlistBadge() {
            setWishlistBadge(this.wishlist.count);
        },

        refreshCounts() {
            fetch('/cart/count', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        this.cart.count = data.cart_count ?? this.cart.count;
                        this.wishlist.count = data.wishlist_count ?? this.wishlist.count;
                        this.updateCartBadge();
                        this.updateWishlistBadge();
                    }
                })
                .catch(() => {});
            this.syncProductCards();
        },

        syncProductCards() {
            fetch('/cart/ids', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (!data.success) return;
                    const cartIds = data.cart_ids || [];
                    const wishlistIds = data.wishlist_ids || [];

                    document.querySelectorAll('.wishlist-btn').forEach((btn) => {
                        if (btn.hasAttribute('onclick')) return;
                        const pid = btn.dataset.productId;
                        if (!pid) return;
                        const inWishlist = wishlistIds.includes(pid);
                        btn.classList.toggle('active', inWishlist);
                        const icon = btn.querySelector('i');
                        if (icon) icon.className = inWishlist ? 'fas fa-heart' : 'far fa-heart';
                    });

                    document.querySelectorAll('.add-to-cart-btn').forEach((btn) => {
                        if (btn.hasAttribute('onclick')) return;
                        const pid = btn.dataset.productId;
                        if (!pid) return;
                        const inCart = cartIds.includes(pid);
                        btn.classList.toggle('in-cart', inCart);
                        if (inCart) {
                            btn.innerHTML = '<i class="fas fa-check me-1"></i> Remove from Cart';
                        } else {
                            btn.innerHTML = '<i class="fas fa-shopping-bag me-1"></i> Add to Cart';
                        }
                    });
                })
                .catch(() => {});
        },

        /* ==============================================
           Live Search
           ============================================== */

        liveSearch() {
            const query = this.searchInput.value.trim();

            if (query.length < 2) {
                this.hideSearchResults();
                return;
            }

            fetch(`/search/ajax?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.results && data.results.length > 0) {
                        this.renderSearchResults(data.results);
                    } else {
                        this.renderSearchResults(null, 'No products found');
                    }
                })
                .catch(() => {
                    this.hideSearchResults();
                });
        },

        renderSearchResults(results, emptyMessage) {
            if (emptyMessage) {
                this.searchResults.innerHTML = `
                    <div class="search-result-item">
                        <span class="text-muted small">${emptyMessage}</span>
                    </div>
                `;
            } else {
                this.searchResults.innerHTML = results
                    .map(
                        (item) => `
                        <a href="/product/${item.slug || item.id}" class="search-result-item text-decoration-none">
                            <img src="${item.image || '/images/placeholder.jpg'}" alt="${item.name}" loading="lazy">
                            <div>
                                <div class="result-name text-dark">${item.name}</div>
                                <div class="result-price">₹${Number(item.price).toLocaleString()}</div>
                            </div>
                        </a>
                    `
                    )
                    .join('');

                if (results.length >= 5) {
                    this.searchResults.innerHTML += `
                        <div class="text-center py-2">
                            <a href="/search?q=${encodeURIComponent(this.searchInput.value)}" class="small text-decoration-none">
                                View all results <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    `;
                }
            }

            this.searchResults.style.display = 'block';
        },

        hideSearchResults() {
            if (this.searchResults) {
                this.searchResults.style.display = 'none';
            }
        },

        /* ==============================================
           Quick View
           ============================================== */

        quickView(btn) {
            const productId = btn.dataset.productId;

            if (btn.classList.contains('btn-loading')) return;
            btn.classList.add('btn-loading');

            fetch(`/products/quick-view/${productId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.html) {
                        this.showQuickViewModal(data.html);
                    } else if (data.product) {
                        this.showQuickViewModal(this.buildQuickViewHTML(data.product));
                    }
                })
                .catch(() => {
                    this.showToast('Unable to load product details.', 'error');
                })
                .finally(() => {
                    btn.classList.remove('btn-loading');
                });
        },

        buildQuickViewHTML(product) {
            return `
                <div class="row g-4">
                    <div class="col-md-6">
                        <img src="${product.image || '/images/placeholder.jpg'}" alt="${product.name}" class="quick-view-image">
                    </div>
                    <div class="col-md-6">
                        <h4 class="fw-bold">${product.name}</h4>
                        ${product.brand ? `<p class="text-muted small text-uppercase">${product.brand}</p>` : ''}
                        <div class="product-price mb-3">
                            ${product.discount_price
                                ? `<span class="fw-bold fs-4">₹${Number(product.discount_price).toLocaleString()}</span>
                                   <span class="text-muted text-decoration-line-through ms-2">₹${Number(product.price).toLocaleString()}</span>`
                                : `<span class="fw-bold fs-4">₹${Number(product.price).toLocaleString()}</span>`
                            }
                        </div>
                        <p class="text-muted small">${product.short_description || ''}</p>
                        <button class="btn btn-dark btn-lg w-100 rounded-pill add-to-cart-btn"
                                data-product-id="${product.id}"
                                data-product-name="${product.name}"
                                data-product-price="${product.discount_price || product.price}"
                                data-product-image="${product.image || '/images/placeholder.jpg'}">
                            <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                        </button>
                        <a href="/product/${product.slug || product.id}" class="btn btn-outline-dark w-100 rounded-pill mt-2">
                            View Full Details
                        </a>
                    </div>
                </div>
            `;
        },

        showQuickViewModal(html) {
            let modalEl = document.getElementById('quickViewModal');
            if (!modalEl) {
                modalEl = document.createElement('div');
                modalEl.id = 'quickViewModal';
                modalEl.className = 'modal fade';
                modalEl.setAttribute('tabindex', '-1');
                modalEl.setAttribute('aria-hidden', 'true');
                modalEl.innerHTML = `
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div id="quickViewContent"></div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modalEl);
            }

            document.getElementById('quickViewContent').innerHTML = html;

            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            this.syncProductCards();

            modalEl.addEventListener('hidden.bs.modal', () => {
                document.getElementById('quickViewContent').innerHTML = '';
            });
        },

        /* ==============================================
           Newsletter
           ============================================== */

        handleNewsletter(form) {
            const email = form.querySelector('input[type="email"]').value.trim();
            const messageEl = form.querySelector('.newsletter-message');

            if (!email) return;

            messageEl.innerHTML = '<span class="text-info">Subscribing...</span>';

            const formData = new FormData();
            formData.append('_token', this.csrfToken);
            formData.append('email', email);

            fetch('/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        messageEl.innerHTML = '<span class="text-success">Thank you for subscribing!</span>';
                        form.querySelector('input[type="email"]').value = '';
                        setTimeout(() => { messageEl.innerHTML = ''; }, 3000);
                    } else {
                        messageEl.innerHTML = `<span class="text-danger">${data.message || 'Something went wrong.'}</span>`;
                    }
                })
                .catch(() => {
                    messageEl.innerHTML = '<span class="text-danger">Something went wrong. Please try again.</span>';
                });
        },

        /* ==============================================
           Toast Notifications
           ============================================== */

        showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                info: 'fas fa-info-circle',
            };
            toast.innerHTML = `
                <i class="${icons[type] || icons.info}"></i>
                <span>${message}</span>
            `;
            this.toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.style.transition = 'all 0.3s ease';
                toast.style.transform = 'translateX(100%)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 1000);
        },
    };

    window.AURA = AURA;
    window.showToast = (message, type) => AURA.showToast(message, type);

    window.setCartBadge = function (count) {
        const el = document.getElementById('cartCount');
        if (!el) return;
        AURA.cart.count = count;
        el.textContent = count;
        el.classList.toggle('d-none', count <= 0);
        el.classList.remove('cart-count-bump');
        void el.offsetWidth;
        el.classList.add('cart-count-bump');
    };

    window.setWishlistBadge = function (count) {
        const el = document.getElementById('wishlistCount');
        if (!el) return;
        AURA.wishlist.count = count;
        el.textContent = count;
        el.classList.toggle('d-none', count <= 0);
        el.classList.remove('wishlist-count-bump');
        void el.offsetWidth;
        el.classList.add('wishlist-count-bump');
    };

    window.setNotifBadge = function (count) {
        const el = document.getElementById('notificationCount');
        if (!el) return;
        if (count > 0) {
            el.style.display = '';
            el.textContent = count;
        } else {
            el.style.display = 'none';
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => AURA.init());
    } else {
        AURA.init();
    }
})();
