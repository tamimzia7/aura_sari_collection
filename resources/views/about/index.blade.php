@extends('layouts.app')

@section('title', 'About AURA - Our Story')
@section('meta_description', 'Discover the story behind AURA - a premium saree brand crafting elegance since 2024. Learn about our mission, vision, and commitment to timeless beauty.')

@push('styles')
<style>
.about-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #2d1b69 100%);
    padding: 120px 0;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}
.about-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    font-weight: 700;
    letter-spacing: 4px;
    margin-bottom: 1rem;
    position: relative;
}
.about-hero .lead {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    letter-spacing: 6px;
    opacity: 0.9;
    font-weight: 400;
}
.about-hero .hero-line {
    width: 60px;
    height: 2px;
    background: #d4af37;
    margin: 20px auto;
}
.about-section {
    padding: 80px 0;
}
.about-section .section-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #1a1a2e;
}
.about-section .section-subtitle {
    color: #d4af37;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 0.5rem;
    font-weight: 600;
}
.story-text {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #555;
    max-width: 800px;
    margin: 0 auto;
}
.story-text::first-letter {
    font-family: 'Playfair Display', serif;
    font-size: 4rem;
    float: left;
    line-height: 1;
    color: #d4af37;
    margin-right: 10px;
    font-weight: 700;
}
.mission-card, .vision-card {
    border: none;
    border-radius: 16px;
    padding: 40px 30px;
    transition: transform 0.3s, box-shadow 0.3s;
    height: 100%;
}
.mission-card:hover, .vision-card:hover {
    transform: translateY(-5px);
}
.mission-card {
    background: linear-gradient(135deg, #1a1a2e 0%, #2d1b69 100%);
    color: white;
}
.vision-card {
    background: linear-gradient(135deg, #2d1b69 0%, #1a1a2e 100%);
    color: white;
}
.mission-card .card-icon, .vision-card .card-icon {
    width: 60px;
    height: 60px;
    background: rgba(212, 175, 55, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    color: #d4af37;
}
.mission-card h3, .vision-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}
.mission-card p, .vision-card p {
    opacity: 0.85;
    line-height: 1.7;
}
.timeline-wrapper {
    position: relative;
    max-width: 700px;
    margin: 0 auto;
}
.timeline-wrapper::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #d4af37, #1a1a2e);
}
.timeline-item {
    position: relative;
    padding-left: 60px;
    margin-bottom: 50px;
}
.timeline-item:last-child {
    margin-bottom: 0;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 5px;
    width: 18px;
    height: 18px;
    background: #d4af37;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #d4af37;
    z-index: 1;
}
.timeline-item .year {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    color: #d4af37;
    font-weight: 700;
    margin-bottom: 0.3rem;
}
.timeline-item h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}
.timeline-item p {
    color: #666;
    line-height: 1.7;
}
.value-card {
    border: none;
    border-radius: 12px;
    padding: 35px 25px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    background: white;
    height: 100%;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
}
.value-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}
.value-card .value-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #1a1a2e, #2d1b69);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.8rem;
    color: #d4af37;
}
.value-card h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: #1a1a2e;
    margin-bottom: 0.8rem;
}
.value-card p {
    color: #777;
    font-size: 0.95rem;
    line-height: 1.7;
}
.team-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s;
    background: white;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
}
.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}
.team-card .team-img {
    width: 100%;
    height: 280px;
    object-fit: cover;
}
.team-card .team-placeholder {
    width: 100%;
    height: 280px;
    background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #ccc;
}
.team-card .card-body {
    padding: 1.5rem;
    text-align: center;
}
.team-card h5 {
    font-family: 'Playfair Display', serif;
    color: #1a1a2e;
    margin-bottom: 0.3rem;
}
.team-card .role {
    color: #d4af37;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
}
.bg-soft {
    background-color: #f8f7f4;
}
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="about-hero">
    <div class="container">
        <h1 class="animate__animated animate__fadeInDown">OUR STORY</h1>
        <div class="hero-line"></div>
        <p class="lead animate__animated animate__fadeInUp">Crafting Elegance Since 2024</p>
    </div>
</section>

<!-- Brand Story -->
<section class="about-section">
    <div class="container text-center">
        <p class="section-subtitle">Who We Are</p>
        <h2 class="section-title">The Art of Timeless Beauty</h2>
        <div class="story-text">
            <p>AURA was born from a singular vision — to celebrate the saree not just as a garment, but as a living canvas of art, heritage, and emotion. Founded in 2024, our journey began with a deep reverence for India's textile traditions and a burning desire to reimagine them for the modern woman.</p>
            <p class="mt-3">Every saree at AURA is a carefully curated masterpiece. We travel across the length and breadth of India — from the silk looms of Kanchipuram to the handloom clusters of Varanasi — to bring you weaves that tell stories spanning generations. Our founders, lifelong connoisseurs of fine textiles, envisioned a brand where centuries-old craftsmanship meets contemporary aesthetics.</p>
            <p class="mt-3">At AURA, we believe a saree is more than six yards of fabric. It is confidence draped around a woman. It is the whisper of silk at a wedding, the grace of georgette at a gala, the comfort of cotton on a summer afternoon. Each piece in our collection is chosen not just for its beauty, but for the way it makes a woman feel — empowered, elegant, and unmistakably herself.</p>
            <p class="mt-4 fst-italic text-muted">"Every woman deserves to feel extraordinary. AURA is our tribute to that belief."</p>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="about-section bg-soft">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-subtitle">Our Purpose</p>
            <h2 class="section-title">Mission & Vision</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mission-card">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To curate and deliver the finest collection of authentic Indian sarees, bridging the gap between traditional craftsmanship and modern elegance. We are committed to preserving India's rich weaving heritage while making it accessible to women worldwide, ensuring every purchase supports artisan communities and sustains age-old techniques.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vision-card">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To become the world's most cherished destination for premium sarees — a brand that stands synonymous with quality, trust, and timeless beauty. We envision a future where every woman, regardless of where she is in the world, can experience the magic of a perfectly crafted saree and feel connected to the rich tapestry of Indian culture.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-subtitle">Our Journey</p>
            <h2 class="section-title">Brand Milestones</h2>
        </div>
        <div class="timeline-wrapper">
            <div class="timeline-item">
                <div class="year">January 2024</div>
                <h4>The Birth of AURA</h4>
                <p>AURA was founded with a vision to redefine the saree shopping experience. Our founders spent months travelling across India's weaving clusters, building relationships with master artisans and understanding the nuances of different looms.</p>
            </div>
            <div class="timeline-item">
                <div class="year">March 2024</div>
                <h4>First Collection Launch</h4>
                <p>We launched our debut collection featuring 50 handpicked sarees from Kanchipuram, Banarasi, and Chanderi weaves. The response was overwhelming, with our entire first batch selling out within weeks.</p>
            </div>
            <div class="timeline-item">
                <div class="year">June 2024</div>
                <h4>Expansion & New Partnerships</h4>
                <p>Partnered with 25 new artisan cooperatives across India, expanding our collection to include Patola, Paithani, and Sambalpuri weaves. Our team grew to include skilled stylists and quality assurance experts.</p>
            </div>
            <div class="timeline-item">
                <div class="year">September 2024</div>
                <h4>Bridal Collection Launch</h4>
                <p>Introduced our exclusive bridal collection, featuring bespoke designs created in collaboration with master weavers. Each piece is a one-of-a-kind creation, designed to make every bride's special day unforgettable.</p>
            </div>
            <div class="timeline-item">
                <div class="year">December 2024</div>
                <h4>International Shipping</h4>
                <p>Expanded our reach globally, shipping to over 15 countries. Our commitment to quality and authenticity earned us recognition as one of the most promising luxury saree brands of the year.</p>
            </div>
            <div class="timeline-item">
                <div class="year">2025 & Beyond</div>
                <h4>Continuing the Legacy</h4>
                <p>We continue to grow, innovate, and celebrate the timeless beauty of the Indian saree. With plans to launch sustainable collections and support more artisan communities, our journey has only just begun.</p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="about-section bg-soft">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-subtitle">What We Stand For</p>
            <h2 class="section-title">Our Core Values</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-hand-sparkles"></i>
                    </div>
                    <h5>Craftsmanship</h5>
                    <p>We honour the hands that weave magic into every thread. Every AURA saree is a testament to centuries of weaving tradition and the skill of master artisans.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h5>Quality</h5>
                    <p>We never compromise on quality. Each saree undergoes rigorous quality checks to ensure it meets our exacting standards of fabric, finish, and design.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5>Authenticity</h5>
                    <p>We are committed to 100% authentic, handloom products. Every saree comes with a certificate of authenticity, guaranteeing its origin and craftsmanship.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5>Community</h5>
                    <p>We believe in empowering artisan communities. A portion of every purchase goes back to supporting weaver families and preserving traditional weaving techniques.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5>Sustainability</h5>
                    <p>We are committed to sustainable practices, from eco-friendly packaging to promoting natural dyes and supporting slow fashion over mass production.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5>Excellence</h5>
                    <p>From the moment you discover AURA to the day your saree arrives, we strive for excellence in every interaction, every detail, and every experience.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-subtitle">Meet Our Team</p>
            <h2 class="section-title">The People Behind AURA</h2>
            <p class="text-muted mt-3">A passionate team dedicated to bringing you the finest sarees from across India.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-placeholder">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="card-body">
                        <h5>Ananya Sharma</h5>
                        <p class="role">Founder & Creative Director</p>
                        <p class="text-muted small">Visionary leader with a passion for Indian textiles and design.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-placeholder">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="card-body">
                        <h5>Priya Patel</h5>
                        <p class="role">Head of Curation</p>
                        <p class="text-muted small">Expert textile connoisseur with a decade of experience in handloom.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-placeholder">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="card-body">
                        <h5>Vikram Singh</h5>
                        <p class="role">Operations Manager</p>
                        <p class="text-muted small">Ensures every order reaches you with perfection and care.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-placeholder">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="card-body">
                        <h5>Meera Krishnan</h5>
                        <p class="role">Customer Experience</p>
                        <p class="text-muted small">Dedicated to making every AURA experience unforgettable.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
new WOW().init();
</script>
@endpush
