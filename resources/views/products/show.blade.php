@extends('layouts.app')
@section('title', $product->nama . ' — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ url('/') }}" class="hover:text-[#FA5400]">Home</a>
        <span>/</span>
        <a href="{{ url('/products') }}" class="hover:text-[#FA5400]">Katalog</a>
        <span>/</span>
        <span class="text-[#111] font-medium">{{ $product->nama }}</span>
    </nav>

    <div class="grid lg:grid-cols-2 gap-12">
        {{-- Product Image --}}
        <div class="bg-gray-50 rounded-3xl overflow-hidden aspect-square relative">
            @if($product->gambar)
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                    class="w-full h-full object-cover" id="product-main-image">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            @endif
            @if($product->stok <= 3 && $product->stok > 0)
                <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Sisa {{ $product->stok }}</span>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="space-y-6">
            <div>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider mb-1">{{ $product->merk }}</p>
                <h1 class="text-3xl lg:text-4xl font-black tracking-tight" id="product-name">{{ $product->nama }}</h1>
            </div>

            <p class="text-3xl font-black text-[#FA5400]" id="product-price">
                Rp {{ number_format($product->harga, 0, ',', '.') }}
            </p>

            {{-- Details --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Kategori</p>
                    <p class="font-semibold text-sm">{{ $product->kategori }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Ukuran</p>
                    <p class="font-semibold text-sm">{{ $product->ukuran }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Warna</p>
                    <p class="font-semibold text-sm">{{ $product->warna }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Stok</p>
                    <p class="font-semibold text-sm {{ $product->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $product->stok > 0 ? $product->stok . ' tersedia' : 'Habis' }}
                    </p>
                </div>
            </div>

            {{-- Description --}}
            @if($product->deskripsi)
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider mb-2">Deskripsi</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $product->deskripsi }}</p>
            </div>
            @endif

            {{-- Add to Cart --}}
            @auth
                @if($product->stok > 0)
                <form method="POST" action="{{ url('/cart/add') }}" class="space-y-4" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="barang_id" value="{{ $product->id }}">
                    <div class="flex items-center gap-4">
                        <label class="text-sm font-semibold">Jumlah:</label>
                        <div class="flex items-center border-2 border-gray-200 rounded-full overflow-hidden">
                            <button type="button" onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 text-lg font-bold">−</button>
                            <input type="number" name="qty" id="qty-input" value="1" min="1" max="{{ $product->stok }}"
                                class="w-14 text-center border-none focus:ring-0 text-sm font-bold">
                            <button type="button" onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 text-lg font-bold">+</button>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#111] text-white py-4 rounded-full text-sm font-bold hover:bg-[#FA5400] transition-all duration-300 flex items-center justify-center gap-2" id="add-to-cart-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Tambah ke Keranjang
                    </button>
                </form>
                @else
                <button disabled class="w-full bg-gray-300 text-gray-500 py-4 rounded-full text-sm font-bold cursor-not-allowed">
                    Stok Habis
                </button>
                @endif
            @else
                <a href="{{ url('/login') }}" class="w-full bg-[#111] text-white py-4 rounded-full text-sm font-bold hover:bg-[#FA5400] transition-all duration-300 flex items-center justify-center gap-2">
                    Masuk untuk Membeli
                </a>
            @endauth
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
    <div class="mt-20">
        <h2 class="text-2xl font-black uppercase tracking-tight mb-8">Produk Serupa</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            @include('components.product-card', ['product' => $related])
            @endforeach
        </div>
    </div>
    @endif
</section>

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty-input');
    let val = parseInt(input.value) + delta;
    val = Math.max(1, Math.min(val, parseInt(input.max)));
    input.value = val;
}
</script>
@endpush
@endsection
