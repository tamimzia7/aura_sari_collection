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
            this.updateCartBadge();
            this.updateWishlistBadge();
        },

        cacheDOM() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            this.cartCountEl = document.getElementById('cartCount');
            this.wishlistCountEl = document.getElementById('wishlistCount');
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
                    e.preventDefault();
                    this.addToCart(addBtn);
                }

                const wishBtn = e.target.closest('.wishlist-btn');
                if (wishBtn) {
                    e.preventDefault();
                    this.toggleWishlist(wishBtn);
                }

                const qvBtn = e.target.closest('.quick-view-btn');
                if (qvBtn) {
                    e.preventDefault();
                    this.quickView(qvBtn);
                }

                const qtyInput = e.target.closest('.quantity-input');
                if (qtyInput) {
                    this.handleQuantityChange(qtyInput);
                }

                const removeBtn = e.target.closest('.remove-cart-item');
                if (removeBtn) {
                    e.preventDefault();
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

            document.addEventListener('cart-updated', () => this.updateCartBadge());
            document.addEventListener('wishlist-updated', () => this.updateWishlistBadge());
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
            formData.append('qty', 1);

            fetch('/cart/add', {
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
                        if (data.cartCount !== undefined) {
                            this.cart.count = data.cartCount;
                        } else {
                            this.cart.count++;
                        }
                        this.updateCartBadge();
                        this.showToast(`${productName} added to cart!`, 'success');
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
            formData.append('_method', 'DELETE');

            fetch(`/cart/${cartId}`, {
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
                        this.cart.count = data.cartCount ?? Math.max(0, this.cart.count - 1);
                        this.updateCartBadge();
                        const row = btn.closest('.cart-item');
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.transform = 'translateX(50px)';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                        this.showToast('Item removed from cart', 'info');
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
            formData.append('_method', 'PATCH');
            formData.append('qty', qty);

            fetch(`/cart/${cartId}`, {
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
                        this.cart.count = data.cartCount ?? this.cart.count;
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
            if (this.cartCountEl) {
                this.cartCountEl.textContent = this.cart.count;
                if (this.cart.count > 0) {
                    this.cartCountEl.classList.remove('d-none');
                } else {
                    this.cartCountEl.classList.add('d-none');
                }
                this.cartCountEl.classList.remove('cart-count-bump');
                void this.cartCountEl.offsetWidth;
                this.cartCountEl.classList.add('cart-count-bump');
            }
        },

        /* ==============================================
           Wishlist Functions
           ============================================== */

        toggleWishlist(btn) {
            const productId = btn.dataset.productId;
            const isActive = btn.classList.contains('active');

            if (btn.classList.contains('btn-loading')) return;
            btn.classList.add('btn-loading');

            const formData = new FormData();
            formData.append('_token', this.csrfToken);
            formData.append('product_id', productId);

            const method = isActive ? 'DELETE' : 'POST';
            const url = isActive ? `/wishlist/${productId}` : '/wishlist/add';

            formData.append('_method', method);

            fetch(url, {
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
                        btn.classList.toggle('active');
                        const icon = btn.querySelector('i');
                        if (btn.classList.contains('active')) {
                            icon.className = 'fas fa-heart';
                            this.wishlist.count = data.wishlistCount ?? this.wishlist.count + 1;
                            this.showToast('Added to wishlist!', 'success');
                        } else {
                            icon.className = 'far fa-heart';
                            this.wishlist.count = data.wishlistCount ?? Math.max(0, this.wishlist.count - 1);
                            this.showToast('Removed from wishlist', 'info');
                        }
                        this.updateWishlistBadge();
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
            if (this.wishlistCountEl) {
                this.wishlistCountEl.textContent = this.wishlist.count;
                if (this.wishlist.count > 0) {
                    this.wishlistCountEl.classList.remove('d-none');
                } else {
                    this.wishlistCountEl.classList.add('d-none');
                }
                this.wishlistCountEl.classList.remove('wishlist-count-bump');
                void this.wishlistCountEl.offsetWidth;
                this.wishlistCountEl.classList.add('wishlist-count-bump');
            }
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

            fetch(`/product/${productId}/quick-view`, {
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

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => AURA.init());
    } else {
        AURA.init();
    }
})();
