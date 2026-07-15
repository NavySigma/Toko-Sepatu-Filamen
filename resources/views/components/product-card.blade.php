@php
    $isPriority = $isPriority ?? false;
@endphp
<a href="{{ url('/products/' . $product->id) }}" class="group block" id="product-card-{{ $product->id }}">
    <div class="bg-gray-50 rounded-2xl overflow-hidden aspect-square mb-4 relative">
        @if($product->gambar)
            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                @if($isPriority) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                decoding="async"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1">
            @if($product->stok <= 3 && $product->stok > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full">Sisa {{ $product->stok }}</span>
            @endif
            @if($product->created_at->diffInDays(now()) <= 7)
                <span class="bg-[#FA5400] text-white text-[10px] font-bold px-2 py-1 rounded-full">NEW</span>
            @endif
        </div>

        {{-- Quick add overlay --}}
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100">
            <span class="bg-white text-[#111] text-xs font-bold px-6 py-2.5 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                Lihat Detail
            </span>
        </div>
    </div>

    <div class="space-y-1 px-1">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">{{ $product->merk }}</p>
        <h3 class="font-semibold text-sm group-hover:text-[#FA5400] transition-colors line-clamp-1">{{ $product->nama }}</h3>
        <div class="flex items-center gap-2">
            <p class="font-bold text-sm">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <span>{{ $product->warna }}</span>
            <span>•</span>
            <span>Size {{ $product->ukuran }}</span>
        </div>
    </div>
</a>
