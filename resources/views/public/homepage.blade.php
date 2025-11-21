<x-public-layout>
    <div class="bg-gray-100 min-h-screen">
        {{-- Navbar sederhana untuk Guest --}}
        @include('layouts.public_nav') 

        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    Temukan Course Terbaikmu di CircleHub
                </h1>
                <p class="mt-4 max-w-md mx-auto text-xl text-gray-500">
                    Akses pembelajaran interaktif dari guru-guru terbaik.
                </p>
                <div class="mt-8">
                    <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Lihat Semua Course
                    </a>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('catalog') }}" method="GET" class="flex space-x-4">
                <input type="search" name="search" placeholder="Cari course..." class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <select name="category" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Cari</button>
            </form>
        </div>

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">🔥 5 Course Terpopuler</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                @forelse ($popularCourses as $course)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-105">
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-900 truncate">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $course->teacher->name ?? 'Admin' }}</p>
                            <p class="text-xs text-indigo-600 mt-2">{{ $course->enrollments_count }} Peserta</p>
                            <a href="{{ route('course.show', $course->slug) }}" class="mt-3 block text-center text-sm font-medium text-white bg-indigo-500 rounded py-1 hover:bg-indigo-600">Lihat Detail</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-5">Belum ada kursus aktif.</p>
                @endforelse
            </div>
        </div>

        <footer class="bg-gray-800 text-white p-6 mt-10">
            <div class="max-w-7xl mx-auto text-center">
                &copy; 2025 CircleHub. All rights reserved.
            </div>
        </footer>
    </div>
</x-public-layout>