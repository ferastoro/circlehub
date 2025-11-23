<nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="{{ route('homepage') }}" class="flex items-center group">
                    {{-- LOGO GAMBAR --}}
                    <img src="{{ asset('images/logo-circlehub.png') }}" 
                         alt="CircleHub Logo" 
                         class="block h-[60px] w-auto mt-2 transition transform group-hover:scale-110">
                </a>
            </div>

            <div class="flex items-center space-x-6">
                {{-- Link ke Catalog --}}
                <a href="{{ route('catalog') }}" class="text-gray-600 hover:text-indigo-600 font-bold transition text-sm uppercase tracking-wide">
                    Courses
                </a>
                
                {{-- LOGIKA LOGIN/REGISTER vs DASHBOARD --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-indigo-600 text-white font-bold rounded-full shadow-md hover:bg-indigo-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Dashboard
                    </a>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-bold transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white font-bold rounded-full shadow-md hover:bg-indigo-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</nav>