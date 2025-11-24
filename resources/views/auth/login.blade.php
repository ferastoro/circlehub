<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CircleHub') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        {{-- === BAGIAN KIRI: VISUAL / BANNER === --}}
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-900 relative overflow-hidden items-center justify-center">
            {{-- Background Gradient & Decoration --}}
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-800 opacity-90"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-500 opacity-20 rounded-full blur-2xl"></div>
            
            {{-- Pattern Overlay (Optional) --}}
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="relative z-10 text-center px-12 ">
                {{-- Logo Besar --}}
                <img src="{{ asset('images/logo-only.png') }}" alt="Logo" class="h-[200px] w-auto mx-auto mb-5 drop-shadow-xl">
                
                <h2 class="text-4xl font-extrabold text-white mb-4 tracking-tight">
                    Tingkatkan Skill,<br>Raih Impianmu.
                </h2>
                <p class="text-indigo-100 text-lg max-w-md mx-auto leading-relaxed">
                    Bergabunglah dengan ribuan siswa lainnya di CircleHub dan akses materi pembelajaran terbaik dari para ahli.
                </p>
            </div>
        </div>

        {{-- === BAGIAN KANAN: FORM LOGIN === --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                {{-- Header Form --}}
                <div class="text-center lg:text-left">
                    {{-- Logo Mobile (Hanya muncul di layar kecil) --}}
                    <img src="{{ asset('images/logo-circlehub.png') }}" alt="Logo" class="h-12 w-auto mx-auto lg:hidden mb-6">
                    
                    <h2 class="text-3xl font-bold text-gray-900">Selamat Datang Kembali! 👋</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition">
                            Daftar Gratis Sekarang
                        </a>
                    </p>
                </div>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    {{-- Email Address --}}
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required autofocus
                               value="{{ old('email') }}"
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition"
                               placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Ingat Saya
                        </label>
                    </div>

                    {{-- Tombol Login --}}
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-0.5">
                            Masuk Sekarang
                        </button>
                    </div>

                    {{-- Divider (Optional Social Login Placeholder) --}}
                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Atau kembali ke</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('homepage') }}" class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition">
                            <span class="sr-only">Homepage</span>
                            ← Halaman Utama
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>