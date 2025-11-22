<x-public-layout>
    <div class="bg-white min-h-screen font-sans text-gray-900">
        @include('layouts.public_nav') 

        {{-- === SECTION 1: HERO (Inspirasi Gambar 1) === --}}
        <header class="relative overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-16 lg:pt-24 lg:pb-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    {{-- Kiri: Teks & CTA --}}
                    <div class="space-y-8 text-center lg:text-left relative z-10 ">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 ">
                            Belajar Coding <br>
                            <span class="text-indigo-600 relative leading-normal py-3">
                                Lebih Menyenangkan
                                <svg class="absolute w-full h-3 -bottom-1 left-0 text-indigo-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" /></svg>
                            </span>
                        </h1>
                        <p class="text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto lg:mx-0">
                            Platform belajar interaktif dengan kurikulum terupdate. Bangun karir impianmu bersama mentor berpengalaman di CircleHub.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                            <a href="{{ route('register') }}" class="px-8 py-4 text-base font-bold text-white bg-indigo-600 rounded-full shadow-lg hover:bg-indigo-700 hover:shadow-indigo-200 transition transform hover:-translate-y-1">
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('catalog') }}" class="px-8 py-4 text-base font-bold text-indigo-700 bg-indigo-50 rounded-full hover:bg-indigo-100 transition">
                                Lihat Kursus
                            </a>
                        </div>

                        {{-- Stats Kecil --}}
                        <div class="pt-8 flex items-center justify-center lg:justify-start space-x-8 text-gray-500">
                            <div class="text-left">
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'student')->count() }}+</p>
                                <p class="text-sm">Siswa Aktif</p>
                            </div>
                            <div class="w-px h-10 bg-gray-300"></div>
                            <div class="text-left">
                                <p class="text-2xl font-bold text-gray-900">{{ $popularCourses->count() }}+</p>
                                <p class="text-sm">Kelas Tersedia</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan: Ilustrasi Gambar --}}
                    <div class="relative lg:ml-10">
                        {{-- Background Blob Decoration --}}
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-purple-100 rounded-full blur-3xl opacity-50"></div>
                        
                        {{-- GAMBAR UTAMA (Pastikan file ada di public/images/hero-illustration.png) --}}
                        <img src="{{ asset('images/hero-illustration.png') }}" 
                             alt="Belajar Coding" 
                             class="relative z-10 w-full h-auto drop-shadow-2xl transform hover:scale-105 transition duration-500"
                             onerror="this.onerror=null; this.src='https://placehold.co/600x500/EEE/31343C?text=Hero+Image';"> 
                             {{-- (Kode onerror di atas otomatis pakai placeholder jika gambar kamu belum ada) --}}
                    </div>
                </div>
            </div>
        </header>

        {{-- === SECTION 2: FEATURES (Inspirasi Gambar 2) === --}}
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Kenapa Kami?</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Keunggulan Belajar di CircleHub
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    {{-- Feature 1 --}}
                    <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 border border-gray-100">
                        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 text-2xl">
                            📚
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Materi Terstruktur</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Kurikulum disusun sistematis dari dasar hingga mahir, memudahkan pemula untuk mengikuti.
                        </p>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 border border-gray-100">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6 text-2xl">
                            👨‍🏫
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Mentor Profesional</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Belajar langsung dari praktisi industri yang siap membimbing dan menjawab pertanyaanmu.
                        </p>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition duration-300 border border-gray-100">
                        <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center mb-6 text-2xl">
                            🏆
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Sertifikat Kompetensi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Dapatkan bukti kelulusan valid yang bisa digunakan untuk melamar pekerjaan impian.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- === SECTION 3: POPULAR COURSES (Inspirasi Gambar 3) === --}}
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Kursus Populer</h2>
                        <p class="mt-2 text-gray-500">Kelas paling diminati minggu ini</p>
                    </div>
                    <a href="{{ route('catalog') }}" class="hidden sm:inline-flex items-center font-semibold text-indigo-600 hover:text-indigo-500">
                        Lihat Semua Kursus &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse ($popularCourses->take(4) as $course)
                        <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col h-full">
                            
                            {{-- Thumbnail Course --}}
                            <div class="relative h-48 bg-gray-200 overflow-hidden">
                                <img src="{{ $course->image_path ? asset($course->image_path) : 'https://placehold.co/600x400/EEE/31343C?text=No+Image' }}" 
                                    alt="{{ $course->title }}" 
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                                    onerror="this.onerror=null; this.src='https://placehold.co/600x400/EEE/31343C?text=Error';">
                                
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
                                    {{-- Avatar Mentor Kecil (Placeholder) --}}
                                    <div class="h-6 w-6 rounded-full bg-gray-300 flex items-center justify-center text-xs text-gray-600 font-bold mr-2">
                                        {{ substr($course->teacher->name, 0, 1) }}
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">{{ $course->teacher->name }}</p>
                                </div>

                                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span>{{ $course->enrollments_count }} Peserta</span>
                                    </div>
                                    <a href="{{ route('course.show', $course->slug) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-10">
                            <p class="text-gray-500">Belum ada kursus aktif saat ini.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-10 text-center sm:hidden">
                    <a href="{{ route('catalog') }}" class="inline-flex items-center font-semibold text-indigo-600 hover:text-indigo-500">
                        Lihat Semua Kursus &rarr;
                    </a>
                </div>
            </div>
        </section>

        {{-- === SECTION 4: CTA (Call to Action) === --}}
        <section class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-indigo-600 rounded-3xl p-10 md:p-16 text-center text-white shadow-2xl relative overflow-hidden">
                    {{-- Dekorasi Background --}}
                    <div class="absolute top-0 left-0 -mt-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                    <div class="absolute bottom-0 right-0 -mb-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>

                    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 relative z-10">Siap Memulai Perjalanan Belajarmu?</h2>
                    <p class="text-lg md:text-xl text-indigo-100 mb-10 max-w-2xl mx-auto relative z-10">
                        Bergabunglah dengan ribuan siswa lainnya dan tingkatkan skill digitalmu hari ini. Gratis pendaftaran!
                    </p>
                    <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-indigo-700 font-bold rounded-full shadow-lg hover:bg-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 relative z-10">
                        Buat Akun Gratis
                    </a>
                </div>
            </div>
        </section>

        @include('layouts.footer')
    </div>
</x-public-layout>