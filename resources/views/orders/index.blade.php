@extends('layouts.app')
@section('title', 'Pesanan Saya — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-black uppercase tracking-tight">Pesanan Saya</h1>
        <a href="{{ url('/products') }}" class="text-sm font-semibold text-[#FA5400] hover:underline">Belanja Lagi →</a>
    </div>

    @if($orders->count() > 0)
    <div class="space-y-4">
        @foreach($orders as $order)
        <a href="{{ url('/orders/' . $order->id) }}" class="block bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 transition-colors group" id="order-{{ $order->id }}">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h3 class="font-bold text-sm">{{ $order->nomor_invoice }}</h3>
                        @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'dibatalkan' => 'bg-red-100 text-red-700',
                        ];
                        @endphp
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $order->status }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $order->tanggal_transaksi->format('d M Y, H:i') }}</p>
                    <p class="text-xs text-gray-400">{{ $order->items->count() }} item • {{ ucfirst(str_replace('_', ' ', $order->metode_pembayaran)) }}</p>
                </div>
                <div class="text-right">
                    <p class="font-black text-lg">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    <span class="text-xs text-[#FA5400] font-semibold group-hover:underline">Lihat Detail →</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @else
    <div class="text-center py-20">
        <svg class="w-24 h-24 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <h2 class="text-xl font-bold mb-2">Belum Ada Pesanan</h2>
        <p class="text-gray-500 text-sm mb-6">Pesanan yang sudah dibuat akan muncul di sini</p>
        <a href="{{ url('/products') }}" class="inline-flex items-center gap-2 bg-[#111] text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-[#FA5400] transition-all">
            Mulai Belanja
        </a>
    </div>
    @endif
</section>
@endsection
