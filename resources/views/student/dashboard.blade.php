<x-app-layout>
    <div class="pb-6">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Belajar</h2>
                <p class="text-gray-500">Selamat datang kembali, {{ Auth::user()->name }}! Siap lanjut belajar?</p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-sm text-gray-500">Tanggal Hari Ini</p>
                <p class="font-bold text-gray-800">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- === KOLOM KIRI (MAIN CONTENT) === --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Hero Card: Course Terakhir Diakses (Ambil course pertama dari list) --}}
                @if($enrollments->count() > 0)
                    @php $lastCourse = $enrollments->first(); @endphp
                    <div class="relative bg-indigo-600 rounded-3xl p-8 text-white overflow-hidden shadow-xl group">
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-40 h-40 bg-purple-500 opacity-20 rounded-full blur-2xl"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold border border-white/10">
                                    Lanjutkan Belajar
                                </span>
                                <span class="px-3 py-1 bg-purple-500/30 backdrop-blur-md rounded-full text-xs font-bold border border-purple-400/20">
                                    {{ $lastCourse->course->category->name }}
                                </span>
                            </div>
                            
                            <h3 class="text-3xl font-extrabold mb-2 leading-tight">{{ $lastCourse->course->title }}</h3>
                            <p class="text-indigo-100 mb-6 max-w-lg text-sm opacity-90 line-clamp-2">{{ $lastCourse->course->description }}</p>
                            
                            <div class="flex items-center justify-between bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                                <div class="w-full mr-4">
                                    <div class="flex justify-between mb-2 text-xs font-semibold text-indigo-100">
                                        <span>Progress</span>
                                        <span>{{ $lastCourse->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-black/20 rounded-full h-2">
                                        <div class="bg-white h-2 rounded-full transition-all duration-1000" style="width: {{ $lastCourse->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                <a href="{{ route('course.show', $lastCourse->course->slug) }}" class="shrink-0 bg-white text-indigo-600 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-50 transition shadow-lg">
                                    Lanjut &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-8 text-center border border-dashed border-gray-300">
                        <p class="text-gray-500 mb-4">Belum ada kursus yang diambil.</p>
                        <a href="{{ route('catalog') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700">Cari Kursus</a>
                    </div>
                @endif

                {{-- My Courses List --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-2 h-6 bg-indigo-500 rounded-full mr-3"></span>
                        Kursus Lainnya
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach($enrollments->skip(1) as $enrollment)
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                                        📚
                                    </div>
                                    @if($enrollment->progress_percentage == 100)
                                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">Selesai</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1 line-clamp-1 group-hover:text-indigo-600 transition">{{ $enrollment->course->title }}</h4>
                                <p class="text-xs text-gray-500 mb-4">{{ $enrollment->course->teacher->name }}</p>
                                
                                <div class="w-full bg-gray-100 rounded-full h-1.5 mb-4">
                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                                
                                <a href="{{ route('course.show', $enrollment->course->slug) }}" class="block text-center w-full py-2 text-sm font-bold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        @endforeach
                        
                        @if($enrollments->count() <= 1)
                            <div class="col-span-2 py-8 text-center text-sm text-gray-400 italic bg-gray-50 rounded-2xl border border-gray-100">
                                Tidak ada kursus lain.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- === KOLOM KANAN (SIDEBAR STATS) === --}}
            <div class="space-y-8">
                
                {{-- Profile Card Mini --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full p-1 mb-4">
                        <div class="w-full h-full bg-white rounded-full flex items-center justify-center text-2xl font-bold text-indigo-600">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-500 mb-4">Student</p>
                    <div class="flex justify-center space-x-4 text-sm">
                        <div class="text-center">
                            <span class="block font-bold text-gray-800 text-lg">{{ $enrollments->count() }}</span>
                            <span class="text-gray-400 text-xs">Courses</span>
                        </div>
                        <div class="w-px bg-gray-200"></div>
                        <div class="text-center">
                            <span class="block font-bold text-gray-800 text-lg">{{ $enrollments->where('status', 'completed')->count() }}</span>
                            <span class="text-gray-400 text-xs">Selesai</span>
                        </div>
                    </div>
                </div>

                {{-- Achievement / Badge (Hiasan) --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 p-6 rounded-3xl text-white shadow-lg">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Achievement</p>
                            <h4 class="font-bold text-lg">Rajin Belajar 🚀</h4>
                        </div>
                        <div class="text-3xl">🏆</div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Terus selesaikan materi untuk membuka sertifikat baru. Kamu sudah berada di jalan yang tepat!
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>