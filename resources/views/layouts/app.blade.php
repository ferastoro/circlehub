<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CircleHub') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    {{-- State Utama untuk Sidebar --}}
    <div class="flex h-screen bg-gray-50" x-data="{ isSideMenuOpen: false }">
        
        <aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0 shadow-md border-r border-gray-200">
            @include('layouts.sidebar')
        </aside>

        <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center md:hidden" @click="isSideMenuOpen = false" style="display: none;"></div>
        
        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="transform -translate-x-20" x-transition:enter-end="transform translate-x-0" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="transform translate-x-0" x-transition:leave-end="transform -translate-x-20" @click.away="isSideMenuOpen = false" @keydown.escape="isSideMenuOpen = false" style="display: none;">
            @include('layouts.sidebar')
        </aside>

        <div class="flex flex-col flex-1 w-full">
            
            <header class="z-10 py-4 bg-white shadow-sm border-b border-gray-200">
                <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 md:justify-end">
                    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="isSideMenuOpen = !isSideMenuOpen" aria-label="Menu">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        {{-- Nama User (Teks) --}}
                        <span class="text-sm font-medium text-gray-700 hidden md:block">{{ Auth::user()->name }}</span>

                        {{-- Dropdown Menu --}}
                        <div class="relative" x-data="{ isProfileMenuOpen: false }">
                            <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" 
                                    @click="isProfileMenuOpen = !isProfileMenuOpen" 
                                    @keydown.escape="isProfileMenuOpen = false" 
                                    aria-label="Account" 
                                    aria-haspopup="true">
                                {{-- Avatar Placeholder --}}
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                            
                            {{-- Dropdown Content --}}
                            <div x-show="isProfileMenuOpen" 
                                 x-transition:leave="transition ease-in duration-150" 
                                 x-transition:leave-start="opacity-100" 
                                 x-transition:leave-end="opacity-0" 
                                 @click.away="isProfileMenuOpen = false" 
                                 @keydown.escape="isProfileMenuOpen = false"
                                 class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md z-50" 
                                 style="display: none;">
                                <div class="px-2 py-1 border-b border-gray-100">
                                    <p class="text-xs font-bold text-gray-500 uppercase">Role</p>
                                    <p class="text-sm font-semibold text-indigo-600">{{ ucfirst(Auth::user()->role) }}</p>
                                </div>
                                <ul class="flex flex-col">
                                    <li class="flex">
                                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="{{ route('profile.edit') }}">
                                            <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li class="flex">
                                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                                            @csrf
                                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                                <span>Log out</span>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>