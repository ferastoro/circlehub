<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('homepage') }}" class="text-2xl font-bold text-indigo-600">CircleHub</a>
            </div>

            <div class="flex items-center space-x-4">
                {{-- Link ke Catalog --}}
                <a href="{{ route('catalog') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Course Catalog</a>
                
                {{-- LOGIKA LOGIN/REGISTER vs DASHBOARD --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>