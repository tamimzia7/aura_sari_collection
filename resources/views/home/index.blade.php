@extends('layouts.home')

@section('title', 'AURA — The Precision of Elegance')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
  --aura-dark: #0a0a1a;
  --aura-deeper: #060612;
  --aura-gold: #d4af37;
  --aura-gold-light: #f0d68a;
  --aura-blue: #4a9eff;
  --aura-blue-glow: #00d4ff;
  --aura-ivory: #f0e6d3;
  --aura-glass: rgba(255,255,255,0.05);
  --aura-glass-border: rgba(255,255,255,0.1);
  --aura-glass-strong: rgba(255,255,255,0.10);
}

html { scroll-behavior: smooth; }

#collection,
#new {
    scroll-margin-top: 100px;
}

body {
  background: var(--aura-dark);
  color: #fff;
  font-family: 'Inter', sans-serif;
  overflow-x: hidden;
  min-height: 100vh;
}

/* ─── NAV ─── */
.aura-nav {
  position: fixed; top: 0; left: 0; right: 0;
  z-index: 1000;
  display: flex; align-items: center;
  justify-content: space-between;
  padding: 1.5rem 3rem;
  background: linear-gradient(180deg, rgba(10,10,26,0.95) 0%, transparent 100%);
  pointer-events: none;
}
.aura-nav > * { pointer-events: auto; }
.aura-logo {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem; font-weight: 700;
  letter-spacing: 0.3em;
  background: linear-gradient(135deg, var(--aura-gold), var(--aura-ivory));
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text;
  text-decoration: none;
}
.aura-nav-links { display: flex; gap: 2.5rem; list-style: none; align-items: center; }
.aura-nav-links a {
  color: rgba(255,255,255,0.7); text-decoration: none;
  font-size: 0.8rem; letter-spacing: 0.15em; text-transform: uppercase;
  transition: color 0.3s, text-shadow 0.3s;
  position: relative;
}
.aura-nav-links a::after {
  content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 1px;
  background: var(--aura-gold); transition: width 0.4s cubic-bezier(0.25,0.46,0.45,0.94);
}
.aura-nav-links a:hover { color: #fff; }
.aura-nav-links a:hover::after { width: 100%; }
.aura-nav-icons { display: flex; gap: 1.25rem; align-items: center; }
.aura-nav-icons a {
  color: rgba(255,255,255,0.7); font-size: 1.1rem;
  transition: color 0.3s, transform 0.3s;
}
.aura-nav-icons a:hover { color: var(--aura-gold); transform: scale(1.15); }
.aura-nav-icons a i.fa-shopping-bag {
  font-size: 50px;
  line-height: 1;
  background: linear-gradient(135deg, #D4AF37, #F7E7A1);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  filter: drop-shadow(0 0 8px rgba(212,175,55,0.3));
  transition: filter 0.3s ease;
}
.aura-nav-icons a:hover i.fa-shopping-bag {
  filter: drop-shadow(0 0 14px rgba(212,175,55,0.6));
}

/* ─── HERO ─── */
#hero-section {
  position: relative;
  width: 100vw; height: 100vh;
  overflow: hidden;
  background: radial-gradient(ellipse at 50% 40%, #12082a 0%, var(--aura-deeper) 60%, #04040e 100%);
}
#three-canvas {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  display: block; pointer-events: none;
}
.hero-overlay {
  position: absolute; inset: 0;
  background: radial-gradient(ellipse at 50% 70%, transparent 30%, rgba(10,10,26,0.8) 100%);
  pointer-events: none;
}

/* Hero Content */
.hero-content {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  pointer-events: none;
}
.hero-content > * { pointer-events: auto; }

.hero-center {
  text-align: center;
  position: absolute;
  bottom: 18%;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  padding: 0 2rem;
}
.hero-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 0.75rem;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.4);
  margin-bottom: 0.75rem;
  opacity: 0;
}
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.5rem, 8vw, 6rem);
  font-weight: 700;
  line-height: 1.1;
  background: linear-gradient(135deg, var(--aura-gold) 0%, var(--aura-ivory) 40%, var(--aura-gold) 80%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text;
  background-size: 200% auto;
  opacity: 0;
  transform: translateY(30px);
}
.hero-cursor-hint {
  position: absolute;
  bottom: 5%;
  left: 50%;
  transform: translateX(-50%);
  display: flex; flex-direction: column; align-items: center;
  gap: 0.5rem;
  opacity: 0;
  pointer-events: none;
}
.hero-cursor-hint span {
  font-size: 0.6rem;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.3);
}
.cursor-line {
  width: 1px; height: 40px;
  background: linear-gradient(180deg, rgba(255,255,255,0.3), transparent);
  animation: cursorPulse 2s ease-in-out infinite;
}
@keyframes cursorPulse {
  0%, 100% { opacity: 0.3; transform: scaleY(1); }
  50% { opacity: 0.8; transform: scaleY(0.6); }
}

/* Right Floating Product Card */
.floating-product-card {
  position: relative;
  margin-right: auto;
  margin-left: 2rem;
  margin-top: -100px;
  z-index: 100;
  width: 240px;
  padding: 1.75rem;
  background: rgba(255,255,255,0.04);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 16px;
  opacity: 0;
  transition: transform 0.4s cubic-bezier(0.25,0.46,0.45,0.94), box-shadow 0.4s;
}
.floating-product-card:hover {
  transform: scale(1.02);
  box-shadow: 0 0 40px rgba(212,175,55,0.1);
}
.floating-product-card .card-label {
  font-size: 0.55rem; letter-spacing: 0.25em; text-transform: uppercase;
  color: rgba(255,255,255,0.35);
  margin-bottom: 0.5rem;
}
.floating-product-card .card-title {
  font-family: 'Playfair Display', serif;
  font-size: 1rem; font-weight: 600;
  line-height: 1.3;
  margin-bottom: 0.5rem;
  color: #fff;
}
.floating-product-card .card-rating {
  color: var(--aura-gold);
  font-size: 0.7rem;
  margin-bottom: 0.75rem;
  letter-spacing: 2px;
}
.floating-product-card .card-price {
  font-size: 1.25rem; font-weight: 700;
  color: var(--aura-gold);
  margin-bottom: 0.5rem;
}
.floating-product-card .card-badge {
  display: inline-block;
  padding: 0.2rem 0.6rem;
  background: rgba(212,175,55,0.15);
  border: 1px solid rgba(212,175,55,0.25);
  border-radius: 4px;
  font-size: 0.55rem; letter-spacing: 0.15em; text-transform: uppercase;
  color: var(--aura-gold);
  margin-bottom: 0.75rem;
}
.floating-product-card .card-stock {
  font-size: 0.7rem;
  color: rgba(255,255,255,0.5);
  margin-bottom: 1rem;
}
.floating-product-card .card-stock i { color: #4ade80; margin-right: 0.3rem; font-size: 0.5rem; }

/* Vortex Button */
.btn-vortex {
  position: relative;
  width: 100%; padding: 0.85rem 1.5rem;
  border: none; border-radius: 8px;
  background: linear-gradient(135deg, rgba(212,175,55,0.2), rgba(212,175,55,0.05));
  color: var(--aura-gold);
  font-family: 'Inter', sans-serif;
  font-size: 0.7rem; font-weight: 600;
  letter-spacing: 0.15em; text-transform: uppercase;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94);
  border: 1px solid rgba(212,175,55,0.2);
}
.btn-vortex::before {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(212,175,55,0.15), transparent);
  opacity: 0;
  transition: opacity 0.4s;
}
.btn-vortex::after {
  content: '';
  position: absolute; top: -50%; left: -50%;
  width: 200%; height: 200%;
  background: conic-gradient(from 0deg, transparent, rgba(212,175,55,0.1), transparent, rgba(74,158,255,0.1), transparent);
  animation: vortexSpin 4s linear infinite;
  opacity: 0;
  transition: opacity 0.4s;
}
.btn-vortex:hover {
  border-color: var(--aura-gold);
  box-shadow: 0 0 30px rgba(212,175,55,0.2), inset 0 0 30px rgba(212,175,55,0.05);
  transform: translateY(-2px);
}
.btn-vortex:hover::before { opacity: 1; }
.btn-vortex:hover::after { opacity: 1; }
.btn-vortex .btn-content {
  position: relative; z-index: 2;
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
}
@keyframes vortexSpin {
  to { transform: rotate(360deg); }
}

/* ─── BLACK HOLE VORTEX (bottom right) ─── */
.vortex-trigger {
  position: fixed;
  bottom: 30px; right: 30px;
  z-index: 99;
  width: 60px; height: 60px;
  border: none; border-radius: 50%;
  background: transparent;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  pointer-events: auto;
}
.vortex-ring {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(212,175,55,0.15);
  animation: vortexRingPulse 3s ease-in-out infinite;
}
.vortex-ring:nth-child(1) { width: 100%; height: 100%; animation-delay: 0s; }
.vortex-ring:nth-child(2) { width: 140%; height: 140%; animation-delay: 0.5s; }
.vortex-ring:nth-child(3) { width: 180%; height: 180%; animation-delay: 1s; }
.vortex-ring:nth-child(4) { width: 220%; height: 220%; animation-delay: 1.5s; }
.vortex-core {
  width: 20px; height: 20px;
  border-radius: 50%;
  background: radial-gradient(circle, var(--aura-gold-light), var(--aura-gold), transparent);
  box-shadow: 0 0 30px rgba(212,175,55,0.3), 0 0 60px rgba(74,158,255,0.1);
  animation: vortexCorePulse 2s ease-in-out infinite;
}
@keyframes vortexRingPulse {
  0%, 100% { transform: scale(1); opacity: 0.4; }
  50% { transform: scale(1.1); opacity: 0.8; }
}
@keyframes vortexCorePulse {
  0%, 100% { transform: scale(1); box-shadow: 0 0 30px rgba(212,175,55,0.3); }
  50% { transform: scale(1.3); box-shadow: 0 0 50px rgba(212,175,55,0.5), 0 0 80px rgba(74,158,255,0.2); }
}

/* Mini Cart Preview */
.mini-cart-preview {
  position: fixed;
  bottom: 200px; right: 30px;
  width: 300px;
  background: rgba(10,10,26,0.92);
  backdrop-filter: blur(30px);
  -webkit-backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 16px;
  padding: 1.5rem;
  z-index: 98;
  pointer-events: auto;
}
.mini-cart-preview h4 {
  font-family: 'Playfair Display', serif;
  font-size: 0.9rem;
  color: var(--aura-ivory);
  margin-bottom: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.mini-cart-item {
  display: flex; gap: 0.75rem;
  padding: 0.75rem 0;
  border-bottom: 1px solid rgba(255,255,255,0.04);
}
.mini-cart-item img {
  width: 50px; height: 60px;
  object-fit: cover;
  border-radius: 6px;
  background: rgba(255,255,255,0.05);
}
.mini-cart-item .item-info { flex: 1; }
.mini-cart-item .item-info .item-name {
  font-size: 0.75rem; font-weight: 600;
  color: #fff;
}
.mini-cart-item .item-info .item-meta {
  font-size: 0.65rem;
  color: rgba(255,255,255,0.4);
}
.mini-cart-item .item-info .item-price {
  font-size: 0.8rem;
  color: var(--aura-gold);
  font-weight: 600;
}
.mini-cart-preview .cart-total {
  display: flex; justify-content: space-between;
  padding-top: 1rem; margin-top: 0.5rem;
  font-size: 0.8rem;
}
.mini-cart-preview .cart-total span:last-child {
  color: var(--aura-gold); font-weight: 700;
}
.btn-view-cart {
  position: fixed;
  bottom: 190px; right: 30px;
  z-index: 99;
  display: block; width: 300px;
  padding: 0.6rem;
  text-align: center;
  background: rgba(212,175,55,0.1);
  border: 1px solid rgba(212,175,55,0.2);
  border-radius: 8px;
  color: var(--aura-gold);
  font-size: 0.7rem; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  text-decoration: none;
  transition: all 0.3s;
}
.btn-view-cart:hover {
  background: rgba(212,175,55,0.2);
  box-shadow: 0 0 20px rgba(212,175,55,0.15);
}

/* ─── SECTION BASE ─── */
.section {
  position: relative;
  padding: 8rem 2rem;
  background: var(--aura-dark);
}
.section-label {
  font-size: 0.6rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.25);
  margin-bottom: 1rem;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 5vw, 3.5rem);
  font-weight: 700;
  color: #fff;
  margin-bottom: 1.5rem;
}
.section-subtitle {
  font-size: 0.9rem;
  color: rgba(255,255,255,0.5);
  max-width: 500px;
  line-height: 1.7;
}

/* ─── FEATURED COLLECTION ─── */
#featured-collection {
  background: linear-gradient(180deg, var(--aura-deeper) 0%, var(--aura-dark) 100%);
  padding-top: 6rem;
}
.featured-scroll {
  display: flex;
  gap: 1.5rem;
  overflow-x: auto;
  padding: 2rem 0 4rem;
  scroll-snap-type: x mandatory;
  -ms-overflow-style: none; scrollbar-width: none;
  cursor: grab;
}
.featured-scroll::-webkit-scrollbar { display: none; }
.featured-scroll:active { cursor: grabbing; }
.featured-card {
  flex: 0 0 300px;
  scroll-snap-align: start;
  padding: 2rem;
  background: rgba(255,255,255,0.03);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 16px;
  transition: all 0.5s cubic-bezier(0.25,0.46,0.45,0.94);
  position: relative;
  overflow: hidden;
}
.featured-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  background: radial-gradient(ellipse at 30% 20%, rgba(212,175,55,0.03), transparent 60%);
  pointer-events: none;
}
.featured-card:hover {
  transform: translateY(-8px);
  border-color: rgba(212,175,55,0.2);
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.featured-card .card-image {
  width: 100%; height: 200px;
  background: rgba(255,255,255,0.03);
  border-radius: 8px;
  margin-bottom: 1.5rem;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.featured-card .card-image svg { width: 60%; height: 60%; opacity: 0.2; }
.featured-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1rem; font-weight: 600;
  margin-bottom: 0.5rem;
}
.featured-card .card-desc {
  font-size: 0.75rem;
  color: rgba(255,255,255,0.5);
  line-height: 1.6;
}
.featured-card .card-price {
  margin-top: 1rem;
  font-size: 0.9rem; font-weight: 700;
  color: var(--aura-gold);
}

/* ─── BRAND STORY ─── */
#brand-story {
  background: radial-gradient(ellipse at 30% 20%, rgba(74,158,255,0.03), transparent 60%),
              radial-gradient(ellipse at 70% 80%, rgba(212,175,55,0.02), transparent 50%),
              var(--aura-dark);
  padding: 10rem 2rem;
}
.brand-story-inner {
  max-width: 700px; margin: 0 auto;
  text-align: center;
}
.brand-story-inner .brand-mark {
  display: inline-block;
  font-family: 'Playfair Display', serif;
  font-size: 0.7rem; letter-spacing: 0.5em; text-transform: uppercase;
  color: var(--aura-gold);
  margin-bottom: 2rem;
  padding: 0.5rem 1.5rem;
  border: 1px solid rgba(212,175,55,0.15);
  border-radius: 4px;
}
.brand-story-inner .brand-quote {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.2rem, 3vw, 2rem);
  font-weight: 400;
  line-height: 1.6;
  color: var(--aura-ivory);
  margin-bottom: 2rem;
}
.brand-story-inner .brand-author {
  font-size: 0.75rem;
  color: rgba(255,255,255,0.35);
  letter-spacing: 0.2em;
}
.brand-divider {
  width: 60px; height: 1px;
  background: linear-gradient(90deg, transparent, var(--aura-gold), transparent);
  margin: 0 auto 2rem;
}

/* ─── NEW ARRIVALS ─── */
#new {
  background: var(--aura-deeper);
}
.new-arrivals-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.5rem;
  max-width: 1200px; margin: 0 auto;
}
.arrival-card {
  padding: 1.5rem;
  background: rgba(255,255,255,0.03);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 12px;
  transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94);
  position: relative;
}
.arrival-card:hover {
  transform: translateY(-4px);
  border-color: rgba(212,175,55,0.15);
  box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}
.arrival-card .new-badge {
  position: absolute; top: 1rem; left: 1rem;
  padding: 0.2rem 0.6rem;
  background: linear-gradient(135deg, rgba(212,175,55,0.2), rgba(212,175,55,0.05));
  border: 1px solid rgba(212,175,55,0.2);
  border-radius: 4px;
  font-size: 0.5rem; letter-spacing: 0.15em; text-transform: uppercase;
  color: var(--aura-gold);
}
.arrival-card .arrival-img {
  width: 100%; height: 180px;
  background: rgba(255,255,255,0.03);
  border-radius: 8px;
  margin-bottom: 1.25rem;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.arrival-card .arrival-img svg { width: 50%; height: 50%; opacity: 0.15; }
.arrival-card h4 {
  font-family: 'Playfair Display', serif;
  font-size: 0.9rem; font-weight: 600;
  margin-bottom: 0.35rem;
}
.arrival-card .arrival-category {
  font-size: 0.6rem;
  color: rgba(255,255,255,0.3);
  letter-spacing: 0.15em; text-transform: uppercase;
  margin-bottom: 0.5rem;
}
.arrival-card .arrival-price {
  font-size: 0.9rem; font-weight: 700;
  color: var(--aura-gold);
}
.arrival-card .arrival-rating {
  font-size: 0.6rem;
  color: var(--aura-gold);
  margin-top: 0.35rem;
  letter-spacing: 2px;
}

/* ─── NEWSLETTER ─── */
#newsletter {
  background: radial-gradient(ellipse at 50% 30%, rgba(10,10,42,1), var(--aura-deeper) 60%);
  padding: 8rem 2rem;
}
.newsletter-inner {
  max-width: 520px; margin: 0 auto;
  text-align: center;
}
.newsletter-glass {
  padding: 3rem 2.5rem;
  background: rgba(255,255,255,0.03);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 20px;
}
.newsletter-glass h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  margin-bottom: 0.75rem;
}
.newsletter-glass p {
  font-size: 0.8rem;
  color: rgba(255,255,255,0.5);
  margin-bottom: 2rem;
  line-height: 1.6;
}
.newsletter-form-group {
  display: flex;
  gap: 0.5rem;
  max-width: 400px; margin: 0 auto;
}
.newsletter-form-group input {
  flex: 1;
  padding: 0.85rem 1.25rem;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 8px;
  color: #fff;
  font-family: 'Inter', sans-serif;
  font-size: 0.8rem;
  outline: none;
  transition: border-color 0.3s, box-shadow 0.3s;
}
.newsletter-form-group input:focus {
  border-color: var(--aura-gold);
  box-shadow: 0 0 20px rgba(212,175,55,0.1);
}
.newsletter-form-group input::placeholder { color: rgba(255,255,255,0.25); }
.newsletter-form-group button {
  padding: 0.85rem 1.5rem;
  background: linear-gradient(135deg, rgba(212,175,55,0.2), rgba(212,175,55,0.05));
  border: 1px solid rgba(212,175,55,0.25);
  border-radius: 8px;
  color: var(--aura-gold);
  font-family: 'Inter', sans-serif;
  font-size: 0.7rem; font-weight: 600;
  letter-spacing: 0.1em;
  cursor: pointer;
  transition: all 0.3s;
  white-space: nowrap;
}
.newsletter-form-group button:hover {
  background: rgba(212,175,55,0.25);
  box-shadow: 0 0 30px rgba(212,175,55,0.15);
}

/* ─── FOOTER OVERRIDE ─── */
footer {
  background: var(--aura-deeper) !important;
  border-top: 1px solid rgba(255,255,255,0.03);
}

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
  .aura-nav { padding: 1rem 1.5rem; }
  .aura-nav-links { display: none; }
  .floating-product-card {
    display: none;
  }
  .vortex-trigger { bottom: 20px; right: 20px; width: 50px; height: 50px; }
  .featured-card { flex: 0 0 250px; }
  .section { padding: 5rem 1.5rem; }
  .newsletter-glass { padding: 2rem 1.5rem; }
  .newsletter-form-group { flex-direction: column; }
}
@media (max-width: 1024px) and (min-width: 769px) {
  .floating-product-card { width: 200px; margin-left: 1.5rem; }
}
</style>
@endpush

@section('content')
<!-- ═══════════ HERO ═══════════ -->
<div id="hero-section">
  <canvas id="three-canvas"></canvas>
  <div class="hero-overlay"></div>

  <nav class="aura-nav">
    <a href="{{ route('home') }}" class="aura-logo">AURA</a>
    <ul class="aura-nav-links">
      <li><a href="#collection">Collection</a></li>
      <li><a href="#brand-story">Story</a></li>
      <li><a href="#new">New</a></li>
      <li><a href="#newsletter">Connect</a></li>
      <li><a href="{{ route('collection') }}" class="{{ request()->routeIs('collection') ? 'active' : '' }}">All Collections</a></li>
    </ul>
    <div class="aura-nav-icons">
      <a href="{{ route('products.search') }}" aria-label="Search"><i class="fas fa-search"></i></a>
      <a href="{{ route('wishlist') }}" aria-label="Wishlist"><i class="far fa-heart"></i></a>
      <a href="{{ route('cart') }}" aria-label="Cart"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </nav>

  <div class="hero-content">
    <div class="hero-center">
      <p class="hero-subtitle" id="heroSubtitle">The Precision of Elegance</p>
      <h1 class="hero-title" id="heroTitle">Where Fabric<br>Meets Cosmos</h1>
    </div>
    <!-- Floating Product Card -->
    <div class="floating-product-card" id="floatingCard">
      <div class="card-label">Featured</div>
      <div class="card-title">The Midnight Silk Saree</div>
      <div class="card-rating">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
      </div>
      <div class="card-price">15,000 BDT</div>
      <div class="card-badge">Premium</div>
      <div class="card-stock"><i class="fas fa-circle"></i> In Stock</div>
      <button class="btn-vortex" id="addToVortex">
        <span class="btn-content">
          <i class="fas fa-spinner"></i>
          + TO VORTEX
        </span>
      </button>
    </div>
  </div>

  <div class="hero-cursor-hint">
    <span>Move your cursor to shape reality</span>
    <div class="cursor-line"></div>
  </div>

  <!-- Black Hole Vortex Trigger -->
  <button class="vortex-trigger" id="vortexTrigger" aria-label="Open Cart">
    <div class="vortex-ring"></div>
    <div class="vortex-ring"></div>
    <div class="vortex-ring"></div>
    <div class="vortex-ring"></div>
    <div class="vortex-core"></div>
  </button>

  <!-- Mini Cart Preview -->
  <div class="mini-cart-preview" id="miniCart">
    <h4><i class="fas fa-shopping-bag me-2" style="color:var(--aura-gold);"></i>Your Vortex</h4>
    <div class="mini-cart-item">
      <div style="width:50px;height:60px;background:rgba(255,255,255,0.05);border-radius:6px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-gem" style="color:rgba(212,175,55,0.3);font-size:1.2rem;"></i>
      </div>
      <div class="item-info">
        <div class="item-name">Midnight Silk Saree</div>
        <div class="item-meta">Qty: 1</div>
        <div class="item-price">15,000 BDT</div>
      </div>
    </div>
    <div class="cart-total">
      <span>Total</span>
      <span>15,000 BDT</span>
    </div>
  </div>
  <a href="{{ route('cart') }}" class="btn-view-cart">View Full Vortex</a>
</div>

<!-- ═══════════ NEW ARRIVALS ═══════════ -->
<section id="new" class="section" style="background: var(--aura-dark);">
  <div style="max-width:1200px;margin:0 auto;">
    <p class="section-label">Latest Drops</p>
    <h2 class="section-title">New Arrivals</h2>
    <p class="section-subtitle">Fresh from the celestial loom.</p>

    <div class="new-arrivals-grid">
      @forelse($newArrivals as $product)
        @php $img = $product->images->first()->image_path ?? 'https://placehold.co/300x400?text=No+Image'; @endphp
        <div class="arrival-card">
          <span class="new-badge">New</span>
          <div class="arrival-img">
            <img src="{{ asset($img) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy" onerror="this.style.display='none';this.parentElement.innerHTML='<svg viewBox=\'0 0 200 200\'><path d=\'M50 85 Q100 40 150 85 Q170 105 150 125 Q100 170 50 125 Q30 105 50 85Z\' stroke=\'rgba(212,175,55,0.12)\'/></svg>'">
          </div>
          <div class="arrival-category">{{ $product->category?->name ?? 'General' }}</div>
          <h4>{{ $product->name }}</h4>
          <div class="arrival-price">₹{{ number_format($product->discounted_price ?? $product->price, 0) }}</div>
        </div>
      @empty
        <div class="arrival-card">
          <span class="new-badge">New</span>
          <div class="arrival-img">
            <svg viewBox="0 0 200 200"><path d="M50 85 Q100 40 150 85 Q170 105 150 125 Q100 170 50 125 Q30 105 50 85Z" stroke="rgba(212,175,55,0.12)" stroke-width="1"/></svg>
          </div>
          <div class="arrival-category">&mdash;</div>
          <h4>Coming Soon</h4>
          <div class="arrival-price">&mdash;</div>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ═══════════ BRAND STORY ═══════════ -->

<section id="brand-story">
  <div class="brand-story-inner">
    <div class="brand-mark">Since 2024</div>
    <div class="brand-divider"></div>
    <div class="brand-quote">
      "We do not simply weave fabric.<br>
      We capture the interval between stars&mdash;<br>
      where light hesitates before it becomes color."
    </div>
    <div class="brand-divider"></div>
    <div class="brand-author">&mdash; AURA ATELIER</div>
  </div>
</section>

<div id="collection">

@php
    $homeSectionConfig = [
        "Hero Collection" => ["id" => "hero-collection", "label" => "Curated Selection", "title" => "The Collection", "subtitle" => "Each piece selected at the intersection of heritage and the unseen.", "scroll" => true],
        "Featured Collection" => ["id" => "featured-collection", "label" => "Editor\'s Pick", "title" => "Featured Collection", "subtitle" => "Handpicked for those who seek the extraordinary.", "scroll" => false],
        "Premium Collection" => ["id" => "premium-collection", "label" => "Exclusive", "title" => "Premium Collection", "subtitle" => "Our finest selection for the discerning eye.", "scroll" => false],
        "Luxury Collection" => ["id" => "luxury-collection", "label" => "Luxury", "title" => "Luxury Collection", "subtitle" => "Opulence redefined, one drape at a time.", "scroll" => false],
        "Wedding Collection" => ["id" => "wedding-collection", "label" => "Bridal", "title" => "Wedding Collection", "subtitle" => "For the most beautiful chapter of your story.", "scroll" => false],
        "Festive Collection" => ["id" => "festive-collection", "label" => "Celebration", "title" => "Festive Collection", "subtitle" => "Drape in the colours of joy and tradition.", "scroll" => false],
        "Trending Collection" => ["id" => "trending-collection", "label" => "Trending Now", "title" => "Trending Collection", "subtitle" => "What everyone is talking about this season.", "scroll" => false],
        "Editor\'s Choice" => ["id" => "editors-choice", "label" => "Staff Pick", "title" => "Editor\'s Choice", "subtitle" => "Selected by our team for its exceptional beauty.", "scroll" => false],
    ];
@endphp

@foreach($sectionProducts as $sectionName => $products)
    @php
        $cfg = $homeSectionConfig[$sectionName] ?? ["id" => Str::slug($sectionName), "label" => $sectionName, "title" => $sectionName, "subtitle" => "", "scroll" => false];
    @endphp
    @if($products->isNotEmpty())
    <section id="{{ $cfg["id"] }}" class="section" style="background: {{ $loop->index % 2 === 0 ? "linear-gradient(180deg, var(--aura-deeper) 0%, var(--aura-dark) 100%)" : "var(--aura-dark)" }};">
      <div style="max-width:1200px;margin:0 auto;">
        <p class="section-label">{{ $cfg["label"] }}</p>
        <h2 class="section-title">{{ $cfg["title"] }}</h2>
        @if($cfg["subtitle"])
            <p class="section-subtitle">{{ $cfg["subtitle"] }}</p>
        @endif

        @if($cfg["scroll"])
        <div class="featured-scroll" id="scroll-{{ $cfg["id"] }}">
        @else
        <div class="new-arrivals-grid">
        @endif
          @foreach($products as $product)
            @php $img = $product->image_url ?? "https://placehold.co/300x400?text=No+Image"; @endphp
            @if($cfg["scroll"])
            <div class="featured-card">
              <div class="card-image">
                <img src="{{ asset($img) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy" onerror="this.style.display='none';this.parentElement.innerHTML='<svg viewBox=\'0 0 200 200\' fill=\'none\'><path d=\'M40 80 Q100 30 200 80 Q200 100 200 120 Q100 170 40 120 Q20 100 40 80Z\' stroke=\'rgba(212,175,55,0.15)\' stroke-width=\'1\'/></svg>'"
              </div>
              <h3>{{ $product->name }}</h3>
              <p class="card-desc">{{ $product->short_description ?: Str::limit($product->description, 80) }}</p>
              <p class="card-price">₹{{ number_format($product->discounted_price, 0) }}</p>
            </div>
            @else
            <div class="arrival-card">
              <div class="arrival-img">
                <img src="{{ asset($img) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy" onerror="this.style.display='none';this.parentElement.innerHTML='<svg viewBox=\'0 0 200 200\'><path d=\'M50 85 Q100 40 150 85 Q170 105 150 125 Q100 170 50 125 Q30 105 50 85Z\' stroke=\'rgba(212,175,55,0.12)\'/></svg>'">
              </div>
              <p class="arrival-category">{{ $product->category?->name ?? "General" }}</p>
              <h4>{{ $product->name }}</h4>
              <p class="arrival-price">₹{{ number_format($product->discounted_price, 0) }}</p>
            </div>
            @endif
          @endforeach
        </div>
      </div>
    </section>
    @endif
@endforeach
</div>
<!-- ═══════════ NEWSLETTER ═══════════ -->
<section id="newsletter">
  <div class="newsletter-inner">
    <div class="newsletter-glass">
      <h3 class="section-title" style="margin-bottom:0.75rem;">Join the AURA Experience</h3>
      <p>Be the first to witness new collections, receive celestial invitations, and unlock the unseen.</p>
      <form class="newsletter-form-group" id="newsletterForm">
        <input type="email" placeholder="Enter your email" required>
        <button type="submit">Subscribe</button>
      </form>
      <p style="font-size:0.6rem;color:rgba(255,255,255,0.2);margin-top:1.5rem;letter-spacing:0.1em;">
        No constellations harvested. Unsubscribe in a photon's blink.
      </p>
    </div>
  </div>
</section>

@include('partials.footer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  /* ─── THREE.JS SCENE ─── */
  (function initThree() {
    const canvas = document.getElementById('three-canvas');
    if (!canvas) return;

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 1, 8);
    camera.lookAt(0, 0, 0);

    const renderer = new THREE.WebGLRenderer({
      canvas,
      alpha: true,
      antialias: true,
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.2;

    /* Lights */
    const ambient = new THREE.AmbientLight(0x222244, 0.5);
    scene.add(ambient);

    const goldLight = new THREE.PointLight(0xd4af37, 2, 20);
    goldLight.position.set(3, 2, 4);
    scene.add(goldLight);

    const blueLight = new THREE.PointLight(0x4a9eff, 1.5, 20);
    blueLight.position.set(-3, -1, 3);
    scene.add(blueLight);

    const rimLight = new THREE.DirectionalLight(0x4a9eff, 0.8);
    rimLight.position.set(-2, 3, 2);
    scene.add(rimLight);

    /* Central Saree Geometry — Torus Knot with draped feel */
    const knotGeo = new THREE.TorusKnotGeometry(1.2, 0.35, 180, 24);
    const knotMat = new THREE.MeshPhysicalMaterial({
      color: 0x1a0a2e,
      metalness: 0.7,
      roughness: 0.2,
      clearcoat: 0.8,
      clearcoatRoughness: 0.3,
      emissive: 0x1a0a2e,
      emissiveIntensity: 0.15,
      side: THREE.DoubleSide,
      transparent: true,
      opacity: 0.95,
    });
    const knot = new THREE.Mesh(knotGeo, knotMat);
    knot.position.y = 0.2;
    scene.add(knot);

    /* Inner glow wireframe */
    const wireGeo = new THREE.TorusKnotGeometry(1.25, 0.38, 120, 16);
    const wireMat = new THREE.MeshBasicMaterial({
      color: 0xd4af37,
      wireframe: true,
      transparent: true,
      opacity: 0.08,
    });
    const wire = new THREE.Mesh(wireGeo, wireMat);
    wire.position.y = 0.2;
    scene.add(wire);

    /* Energy Ring 1 — horizontal */
    const ring1Geo = new THREE.TorusGeometry(1.9, 0.015, 32, 100);
    const ring1Mat = new THREE.MeshBasicMaterial({
      color: 0xd4af37,
      transparent: true,
      opacity: 0.25,
    });
    const ring1 = new THREE.Mesh(ring1Geo, ring1Mat);
    ring1.rotation.x = Math.PI / 2.2;
    ring1.position.y = 0.1;
    scene.add(ring1);

    /* Energy Ring 2 — tilted */
    const ring2Geo = new THREE.TorusGeometry(2.1, 0.012, 32, 100);
    const ring2Mat = new THREE.MeshBasicMaterial({
      color: 0x4a9eff,
      transparent: true,
      opacity: 0.2,
    });
    const ring2 = new THREE.Mesh(ring2Geo, ring2Mat);
    ring2.rotation.x = Math.PI / 1.8;
    ring2.rotation.z = 0.5;
    ring2.position.y = 0.1;
    scene.add(ring2);

    /* Energy Ring 3 — small fast */
    const ring3Geo = new THREE.TorusGeometry(1.6, 0.008, 24, 80);
    const ring3Mat = new THREE.MeshBasicMaterial({
      color: 0xf0e6d3,
      transparent: true,
      opacity: 0.15,
    });
    const ring3 = new THREE.Mesh(ring3Geo, ring3Mat);
    ring3.rotation.x = Math.PI / 1.5;
    ring3.rotation.z = -0.3;
    ring3.position.y = 0.1;
    scene.add(ring3);

    /* Stars Particle System */
    const starCount = 3000;
    const positions = new Float32Array(starCount * 3);
    const colors = new Float32Array(starCount * 3);
    const sizes = new Float32Array(starCount);

    for (let i = 0; i < starCount; i++) {
      const r = 15 + Math.random() * 35;
      const theta = Math.random() * Math.PI * 2;
      const phi = Math.acos(2 * Math.random() - 1);

      positions[i*3] = r * Math.sin(phi) * Math.cos(theta);
      positions[i*3+1] = r * Math.cos(phi);
      positions[i*3+2] = r * Math.sin(phi) * Math.sin(theta);

      const colorVal = 0.6 + Math.random() * 0.4;
      if (Math.random() > 0.85) {
        colors[i*3] = 1; colors[i*3+1] = 0.85; colors[i*3+2] = 0.5;
      } else if (Math.random() > 0.85) {
        colors[i*3] = 0.4; colors[i*3+1] = 0.6; colors[i*3+2] = 1;
      } else {
        colors[i*3] = colorVal; colors[i*3+1] = colorVal; colors[i*3+2] = colorVal;
      }

      sizes[i] = 0.5 + Math.random() * 2;
    }

    const starGeo = new THREE.BufferGeometry();
    starGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    starGeo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    starGeo.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

    const starTexture = (() => {
      const c = document.createElement('canvas');
      c.width = 32; c.height = 32;
      const ctx = c.getContext('2d');
      const grad = ctx.createRadialGradient(16, 16, 0, 16, 16, 16);
      grad.addColorStop(0, 'rgba(255,255,255,1)');
      grad.addColorStop(0.3, 'rgba(255,255,255,0.8)');
      grad.addColorStop(1, 'rgba(255,255,255,0)');
      ctx.fillStyle = grad;
      ctx.fillRect(0, 0, 32, 32);
      return new THREE.CanvasTexture(c);
    })();

    const starMat = new THREE.PointsMaterial({
      size: 0.12,
      map: starTexture,
      blending: THREE.AdditiveBlending,
      depthWrite: false,
      transparent: true,
      vertexColors: true,
      opacity: 0.9,
    });
    const stars = new THREE.Points(starGeo, starMat);
    scene.add(stars);

    /* Ambience Particles (close floating) */
    const dustCount = 800;
    const dustPos = new Float32Array(dustCount * 3);
    for (let i = 0; i < dustCount; i++) {
      dustPos[i*3] = (Math.random() - 0.5) * 12;
      dustPos[i*3+1] = (Math.random() - 0.5) * 8;
      dustPos[i*3+2] = (Math.random() - 0.5) * 6 - 3;
    }
    const dustGeo = new THREE.BufferGeometry();
    dustGeo.setAttribute('position', new THREE.BufferAttribute(dustPos, 3));
    const dustMat = new THREE.PointsMaterial({
      size: 0.015,
      color: 0xd4af37,
      transparent: true,
      opacity: 0.3,
      blending: THREE.AdditiveBlending,
      depthWrite: false,
    });
    const dust = new THREE.Points(dustGeo, dustMat);
    scene.add(dust);

    /* Mouse tracking */
    let mouseX = 0, mouseY = 0;
    let targetRotX = 0, targetRotY = 0;

    document.addEventListener('mousemove', (e) => {
      mouseX = (e.clientX / window.innerWidth) * 2 - 1;
      mouseY = -(e.clientY / window.innerHeight) * 2 + 1;
    });

    /* Resize */
    const handleResize = () => {
      const w = window.innerWidth;
      const h = window.innerHeight;
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
      renderer.setSize(w, h);
    };
    window.addEventListener('resize', handleResize);

    /* Animation loop */
    let clock = new THREE.Clock();

    function animate() {
      requestAnimationFrame(animate);

      const t = clock.getElapsedTime();
      const dt = clock.getDelta();

      /* Smooth mouse follow */
      targetRotX += (mouseX * 0.5 - targetRotX) * 0.05;
      targetRotY += (mouseY * 0.3 - targetRotY) * 0.05;

      /* Rotate central objects */
      knot.rotation.x += 0.002 + targetRotY * 0.001;
      knot.rotation.y += 0.005 + targetRotX * 0.002;
      knot.rotation.z += 0.001;

      wire.rotation.x = knot.rotation.x;
      wire.rotation.y = knot.rotation.y;
      wire.rotation.z = knot.rotation.z;

      /* Rings rotate independently */
      ring1.rotation.z += 0.004;
      ring2.rotation.y += 0.006;
      ring2.rotation.x += 0.002;
      ring3.rotation.z -= 0.008;
      ring3.rotation.y += 0.005;

      /* Stars slow rotation */
      stars.rotation.y += 0.0002;
      stars.rotation.x += 0.0001;

      /* Dust float */
      const dustPosAttr = dust.geometry.attributes.position;
      const dustArray = dustPosAttr.array;
      for (let i = 0; i < dustCount; i++) {
        dustArray[i*3+1] += Math.sin(t + i) * 0.0001;
        dustArray[i*3] += Math.cos(t * 0.5 + i * 0.1) * 0.0001;
      }
      dustPosAttr.needsUpdate = true;

      /* Camera position follow */
      camera.position.x += (-targetRotX * 1.5 - camera.position.x) * 0.02;
      camera.position.y += (targetRotY * 1.2 + 1 - camera.position.y) * 0.02;
      camera.lookAt(0, 0.2, 0);

      /* Light animation */
      goldLight.position.x = 3 + Math.sin(t * 0.3) * 1.5;
      goldLight.position.z = 4 + Math.cos(t * 0.4) * 1.5;
      blueLight.position.x = -3 + Math.sin(t * 0.5 + 2) * 2;
      blueLight.position.z = 3 + Math.cos(t * 0.3 + 1) * 2;

      /* Pulse wireframe opacity */
      wireMat.opacity = 0.06 + Math.sin(t * 0.5) * 0.03;

      renderer.render(scene, camera);
    }

    animate();
  })();


  /* ─── GSAP ANIMATIONS ─── */
  /* Hero text entrance */
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('.hero-subtitle', { opacity: 1, y: 0, duration: 1.2, delay: 0.5 })
    .to('.hero-title', { opacity: 1, y: 0, duration: 1.5 }, '-=0.6')
    .to('.hero-cursor-hint', { opacity: 1, duration: 1 }, '-=0.4')
    .to('.floating-product-card', { opacity: 1, x: 0, duration: 1, ease: 'power2.out' }, '-=0.8');

  /* Floating card entrance from right */
  gsap.from('.floating-product-card', {
    x: 60, opacity: 0, duration: 1.2, delay: 1.8, ease: 'power3.out',
  });

  /* Vortex trigger entrance */
  gsap.from('.vortex-trigger', {
    scale: 0, opacity: 0, duration: 1, delay: 2.2, ease: 'back.out(1.7)',
  });

  /* Section reveal triggers */
  gsap.registerPlugin(ScrollTrigger);

  const sectionReveal = (selector) => {
    const el = document.querySelector(selector);
    if (!el) return;
    gsap.from(el.querySelector('.section-title'), {
      y: 60, opacity: 0, duration: 1,
      scrollTrigger: { trigger: el, start: 'top 80%', toggleActions: 'play none none none' },
      ease: 'power3.out',
    });
    gsap.from(el.querySelector('.section-subtitle'), {
      y: 40, opacity: 0, duration: 1, delay: 0.2,
      scrollTrigger: { trigger: el, start: 'top 80%', toggleActions: 'play none none none' },
      ease: 'power3.out',
    });
  };
  sectionReveal('#collection');

  /* Collection cards stagger */
  gsap.from('.featured-card', {
    y: 60, opacity: 0, duration: 0.8, stagger: 0.15,
    scrollTrigger: { trigger: '#collection', start: 'top 75%', toggleActions: 'play none none none' },
    ease: 'power3.out',
  });

  /* Brand Story reveal */
  gsap.from('.brand-story-inner', {
    y: 80, opacity: 0, duration: 1.2,
    scrollTrigger: { trigger: '#brand-story', start: 'top 75%', toggleActions: 'play none none none' },
    ease: 'power3.out',
  });

  /* New Arrivals stagger */
  gsap.from('.arrival-card', {
    y: 50, opacity: 0, duration: 0.7, stagger: 0.12,
    scrollTrigger: { trigger: '#new', start: 'top 75%', toggleActions: 'play none none none' },
    ease: 'power3.out',
  });

  /* Newsletter reveal */
  gsap.from('.newsletter-glass', {
    y: 60, opacity: 0, duration: 1.2,
    scrollTrigger: { trigger: '#newsletter', start: 'top 80%', toggleActions: 'play none none none' },
    ease: 'power3.out',
  });


  /* ─── HORIZONTAL SCROLL (Featured) ─── */
  const scrollEl = document.getElementById('featuredScroll');
  if (scrollEl) {
    let isDown = false;
    let startX, scrollLeft;

    scrollEl.addEventListener('mousedown', (e) => {
      isDown = true;
      startX = e.pageX - scrollEl.offsetLeft;
      scrollLeft = scrollEl.scrollLeft;
    });
    scrollEl.addEventListener('mouseleave', () => { isDown = false; });
    scrollEl.addEventListener('mouseup', () => { isDown = false; });
    scrollEl.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - scrollEl.offsetLeft;
      const walk = (x - startX) * 1.5;
      scrollEl.scrollLeft = scrollLeft - walk;
    });

    /* Touch support */
    let touchStartX, touchScrollLeft;
    scrollEl.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].pageX - scrollEl.offsetLeft;
      touchScrollLeft = scrollEl.scrollLeft;
    }, { passive: true });
    scrollEl.addEventListener('touchmove', (e) => {
      const x = e.touches[0].pageX - scrollEl.offsetLeft;
      const walk = (x - touchStartX) * 1.5;
      scrollEl.scrollLeft = touchScrollLeft - walk;
    }, { passive: true });
  }


  /* ─── VORTEX TRIGGER / MINI CART ─── */
  const vortexBtn = document.getElementById('vortexTrigger');
  const miniCart = document.getElementById('miniCart');
  if (vortexBtn && miniCart) {
    vortexBtn.addEventListener('click', () => {
      miniCart.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
      if (!vortexBtn.contains(e.target) && !miniCart.contains(e.target)) {
        miniCart.classList.remove('active');
      }
    });
  }


  /* ─── "TO VORTEX" BUTTON RIPPLE ─── */
  const vortexAddBtn = document.getElementById('addToVortex');
  if (vortexAddBtn) {
    vortexAddBtn.addEventListener('click', function() {
      const btn = this;
      btn.querySelector('.btn-content').innerHTML = '<i class="fas fa-check"></i> ADDED';

      /* Ripple effect */
      const ripple = document.createElement('span');
      ripple.style.cssText = `
        position:absolute; border-radius:50%; background:rgba(212,175,55,0.3);
        width:10px; height:10px; pointer-events:none;
        animation: rippleOut 0.6s ease-out forwards;
      `;
      btn.style.position = 'relative';
      btn.appendChild(ripple);
      setTimeout(() => ripple.remove(), 700);

      /* Reset after delay */
      setTimeout(() => {
        btn.querySelector('.btn-content').innerHTML = '<i class="fas fa-spinner"></i> + TO VORTEX';
      }, 2000);
    });
  }


  /* ─── NEWSLETTER ─── */
  const nlForm = document.getElementById('newsletterForm');
  if (nlForm) {
    nlForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const btn = nlForm.querySelector('button');
      const orig = btn.textContent;
      btn.textContent = 'Subscribed';
      btn.style.color = '#4ade80';
      setTimeout(() => {
        btn.textContent = orig;
        btn.style.color = '';
        nlForm.querySelector('input').value = '';
      }, 3000);
    });
  }


  /* ─── MAGNETIC BUTTON EFFECT ─── */
  const magneticBtns = document.querySelectorAll('.btn-vortex');
  magneticBtns.forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
    });
    btn.addEventListener('mouseleave', () => {
      btn.style.transform = '';
    });
  });

});
</script>
@endpush
