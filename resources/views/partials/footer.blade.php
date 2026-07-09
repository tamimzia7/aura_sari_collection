<footer class="aura-footer">
    <div class="aura-footer-decor"></div>
    <div class="container">
        <div class="row g-5 py-5">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="aura-footer-brand">AURA</a>
                <p class="aura-footer-desc mt-3">
                    Curating the finest sarees that blend timeless tradition with contemporary elegance.
                    Each piece tells a story of craftsmanship, heritage, and unparalleled beauty.
                    Inspired by the cosmos, crafted for the extraordinary.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="aura-social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="aura-social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="aura-social-icon" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" class="aura-social-icon" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="aura-social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 offset-lg-1">
                <h6 class="aura-footer-heading">Quick Links</h6>
                <ul class="list-unstyled aura-footer-links">
                    <li><a href="{{ route('collection') }}">Shop</a></li>
                    <li><a href="{{ route('products.collection', ['slug' => 'silk']) }}">Collections</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 offset-lg-1">
                <h6 class="aura-footer-heading">Follow Us</h6>
                <p class="aura-footer-desc small">
                    Stay connected for exclusive previews, behind-the-scenes stories, and celestial drops.
                </p>

                <h6 class="aura-footer-heading mt-4">Newsletter</h6>
                <form class="aura-newsletter mt-2" id="newsletterForm">
                    @csrf
                    <div class="input-group">
                        <input type="email" class="form-control aura-newsletter-input" placeholder="Your email" required>
                        <button class="btn aura-newsletter-btn" type="submit">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <div class="newsletter-message mt-2 small"></div>
                </form>
            </div>
        </div>

        <div class="aura-footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} AURA. All rights reserved. Crafted with care.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="{{ route('privacy') }}">Privacy</a></li>
                        <li class="list-inline-item"><span class="mx-1">|</span></li>
                        <li class="list-inline-item"><a href="{{ route('terms') }}">Terms</a></li>
                        <li class="list-inline-item"><span class="mx-1">|</span></li>
                        <li class="list-inline-item"><a href="{{ route('sitemap') }}">Sitemap</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('styles')
<style>
/* ─── AURA FOOTER ─── */
.aura-footer {
    background: #060612;
    border-top: 1px solid rgba(212, 175, 55, 0.06);
    position: relative;
    overflow: hidden;
}

.aura-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.2), transparent);
}

.aura-footer-brand {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 700;
    letter-spacing: 0.3em;
    background: linear-gradient(135deg, #d4af37, #f0d68a, #d4af37);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-decoration: none;
}

.aura-footer-desc {
    color: rgba(255, 255, 255, 0.45);
    font-size: 0.85rem;
    line-height: 1.7;
    max-width: 320px;
}

.aura-footer-heading {
    color: #d4af37;
    font-family: 'Playfair Display', serif;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 1rem;
    position: relative;
    padding-bottom: 0.75rem;
}

.aura-footer-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 1px;
    background: #d4af37;
}

.aura-footer-links {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
}

.aura-footer-links a {
    color: rgba(255, 255, 255, 0.5);
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.3s, padding-left 0.3s;
    display: inline-block;
}

.aura-footer-links a:hover {
    color: #d4af37;
    padding-left: 4px;
}

.aura-social-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(212, 175, 55, 0.2);
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.aura-social-icon:hover {
    background: rgba(212, 175, 55, 0.1);
    border-color: #d4af37;
    color: #d4af37;
    transform: translateY(-2px);
}

.aura-newsletter .input-group {
    max-width: 320px;
}

.aura-newsletter-input {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(212, 175, 55, 0.15) !important;
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 0.85rem !important;
    padding: 0.6rem 1rem !important;
    border-radius: 8px 0 0 8px !important;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.aura-newsletter-input:focus {
    border-color: #d4af37 !important;
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1) !important;
}

.aura-newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.3);
}

.aura-newsletter-btn {
    background: linear-gradient(135deg, #d4af37, #c9a032) !important;
    border: none !important;
    border-radius: 0 8px 8px 0 !important;
    color: #0a0a1a !important;
    padding: 0.6rem 1.2rem !important;
    font-weight: 600;
    transition: all 0.3s ease;
}

.aura-newsletter-btn:hover {
    background: linear-gradient(135deg, #e0c04a, #d4af37) !important;
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
}

.aura-footer-decor {
    position: absolute;
    bottom: -80px;
    right: -80px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.04) 0%, transparent 70%);
    pointer-events: none;
}

.aura-footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    padding: 1.5rem 0;
    margin-top: 0.5rem;
}

.aura-footer-bottom p {
    color: rgba(255, 255, 255, 0.35);
    font-size: 0.8rem;
}

.aura-footer-bottom a {
    color: rgba(255, 255, 255, 0.35);
    text-decoration: none;
    font-size: 0.8rem;
    transition: color 0.3s;
}

.aura-footer-bottom a:hover {
    color: #d4af37;
}

@media (max-width: 767.98px) {
    .aura-footer-desc {
        max-width: 100%;
    }
}
</style>
@endpush
