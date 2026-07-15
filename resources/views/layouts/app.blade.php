<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fenrir — Premium Footwear Store.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fenrir — Premium Footwear')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white text-[#111] font-['Inter'] antialiased">

    {{-- Announcement Bar --}}
    <div class="bg-[#111] text-white text-center text-xs tracking-wider py-2 font-medium">
        GRATIS ONGKIR UNTUK PEMBELIAN DI ATAS Rp 500.000
    </div>

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100" id="main-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group" id="nav-logo">
                    <div class="w-8 h-8 bg-[#111] rounded-lg flex items-center justify-center group-hover:bg-[#FA5400] transition-colors duration-300">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2z"/></svg>
                    </div>
                    <span class="text-2xl font-black italic tracking-tight" style="font-family: 'Playfair Display', serif;">Fenrir</span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ url('/') }}" class="text-sm font-semibold hover:text-[#FA5400] transition-colors {{ request()->is('/') ? 'text-[#FA5400]' : '' }}">Home</a>
                    <a href="{{ url('/products') }}" class="text-sm font-semibold hover:text-[#FA5400] transition-colors {{ request()->is('products*') ? 'text-[#FA5400]' : '' }}">Katalog</a>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('search-bar').classList.toggle('hidden')" class="p-2 hover:bg-gray-100 rounded-full transition-colors" id="search-toggle">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    @auth
                        <a href="{{ url('/cart') }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors relative" id="nav-cart">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="absolute -top-1 -right-1 bg-[#FA5400] text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ array_sum(array_column(session('cart'), 'qty')) }}
                                </span>
                            @endif
                        </a>

                        <div class="relative">
                            <button onclick="document.getElementById('user-dropdown').classList.toggle('hidden')" class="w-8 h-8 bg-gradient-to-br from-[#FA5400] to-[#FF8A50] rounded-full flex items-center justify-center text-white text-xs font-bold" id="user-menu-btn">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 hidden z-50" id="user-dropdown">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ url('/profile') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50">Profil Saya</a>
                                <a href="{{ url('/orders') }}" class="block px-4 py-2.5 text-sm hover:bg-gray-50">Pesanan Saya</a>
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form method="POST" action="{{ url('/logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ url('/login') }}" class="text-sm font-semibold hover:text-[#FA5400] transition-colors hidden sm:block">Masuk</a>
                        <a href="{{ url('/register') }}" class="bg-[#111] text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-[#FA5400] transition-all duration-300 hidden sm:block">Daftar</a>
                    @endauth

                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden bg-white border-t border-gray-100 py-4" id="search-bar">
            <div class="max-w-7xl mx-auto px-4">
                <form action="{{ url('/products') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari sepatu..." value="{{ request('search') }}" class="w-full py-3 px-5 pr-12 bg-gray-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#FA5400]" id="search-input">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></button>
                </form>
            </div>
        </div>

        <div class="hidden md:hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ url('/') }}" class="block py-2 px-4 text-sm font-semibold rounded-xl hover:bg-gray-50">Home</a>
                <a href="{{ url('/products') }}" class="block py-2 px-4 text-sm font-semibold rounded-xl hover:bg-gray-50">Katalog</a>
                @guest
                    <div class="border-t border-gray-100 pt-2 mt-2 flex gap-2">
                        <a href="{{ url('/login') }}" class="flex-1 text-center py-2.5 text-sm font-semibold border-2 border-[#111] rounded-full">Masuk</a>
                        <a href="{{ url('/register') }}" class="flex-1 text-center py-2.5 text-sm font-semibold bg-[#111] text-white rounded-full">Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="fixed top-20 right-4 z-[100]" id="flash-success" style="animation: slideIn 0.3s ease-out">
            <div class="bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl text-sm font-medium flex items-center gap-2">
                ✓ {{ session('success') }}
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2">✕</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-4 z-[100]" id="flash-error" style="animation: slideIn 0.3s ease-out">
            <div class="bg-red-500 text-white px-6 py-3 rounded-2xl shadow-2xl text-sm font-medium flex items-center gap-2">
                ✗ {{ session('error') }}
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2">✕</button>
            </div>
        </div>
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-[#111] text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-[#FA5400] rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2z"/></svg>
                        </div>
                        <span class="text-2xl font-black italic tracking-tight" style="font-family: 'Playfair Display', serif;">Fenrir</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Premium footwear untuk gaya hidup modern.</p>
                </div>
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-[#FA5400] text-sm transition-colors">Home</a></li>
                        <li><a href="{{ url('/products') }}" class="text-gray-400 hover:text-[#FA5400] text-sm transition-colors">Katalog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Bantuan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-[#FA5400] text-sm transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#FA5400] text-sm transition-colors">Kebijakan Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Kontak</h4>
                    <p class="text-gray-400 text-sm">hello@fenrir.id</p>
                    <p class="text-gray-400 text-sm">+62 812 3456 7890</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} Fenrir. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('click', function(e) {
            const dd = document.getElementById('user-dropdown');
            const btn = document.getElementById('user-menu-btn');
            if (dd && btn && !btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden');
        });
        setTimeout(() => { document.querySelectorAll('#flash-success, #flash-error').forEach(el => { el.style.opacity='0'; setTimeout(()=>el.remove(),300); }); }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
