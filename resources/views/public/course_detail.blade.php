<x-public-layout>
    <div class="bg-gray-50 min-h-screen">
        @include('layouts.public_nav') 

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('catalog') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">&larr; Kembali ke Catalog</a>

            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: Deskripsi dan Konten --}}
                    <div class="lg:col-span-2">
                        <span class="text-sm font-semibold text-indigo-600 uppercase">{{ $course->category->name }}</span>
                        <h1 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $course->title }}</h1>
                        <p class="text-gray-500 mt-1">Oleh: <span class="font-semibold text-gray-800">{{ $course->teacher->name }}</span></p>

                        <div class="mt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Deskripsi Course</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
                        </div>

                        {{-- Daftar Isi / Konten Pelajaran --}}
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Isi Materi ({{ $course->contents->count() }} Pelajaran)</h3>
                            
                            <div class="space-y-3">
                                @forelse ($course->contents->sortBy('order_sequence') as $content)
                                    <div class="p-4 bg-gray-100 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <span class="font-semibold text-indigo-600">{{ $content->order_sequence }}.</span>
                                            <p class="text-gray-800">{{ $content->title }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $isEnrolled ? 'Akses' : 'Preview' }}</span>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Materi belum tersedia.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Sidebar Aksi --}}
                    <div class="lg:col-span-1 border-l pl-8 border-gray-200">
                        <div class="sticky top-10">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Course</h3>
                            
                            <p class="text-sm text-gray-600 mb-2">Tanggal Mulai: <span class="font-medium">{{ $course->start_date }}</span></p>
                            <p class="text-sm text-gray-600 mb-4">Tanggal Selesai: <span class="font-medium">{{ $course->end_date }}</span></p>

                            {{-- TOMBOL AKSI UTAMA (Enrollment Logic) --}}
                            @auth
                                @if(Auth::user()->hasRole('student'))
                                    @if($isEnrolled)
                                      <a href="{{ $firstLesson ? route('student.lesson.show', [$course, $firstLesson]) : '#' }}" 
                                        class="w-full block text-center px-4 py-3 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition {{ $firstLesson ? '' : 'opacity-50 cursor-not-allowed' }}">
                                            Lanjutkan Kursus &rarr; 
                                        </a>
                                        <p class="text-xs text-gray-500 mt-2">Progress: 0% Selesai</p>                                    @else
                                        {{-- Tombol untuk Enrollment --}}
                                        <form method="POST" action="{{ route('enroll.store', $course) }}">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition">
                                                Ikuti Course Ini
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <p class="text-sm text-orange-600 font-medium">Anda login sebagai {{ ucfirst(Auth::user()->role) }}</p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full block text-center px-4 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition">
                                    Login untuk Mengikuti Course
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</x-public-layout>