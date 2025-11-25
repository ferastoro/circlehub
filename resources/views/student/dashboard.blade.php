<x-app-layout>
    <div class="pb-6">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 mt-6 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Dashboard Belajar</h2>
                <p class="text-gray-500 mt-1">Selamat datang kembali, <span class="text-indigo-600 font-bold">{{ Auth::user()->name }}</span>! Siap lanjut belajar?</p>
            </div>
            <div class="hidden md:block text-right bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Hari Ini</p>
                <p class="font-bold text-gray-800 text-lg">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- === KOLOM KIRI (MAIN CONTENT - Span 8) === --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- HERO CARD: Course Terakhir Diakses --}}
                @if($enrollments->count() > 0)
                    @php $lastCourse = $enrollments->first(); @endphp
                    <div class="relative bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-8 text-white overflow-hidden shadow-2xl group">
                        {{-- Dekorasi Background --}}
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl transition transform group-hover:scale-110 duration-700"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-40 h-40 bg-blue-500 opacity-20 rounded-full blur-2xl"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center space-x-3 mb-6">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold border border-white/10 shadow-sm">
                                    Lanjutkan Belajar 🚀
                                </span>
                                <span class="px-3 py-1 bg-black/20 backdrop-blur-md rounded-full text-xs font-bold border border-white/5">
                                    {{ $lastCourse->course->category->name }}
                                </span>
                            </div>
                            
                            <h3 class="text-2xl md:text-4xl font-extrabold mb-3 leading-tight tracking-tight">
                                {{ $lastCourse->course->title }}
                            </h3>
                            <p class="text-indigo-100 mb-8 max-w-lg text-sm md:text-base opacity-90 line-clamp-2 leading-relaxed">
                                {{ $lastCourse->course->description }}
                            </p>
                            
                            {{-- Progress Bar Besar --}}
                            <div class="bg-white/10 p-5 rounded-2xl backdrop-blur-md border border-white/10 shadow-inner">
                                <div class="flex justify-between mb-2 text-xs font-bold text-indigo-100 tracking-wide uppercase">
                                    <span>Progress Kelas</span>
                                    <span>{{ $lastCourse->progress_percentage }}% Selesai</span>
                                </div>
                                <div class="w-full bg-black/20 rounded-full h-3 mb-4 overflow-hidden">
                                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-3 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(52,211,153,0.5)]" 
                                         style="width: {{ $lastCourse->progress_percentage }}%"></div>
                                </div>
                                
                                <div class="flex justify-end gap-3">
                                    {{-- Tombol Sertifikat jika 100% --}}
                                    @if($lastCourse->progress_percentage == 100)
                                        <a href="{{ route('student.certificate.download', $lastCourse->course) }}" class="inline-flex items-center bg-yellow-500 text-white px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-yellow-600 transition shadow-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Sertifikat
                                        </a>
                                    @endif

                                    <a href="{{ route('course.show', $lastCourse->course->slug) }}" class="inline-flex items-center bg-white text-indigo-700 px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-50 transition transform hover:-translate-y-0.5 shadow-lg">
                                        Lanjutkan Materi
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-10 text-center border-2 border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-500 text-2xl">🎓</div>
                        <h3 class="text-lg font-bold text-gray-800">Belum ada kursus</h3>
                        <p class="text-gray-500 mb-6">Mulai perjalanan belajarmu dengan mengambil kursus pertamamu.</p>
                        <a href="{{ route('catalog') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200">Cari Kursus di Katalog</a>
                    </div>
                @endif

                {{-- My Courses List (Grid Kecil untuk sisa course) --}}
                @if($enrollments->count() > 1)
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                        <span class="w-1.5 h-6 bg-indigo-500 rounded-full mr-3"></span>
                        Kursus Lainnya
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach($enrollments->skip(1) as $enrollment)
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-100 transition group relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-bl-full -mr-10 -mt-10 transition group-hover:scale-110"></div>
                                
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="h-10 w-10 rounded-xl bg-white border border-gray-100 text-indigo-600 flex items-center justify-center text-lg shadow-sm">
                                            📚
                                        </div>
                                        @if($enrollment->progress_percentage == 100)
                                            <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-1 rounded-lg">SELESAI</span>
                                        @endif
                                    </div>
                                    
                                    <h4 class="font-bold text-gray-800 mb-1 line-clamp-1 group-hover:text-indigo-600 transition">{{ $enrollment->course->title }}</h4>
                                    <p class="text-xs text-gray-500 mb-4 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $enrollment->course->teacher->name }}
                                    </p>
                                    
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-4">
                                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 gap-2 mt-auto">    
                                        <a href="{{ route('course.show', $enrollment->course->slug) }}" class="block text-center w-full py-2.5 text-xs font-bold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                            Lihat Detail
                                        </a>

                                        {{-- 🔥 PERBAIKAN: Tombol Sertifikat di Card Kecil --}}
                                        @if($enrollment->progress_percentage == 100)
                                            <a href="{{ route('student.certificate.download', $enrollment->course) }}" class="block text-center w-full py-2.5 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-xl hover:bg-yellow-500 hover:text-white transition border border-yellow-200">
                                                🏆 Download Sertifikat
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- === KOLOM KANAN (SIDEBAR STATS - Span 4) === --}}
            <div class="lg:col-span-4 space-y-6">
                
            {{-- Profile Card Mini (Desain Baru) --}}
            <div class="relative rounded-3xl overflow-hidden shadow-xl transform transition hover:-translate-y-1 h-fit p-2">
                {{-- Background Full Gradient --}}
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-purple-800"></div>
                
                {{-- Dekorasi --}}
                <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-indigo-400 opacity-20 rounded-full blur-xl -ml-10 -mb-10"></div>

                <div class="relative z-10 p-8 text-center">
                    {{-- Avatar dengan Border Tebal --}}
                    <div class="w-24 h-24 mx-auto bg-white p-1 rounded-full shadow-lg mb-4 relative">
                        <div class="w-full h-full bg-indigo-50 rounded-full flex items-center justify-center text-3xl font-black text-indigo-600 border-2 border-indigo-100">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        {{-- Badge Status --}}
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-400 border-4 border-indigo-600 rounded-full"></div>
                    </div>

                    <h3 class="text-xl font-extrabold text-white tracking-tight">{{ Auth::user()->name }}</h3>
                    <p class="text-indigo-200 text-sm font-medium mb-6">Student Account</p>
                    
                    {{-- Statistik dengan Efek Glassmorphism --}}
                    <div class="grid grid-cols-2 gap-px bg-white/10 rounded-2xl overflow-hidden backdrop-blur-sm border border-white/10">
                        <div class="p-4 hover:bg-white/5 transition">
                            <span class="block text-2xl font-black text-white">{{ $enrollments->count() }}</span>
                            <span class="text-indigo-200 text-[10px] uppercase font-bold tracking-wider">Courses</span>
                        </div>
                        <div class="p-4 hover:bg-white/5 transition relative">
                            <div class="absolute left-0 top-3 bottom-3 w-px bg-white/20"></div> {{-- Divider --}}
                            <span class="block text-2xl font-black text-white">{{ $enrollments->where('status', 'completed')->count() }}</span>
                            <span class="text-indigo-200 text-[10px] uppercase font-bold tracking-wider">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Achievement Banner (Versi Real Tracking) --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 p-6 rounded-3xl text-white shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    
                    @php
                        // Hitung Kursus yang Selesai (Status 'completed')
                        $completedCount = $enrollments->where('status', 'completed')->count();
                        // Target Achievement (Misal: Selesaikan 5 Kursus)
                        $target = 5;
                        // Hitung Persentase (Max 100%)
                        $achievementProgress = min(($completedCount / $target) * 100, 100);
                    @endphp

                    <div class="flex items-start justify-between mb-4 relative z-10">
                        <div>
                            <p class="text-[10px] font-bold text-yellow-400 uppercase tracking-wider mb-1">Misi Pelajar</p>
                            <h4 class="font-bold text-lg">
                                @if($completedCount >= $target)
                                    Legendary Learner! 👑
                                @else
                                    Selesaikan {{ $target }} Kursus! 🔥
                                @endif
                            </h4>
                        </div>
                        <div class="text-3xl grayscale opacity-80">
                            {{ $completedCount >= $target ? '👑' : '🏆' }}
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-400 leading-relaxed mb-4 relative z-10">
                        Kamu sudah menyelesaikan <span class="text-white font-bold">{{ $completedCount }}</span> dari <span class="text-white font-bold">{{ $target }}</span> target kursus. 
                        @if($completedCount < $target)
                            Ayo sedikit lagi!
                        @else
                            Luar biasa!
                        @endif
                    </p>

                    {{-- Progress Bar Dinamis --}}
                    <div class="w-full bg-gray-700 rounded-full h-2 relative">
                        <div class="bg-yellow-400 h-2 rounded-full shadow-[0_0_10px_rgba(250,204,21,0.5)] transition-all duration-1000 ease-out" 
                             style="width: {{ $achievementProgress > 5 ? $achievementProgress : 5 }}%"></div>
                    </div>
                    <p class="text-xs text-right mt-2 text-gray-500">{{ round($achievementProgress) }}% Tercapai</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>