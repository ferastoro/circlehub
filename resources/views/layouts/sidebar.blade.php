<div class="py-4 text-gray-500 dark:text-gray-400">
    {{-- LOGO SAJA (Tanpa Teks) --}}
    <a class="ml-6 flex items-center" href="{{ route('homepage') }}">
        <img src="{{ asset('images/logo-circlehub.png') }}" 
             alt="CircleHub" 
             class="h-12 w-auto object-contain"> {{-- 🔥 UBAH UKURAN DI SINI --}}
    </a>
    
    <ul class="mt-6">
        {{-- DASHBOARD UTAMA (Link ke halaman utama Dashboard / Statistik) --}}
        <li class="relative px-6 py-3">
            @if(request()->routeIs('dashboard'))
                <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
            @endif
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('dashboard') ? 'text-gray-800' : '' }}"
            href="{{ route('dashboard') }}"> {{-- 🔥 PERBAIKAN: Harusnya route('dashboard') --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="ml-4">Dashboard</span>
            </a>
        </li>
    </ul>

    <ul>
        {{-- MENU ADMIN --}}
        @if(Auth::user()->role === 'admin')
            <li class="px-6 py-2 text-xs font-bold text-gray-400 uppercase">Admin Menu</li>
            
            <li class="relative px-6 py-3">
                @if(request()->routeIs('admin.users.*')) <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"></span> @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('admin.users.*') ? 'text-gray-800' : '' }}" href="{{ route('admin.users.index') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="ml-4">Users</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                @if(request()->routeIs('admin.categories.*')) <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"></span> @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('admin.categories.*') ? 'text-gray-800' : '' }}" href="{{ route('admin.categories.index') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <span class="ml-4">Categories</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                @if(request()->routeIs('admin.courses.*')) <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"></span> @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('admin.courses.*') ? 'text-gray-800' : '' }}" href="{{ route('admin.courses.index') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span class="ml-4">All Courses</span>
                </a>
            </li>

        {{-- MENU TEACHER --}}
        @elseif(Auth::user()->role === 'teacher')
            <li class="px-6 py-2 text-xs font-bold text-gray-400 uppercase">Teacher Menu</li>
            <li class="relative px-6 py-3">
                @if(request()->routeIs('teacher.courses.*')) <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"></span> @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('teacher.courses.*') ? 'text-gray-800' : '' }}" href="{{ route('teacher.courses.index') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span class="ml-4">My Courses</span>
                </a>
            </li>

        {{-- MENU STUDENT --}}
        @elseif(Auth::user()->role === 'student')
            <li class="px-6 py-2 text-xs font-bold text-gray-400 uppercase">Learning</li>
            
            {{-- MY COURSES (Link ke halaman Grid Kursus) --}}
            <li class="relative px-6 py-3">
                @if(request()->routeIs('student.my_courses')) 
                    <span class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"></span> 
                @endif
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 {{ request()->routeIs('student.my_courses') ? 'text-gray-800' : '' }}" 
                   href="{{ route('student.my_courses') }}"> {{-- 🔥 PERBAIKAN: Harusnya route('student.my_courses') --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span class="ml-4">My Courses</span>
                </a>
            </li>

            {{-- BROWSE CATALOG --}}
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="{{ route('catalog') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span class="ml-4">Browse Catalog</span>
                </a>
            </li>
        @endif
    </ul>
</div>