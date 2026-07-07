<footer class="footer bg-dark text-light pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-brand fw-bold mb-3">AURA</h5>
                <p class="text-muted small mb-3">
                    Curating the finest sarees that blend timeless tradition with contemporary elegance. 
                    Each piece tells a story of craftsmanship, heritage, and unparalleled beauty.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="social-icon text-light" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon text-light" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon text-light" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" class="social-icon text-light" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon text-light" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-uppercase small mb-3">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none small">Home</a></li>
                    <li class="mb-2"><a href="{{ route('collection') }}" class="text-muted text-decoration-none small">The Canvas</a></li>
                    <li class="mb-2"><a href="{{ route('collection', ['category' => 'silk']) }}" class="text-muted text-decoration-none small">Silk Collection</a></li>
                    <li class="mb-2"><a href="{{ route('collection', ['category' => 'bridal']) }}" class="text-muted text-decoration-none small">Bridal Collection</a></li>
                    <li class="mb-2"><a href="{{ route('collection', ['category' => 'cotton']) }}" class="text-muted text-decoration-none small">Cotton Collection</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-muted text-decoration-none small">About Us</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-uppercase small mb-3">Customer Service</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-muted text-decoration-none small">Contact Us</a></li>
                    <li class="mb-2"><a href="{{ route('faq') }}" class="text-muted text-decoration-none small">FAQ</a></li>
                    <li class="mb-2"><a href="{{ route('shipping') }}" class="text-muted text-decoration-none small">Shipping & Delivery</a></li>
                    <li class="mb-2"><a href="{{ route('returns') }}" class="text-muted text-decoration-none small">Returns & Exchanges</a></li>
                    <li class="mb-2"><a href="{{ route('size-guide') }}" class="text-muted text-decoration-none small">Size Guide</a></li>
                    <li class="mb-2"><a href="{{ route('privacy') }}" class="text-muted text-decoration-none small">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-uppercase small mb-3">Newsletter</h6>
                <p class="text-muted small mb-2">Subscribe for exclusive collections, offers, and AURA stories.</p>
                <form class="newsletter-form mb-3" id="newsletterForm">
                    @csrf
                    <div class="input-group input-group-sm">
                        <input type="email" class="form-control bg-dark border-secondary text-light" placeholder="Your email address" required>
                        <button class="btn btn-light" type="submit"><i class="fas fa-arrow-right"></i></button>
                    </div>
                    <div class="newsletter-message mt-2 small"></div>
                </form>
                <div class="mt-3">
                    <img src="{{ asset('images/payment-methods.png') }}" alt="Payment Methods" class="img-fluid" style="max-height: 30px;" onerror="this.style.display='none'">
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        <span class="badge bg-secondary"><i class="fab fa-cc-visa me-1"></i>Visa</span>
                        <span class="badge bg-secondary"><i class="fab fa-cc-mastercard me-1"></i>Mastercard</span>
                        <span class="badge bg-secondary"><i class="fab fa-cc-paypal me-1"></i>PayPal</span>
                        <span class="badge bg-secondary"><i class="fab fa-cc-amex me-1"></i>Amex</span>
                        <span class="badge bg-secondary"><i class="fas fa-mobile-alt me-1"></i>UPI</span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} AURA. All rights reserved. Crafted with care.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('privacy') }}" class="text-muted small text-decoration-none">Privacy</a></li>
                    <li class="list-inline-item"><span class="text-muted small">|</span></li>
                    <li class="list-inline-item"><a href="{{ route('terms') }}" class="text-muted small text-decoration-none">Terms</a></li>
                    <li class="list-inline-item"><span class="text-muted small">|</span></li>
                    <li class="list-inline-item"><a href="{{ route('sitemap') }}" class="text-muted small text-decoration-none">Sitemap</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
