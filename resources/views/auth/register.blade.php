@extends('layouts.app')
@section('title', 'Daftar — Fenrir')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="w-14 h-14 bg-[#111] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2z"/></svg>
            </div>
            <h1 class="text-2xl font-black tracking-tight">Bergabung dengan Fenrir</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk mulai berbelanja</p>
        </div>

        <form method="POST" action="{{ url('/register') }}" class="space-y-5" id="register-form">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] focus:bg-white transition-all @error('name') border-red-400 @enderror"
                    placeholder="John Doe">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] focus:bg-white transition-all @error('email') border-red-400 @enderror"
                    placeholder="nama@email.com">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] focus:bg-white transition-all @error('password') border-red-400 @enderror"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#FA5400] focus:bg-white transition-all"
                    placeholder="Ulangi password">
            </div>

            <button type="submit" class="w-full bg-[#111] text-white py-4 rounded-xl text-sm font-bold hover:bg-[#FA5400] transition-all duration-300" id="register-btn">
                Buat Akun
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-8">
            Sudah punya akun?
            <a href="{{ url('/login') }}" class="text-[#FA5400] font-semibold hover:underline">Masuk</a>
        </p>
    </div>
</section>
@endsection
