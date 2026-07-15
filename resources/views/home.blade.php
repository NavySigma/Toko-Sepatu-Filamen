@extends('layouts.app')
@section('title', 'Fenrir — Premium Footwear')

@section('content')
{{-- ═══ HERO SECTION ══════════════════════════════════════════════ --}}
<section class="relative bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 bg-[#FA5400]/10 text-[#FA5400] text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider">
                    <span class="w-2 h-2 bg-[#FA5400] rounded-full animate-pulse"></span>
                    New Collection 2026
                </div>
                <h1 class="text-5xl lg:text-7xl font-black leading-[0.9] tracking-tight">
                    STEP INTO<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FA5400] to-[#FF8A50]">GREATNESS</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-md leading-relaxed">
                    Temukan koleksi sepatu premium yang dirancang untuk performa dan gaya. Kualitas tanpa kompromi.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ url('/products') }}" class="inline-flex items-center gap-2 bg-[#111] text-white px-8 py-4 rounded-full text-sm font-bold hover:bg-[#FA5400] transition-all duration-300 group" id="hero-cta">
                        Jelajahi Koleksi
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @guest
                    <a href="{{ url('/register') }}" class="inline-flex items-center gap-2 border-2 border-[#111] text-[#111] px-8 py-4 rounded-full text-sm font-bold hover:bg-[#111] hover:text-white transition-all duration-300" id="hero-register">
                        Jadi Member
                    </a>
                    @endguest
                </div>
                <div class="flex items-center gap-8 pt-4">
                    <div>
                        <p class="text-3xl font-black">500+</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Produk</p>
                    </div>
                    <div class="w-px h-10 bg-gray-300"></div>
                    <div>
                        <p class="text-3xl font-black">50+</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Brand</p>
                    </div>
                    <div class="w-px h-10 bg-gray-300"></div>
                    <div>
                        <p class="text-3xl font-black">10K+</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Member</p>
                    </div>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="w-[500px] h-[500px] bg-gradient-to-br from-[#FA5400]/20 to-[#FF8A50]/10 rounded-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
                <div class="relative z-10 flex items-center justify-center">
                    <img src="{{ asset('storage/products/hero_shoe.png') }}" alt="Fenrir Hero" class="w-full max-w-[600px] object-contain mix-blend-multiply hover:-translate-y-4 hover:scale-105 transition-all duration-700 ease-out" style="transform: rotate(-10deg); -webkit-mask-image: radial-gradient(ellipse, black 50%, transparent 72%); mask-image: radial-gradient(ellipse, black 50%, transparent 72%);">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ CATEGORIES ════════════════════════════════════════════════ --}}
@if($categories->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-black uppercase tracking-tight">Kategori</h2>
        <a href="{{ url('/products') }}" class="text-sm font-semibold text-[#FA5400] hover:underline">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($categories as $cat)
        @php
            $catImages = [
                'Sneakers' => 'sneaker_white.png',
                'Running' => 'running_lime.png',
                'Casual' => 'suede_sneaker.png',
                'Boots' => 'chelsea_boot.png',
                'Formal' => 'oxford_formal.png',
                'Sandal' => 'slide_sandal.png',
            ];
            $catImg = $catImages[$cat] ?? 'sneaker_black.png';
        @endphp
        <a href="{{ url('/products?kategori=' . urlencode($cat)) }}" class="group bg-gray-50 hover:bg-white hover:shadow-xl hover:shadow-[#FA5400]/10 hover:border-[#FA5400]/30 border-2 border-transparent rounded-2xl p-6 text-center transition-all duration-300">
            <div class="w-24 h-24 mx-auto mb-4 flex items-center justify-center rounded-full overflow-hidden shadow-sm border border-gray-200">
                <img src="{{ asset('storage/products/' . $catImg) }}" alt="{{ $cat }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>
            <p class="text-sm font-semibold text-gray-700 group-hover:text-[#FA5400] transition-colors">{{ $cat }}</p>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ═══ FEATURED PRODUCTS ═════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black uppercase tracking-tight">Produk Terbaru</h2>
            <p class="text-sm text-gray-500 mt-1">Koleksi terbaru yang baru saja tiba</p>
        </div>
        <a href="{{ url('/products') }}" class="text-sm font-semibold text-[#FA5400] hover:underline hidden sm:block">Lihat Semua →</a>
    </div>
    @if($featuredProducts->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
        @include('components.product-card', ['product' => $product])
        @endforeach
    </div>
    @else
    <div class="text-center py-20 bg-gray-50 rounded-3xl">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="text-gray-500 font-medium">Belum ada produk tersedia</p>
    </div>
    @endif
    <div class="text-center mt-8 sm:hidden">
        <a href="{{ url('/products') }}" class="text-sm font-semibold text-[#FA5400] hover:underline">Lihat Semua Produk →</a>
    </div>
</section>

{{-- ═══ CTA BANNER ════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-[#111] rounded-3xl p-12 lg:p-16 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#FA5400]/20 to-transparent"></div>
        <div class="relative z-10">
            <h2 class="text-3xl lg:text-5xl font-black text-white mb-4 tracking-tight">JADI BAGIAN DARI<br><span class="text-[#FA5400] italic" style="font-family: 'Playfair Display', serif;">Fenrir Pack</span></h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">Daftar sekarang dan dapatkan akses eksklusif ke koleksi terbaru dan penawaran khusus member.</p>
            @guest
            <a href="{{ url('/register') }}" class="inline-flex items-center gap-2 bg-[#FA5400] text-white px-8 py-4 rounded-full text-sm font-bold hover:bg-[#FF8A50] transition-all duration-300">
                Daftar Sekarang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @else
            <a href="{{ url('/products') }}" class="inline-flex items-center gap-2 bg-[#FA5400] text-white px-8 py-4 rounded-full text-sm font-bold hover:bg-[#FF8A50] transition-all duration-300">
                Belanja Sekarang
            </a>
            @endguest
        </div>
    </div>
</section>
@endsection
