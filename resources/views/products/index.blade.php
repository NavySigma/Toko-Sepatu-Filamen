@extends('layouts.app')
@section('title', 'Katalog Sepatu — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black uppercase tracking-tight">Katalog Sepatu</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $products->total() }} produk ditemukan</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <aside class="lg:w-64 shrink-0">
            <form method="GET" action="{{ url('/products') }}" id="filter-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="bg-gray-50 rounded-2xl p-6 space-y-6 sticky top-24">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-sm uppercase tracking-wider">Filter</h3>
                        <a href="{{ url('/products') }}" class="text-xs text-[#FA5400] hover:underline">Reset</a>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Kategori</p>
                        <div class="space-y-2">
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="kategori" value="{{ $cat }}" {{ request('kategori') == $cat ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#FA5400] focus:ring-[#FA5400] border-gray-300" onchange="this.form.submit()">
                                <span class="text-sm group-hover:text-[#FA5400] transition-colors">{{ $cat }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brand --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Brand</p>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="merk" value="{{ $brand }}" {{ request('merk') == $brand ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#FA5400] focus:ring-[#FA5400] border-gray-300" onchange="this.form.submit()">
                                <span class="text-sm group-hover:text-[#FA5400] transition-colors">{{ $brand }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Warna --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Warna</p>
                        <div class="space-y-2">
                            @foreach($colors as $color)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="warna" value="{{ $color }}" {{ request('warna') == $color ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#FA5400] focus:ring-[#FA5400] border-gray-300" onchange="this.form.submit()">
                                <span class="text-sm group-hover:text-[#FA5400] transition-colors">{{ $color }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            {{-- Sort Bar --}}
            <div class="flex items-center justify-between mb-6 bg-gray-50 rounded-xl px-4 py-3">
                <p class="text-sm text-gray-500">
                    @if(request('search'))
                        Hasil pencarian: <strong>"{{ request('search') }}"</strong>
                    @endif
                </p>
                <form method="GET" action="{{ url('/products') }}" class="flex items-center gap-2" id="sort-form">
                    @foreach(request()->except('sort', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label class="text-xs text-gray-500">Urutkan:</label>
                    <select name="sort" onchange="this.form.submit()" class="text-sm font-semibold bg-transparent border-none focus:ring-0 cursor-pointer pr-8">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga ↑</option>
                        <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga ↓</option>
                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                </form>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-20">
                <svg class="w-20 h-20 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <p class="text-gray-500 font-medium text-lg">Tidak ada produk ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
                <a href="{{ url('/products') }}" class="inline-block mt-4 text-sm font-semibold text-[#FA5400] hover:underline">Reset Filter</a>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
