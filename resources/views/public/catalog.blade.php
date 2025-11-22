<x-public-layout>
    <div class="bg-gray-50 min-h-screen font-sans text-gray-900">
        @include('layouts.public_nav') 

        {{-- Header & Search --}}
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-10">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Jelajahi Katalog Kursus</h1>
                    <p class="text-lg text-gray-500">Temukan keahlian baru dari ribuan materi yang tersedia untuk meningkatkan karir Anda.</p>
                </div>
                
                {{-- Search Box yang Rapi --}}
                <div class="bg-white p-2 rounded-2xl shadow-lg border border-gray-100 max-w-4xl mx-auto">
                    <form action="{{ route('catalog') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                        
                        {{-- Input Search --}}
                        <div class="flex-grow relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="search" name="search" placeholder="Cari judul kursus, materi, atau mentor..." 
                                   class="w-full pl-11 pr-4 py-3 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 bg-gray-50 text-gray-900 placeholder-gray-400"
                                   value="{{ request('search') }}">
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="md:w-1/4">
                            <select name="category" class="w-full py-3 px-4 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 bg-gray-50 text-gray-900 cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Tombol Submit --}}
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                            Cari
                        </button>

                        @if (request()->hasAny(['search', 'category']))
                            <a href="{{ route('catalog') }}" class="flex items-center justify-center px-4 py-3 text-gray-500 hover:text-red-600 font-medium transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Grid Kursus (Sama Persis dengan Homepage) --}}
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            
            {{-- Indikator Hasil Pencarian --}}
            @if(request('search') || request('category'))
                <div class="mb-8">
                    <p class="text-gray-600">Menampilkan hasil untuk pencarian Anda...</p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col h-full">
                        
                        {{-- Thumbnail Course --}}
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            {{-- Logic Gambar (Sama seperti Homepage) --}}
                            @php
                                $imageSrc = $course->image_path ? asset($course->image_path) : 'https://placehold.co/600x400/EEE/31343C?text=No+Image';
                            @endphp

                            <img src="{{ $imageSrc }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                                 onerror="this.onerror=null; this.src='https://placehold.co/600x400/EEE/31343C?text=Error+Loading';">
                            
                            {{-- Category Badge --}}
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-indigo-700 shadow-sm">
                                {{ $course->category->name }}
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                                <a href="{{ route('course.show', $course->slug) }}">
                                    {{ $course->title }}
                                </a>
                            </h3>
                            
                            <div class="flex items-center mb-4">
                                {{-- Avatar Mentor Kecil --}}
                                <div class="h-6 w-6 rounded-full bg-gray-300 flex items-center justify-center text-xs text-gray-600 font-bold mr-2 border border-white shadow-sm">
                                    {{ substr($course->teacher->name, 0, 1) }}
                                </div>
                                <p class="text-sm text-gray-500 truncate">{{ $course->teacher->name }}</p>
                            </div>

                            {{-- Bagian Bawah Card --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{-- Menggunakan withCount('enrollments') yang dikirim controller atau relasi --}}
                                    <span>{{ $course->enrollments_count ?? $course->enrollments->count() }} Peserta</span>
                                </div>
                                <a href="{{ route('course.show', $course->slug) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Tidak ada kursus ditemukan</h3>
                        <p class="mt-1 text-gray-500">Coba ubah kata kunci pencarian atau filter kategori.</p>
                        <a href="{{ route('catalog') }}" class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Reset Pencarian</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        </div>

        @include('layouts.footer')
    </div>
</x-public-layout>