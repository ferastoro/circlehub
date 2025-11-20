<x-guest-layout>
    <div class="bg-gray-100 min-h-screen">
        @include('layouts.public_nav') 

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Course Catalog</h1>
            
            {{-- Search dan Filter Section --}}
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <form action="{{ route('catalog') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    
                    {{-- Kolom Pencarian --}}
                    <input type="search" name="search" placeholder="Cari course berdasarkan judul atau deskripsi..." 
                           class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           value="{{ request('search') }}">

                    {{-- Opsi Filtering Kategori --}}
                    <select name="category" class="rounded-md border-gray-300 shadow-sm w-full md:w-auto">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 w-full md:w-auto">Filter & Cari</button>
                    @if (request()->hasAny(['search', 'category']))
                        <a href="{{ route('catalog') }}" class="px-4 py-2 text-center text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 w-full md:w-auto">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Daftar Course --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                        <div class="p-6">
                            <span class="text-xs font-semibold text-indigo-600 uppercase">{{ $course->category->name }}</span>
                            <h3 class="font-bold text-2xl text-gray-900 mt-2 hover:text-indigo-600">
                                <a href="{{ route('course.show', $course->slug) }}">{{ $course->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-500 mt-3 line-clamp-3">{{ Str::limit($course->description, 100) }}</p>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-sm font-medium text-gray-700">Oleh: {{ $course->teacher->name }}</p>
                                <a href="{{ route('course.show', $course->slug) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 bg-white p-8 rounded-lg text-center shadow-lg">
                        <p class="text-gray-600 text-lg">Tidak ada course yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $courses->links() }}
            </div>
        </div>

        @include('layouts.footer') {{-- Asumsi kita buat footer terpisah nanti --}}
    </div>
</x-guest-layout>