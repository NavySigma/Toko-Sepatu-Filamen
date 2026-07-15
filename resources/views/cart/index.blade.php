@extends('layouts.app')
@section('title', 'Keranjang — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-black uppercase tracking-tight mb-8">Keranjang Belanja</h1>

    @if(count($items) > 0)
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Cart Items --}}
        <div class="lg:col-span-2 space-y-4">
            @foreach($items as $item)
            <div class="bg-gray-50 rounded-2xl p-4 sm:p-6 flex gap-4 sm:gap-6" id="cart-item-{{ $item['barang']->id }}">
                {{-- Image --}}
                <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gray-200 rounded-xl overflow-hidden shrink-0">
                    @if($item['barang']->gambar)
                        <img src="{{ asset('storage/' . $item['barang']->gambar) }}" alt="{{ $item['barang']->nama }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase">{{ $item['barang']->merk }}</p>
                            <h3 class="font-semibold text-sm sm:text-base">{{ $item['barang']->nama }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $item['barang']->warna }} • Size {{ $item['barang']->ukuran }}</p>
                        </div>
                        <form method="POST" action="{{ url('/cart/remove') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="barang_id" value="{{ $item['barang']->id }}">
                            <button type="submit" class="p-1.5 hover:bg-red-50 rounded-lg text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>

                    <div class="flex items-end justify-between mt-4">
                        <form method="POST" action="{{ url('/cart/update') }}" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="barang_id" value="{{ $item['barang']->id }}">
                            <div class="flex items-center border-2 border-gray-200 rounded-full overflow-hidden bg-white">
                                <button type="submit" name="qty" value="{{ max(1, $item['qty'] - 1) }}" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 text-sm font-bold">−</button>
                                <span class="w-8 text-center text-sm font-bold">{{ $item['qty'] }}</span>
                                <button type="submit" name="qty" value="{{ min($item['barang']->stok, $item['qty'] + 1) }}" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 text-sm font-bold">+</button>
                            </div>
                        </form>
                        <p class="font-bold text-sm sm:text-base">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-2xl p-6 sticky top-24">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-6">Ringkasan Pesanan</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal ({{ array_sum(array_column($items, 'qty')) }} item)</span>
                        <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ongkir</span>
                        <span class="font-semibold text-green-600">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="font-bold">Total</span>
                        <span class="font-black text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ url('/checkout') }}" class="w-full bg-[#111] text-white py-4 rounded-xl text-sm font-bold hover:bg-[#FA5400] transition-all duration-300 flex items-center justify-center gap-2 mt-6" id="checkout-btn">
                    Checkout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>

                <a href="{{ url('/products') }}" class="block text-center text-sm text-gray-500 hover:text-[#FA5400] mt-4 transition-colors">
                    ← Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-20">
        <svg class="w-24 h-24 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <h2 class="text-xl font-bold mb-2">Keranjang Kosong</h2>
        <p class="text-gray-500 text-sm mb-6">Belum ada item di keranjang belanja</p>
        <a href="{{ url('/products') }}" class="inline-flex items-center gap-2 bg-[#111] text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-[#FA5400] transition-all">
            Mulai Belanja
        </a>
    </div>
    @endif
</section>
@endsection
