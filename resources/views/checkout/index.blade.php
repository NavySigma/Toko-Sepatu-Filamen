@extends('layouts.app')
@section('title', 'Checkout — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-black uppercase tracking-tight mb-8">Checkout</h1>

    <form method="POST" action="{{ url('/checkout') }}" id="checkout-form">
        @csrf
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Checkout Form --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Customer Info --}}
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Informasi Pemesan</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Nama</p>
                            <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Email</p>
                            <p class="font-semibold text-sm">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Metode Pembayaran</h3>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @php
                        $methods = [
                            'transfer' => ['Transfer Bank', '🏦'],
                            'qris' => ['QRIS', '📱'],
                            'kartu_debit' => ['Kartu Debit', '💳'],
                            'kartu_kredit' => ['Kartu Kredit', '💎'],
                            'tunai' => ['Tunai / COD', '💵'],
                        ];
                        @endphp
                        @foreach($methods as $value => $info)
                        <label class="flex items-center gap-3 p-4 bg-white rounded-xl cursor-pointer border-2 border-transparent has-[:checked]:border-[#FA5400] hover:border-gray-200 transition-all">
                            <input type="radio" name="metode_pembayaran" value="{{ $value }}" {{ $loop->first ? 'checked' : '' }}
                                class="w-4 h-4 text-[#FA5400] focus:ring-[#FA5400]">
                            <span class="text-lg">{{ $info[1] }}</span>
                            <span class="text-sm font-semibold">{{ $info[0] }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('metode_pembayaran')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Catatan (Opsional)</h3>
                    <textarea name="catatan" rows="3" class="w-full px-4 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] transition-all resize-none" placeholder="Tulis catatan untuk pesanan...">{{ old('catatan') }}</textarea>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-gray-50 rounded-2xl p-6 sticky top-24">
                    <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Pesanan Anda</h3>

                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($items as $item)
                        <div class="flex gap-3 items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                                @if($item['barang']->gambar)
                                    <img src="{{ asset('storage/' . $item['barang']->gambar) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold truncate">{{ $item['barang']->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $item['qty'] }}x Rp {{ number_format($item['barang']->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-xs font-bold shrink-0">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 mt-4 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ongkir</span>
                            <span class="font-semibold text-green-600">Gratis</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2 flex justify-between">
                            <span class="font-bold">Total</span>
                            <span class="font-black text-lg text-[#FA5400]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#FA5400] text-white py-4 rounded-xl text-sm font-bold hover:bg-[#111] transition-all duration-300 mt-6" id="place-order-btn">
                        Buat Pesanan
                    </button>

                    <a href="{{ url('/cart') }}" class="block text-center text-sm text-gray-500 hover:text-[#FA5400] mt-3">← Kembali ke Keranjang</a>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
