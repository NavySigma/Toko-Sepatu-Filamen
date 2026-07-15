@extends('layouts.app')
@section('title', 'Profil — Fenrir')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-black uppercase tracking-tight mb-8">Profil Saya</h1>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Profile Card --}}
        <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-2xl p-6 text-center sticky top-24">
                <div class="w-20 h-20 bg-gradient-to-br from-[#FA5400] to-[#FF8A50] rounded-full flex items-center justify-center text-white text-2xl font-black mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="font-bold text-lg">{{ $user->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                <p class="text-gray-400 text-xs mt-1">Member sejak {{ $user->created_at->format('M Y') }}</p>

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white rounded-xl p-3">
                        <p class="text-2xl font-black text-[#FA5400]">{{ $totalOrders }}</p>
                        <p class="text-xs text-gray-500">Pesanan</p>
                    </div>
                    <div class="bg-white rounded-xl p-3">
                        <p class="text-sm font-black text-[#FA5400]">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">Total Belanja</p>
                    </div>
                </div>

                <a href="{{ url('/orders') }}" class="w-full mt-4 bg-[#111] text-white py-3 rounded-xl text-sm font-bold hover:bg-[#FA5400] transition-all inline-block">
                    Lihat Pesanan
                </a>
            </div>
        </div>

        {{-- Edit Forms --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Update Profile --}}
            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-6">Ubah Profil</h3>
                <form method="POST" action="{{ url('/profile') }}" class="space-y-4" id="profile-form">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] transition-all @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="profile-email" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Email</label>
                        <input type="email" name="email" id="profile-email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] transition-all @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-[#111] text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-[#FA5400] transition-all">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-6">Ubah Password</h3>
                <form method="POST" action="{{ url('/profile/password') }}" class="space-y-4" id="password-form">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full px-4 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] transition-all @error('current_password') border-red-400 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="new-password" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Password Baru</label>
                        <input type="password" name="password" id="new-password" required
                            class="w-full px-4 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] transition-all @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-3 bg-white border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] transition-all">
                    </div>
                    <button type="submit" class="bg-[#111] text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-[#FA5400] transition-all">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
