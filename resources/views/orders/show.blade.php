@extends('layouts.app')
@section('title', 'Detail Pesanan ' . $order->nomor_invoice . ' — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ url('/orders') }}" class="hover:text-[#FA5400]">Pesanan Saya</a>
        <span>/</span>
        <span class="text-[#111] font-medium">{{ $order->nomor_invoice }}</span>
    </nav>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Order Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Status Header --}}
            <div class="bg-gray-50 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-xl font-black">{{ $order->nomor_invoice }}</h1>
                    @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'selesai' => 'bg-green-100 text-green-700',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                    ];
                    @endphp
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full uppercase {{ $statusColors[$order->status] ?? 'bg-gray-100' }}">
                        {{ $order->status }}
                    </span>
                </div>
                <div class="grid sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                        <p class="font-semibold">{{ $order->tanggal_transaksi->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Pembayaran</p>
                        <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->metode_pembayaran)) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total</p>
                        <p class="font-black text-[#FA5400]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Item Pesanan</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex gap-4 items-center bg-white rounded-xl p-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($item->barang && $item->barang->gambar)
                                <img src="{{ asset('storage/' . $item->barang->gambar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm">{{ $item->barang->nama ?? 'Produk dihapus' }}</p>
                            <p class="text-xs text-gray-400">{{ $item->jumlah }}x @ Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-bold text-sm shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Notes --}}
            @if($order->catatan)
            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-2">Catatan</h3>
                <p class="text-sm text-gray-600">{{ $order->catatan }}</p>
            </div>
            @endif
        </div>

        {{-- Summary Sidebar --}}
        <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-2xl p-6 sticky top-24">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ongkir</span>
                        <span class="font-semibold text-green-600">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="font-bold">Total</span>
                        <span class="font-black text-lg text-[#FA5400]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ url('/orders') }}" class="w-full bg-[#111] text-white py-3 rounded-xl text-sm font-bold hover:bg-[#FA5400] transition-all mt-6 flex items-center justify-center gap-2">
                    ← Kembali ke Pesanan
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
