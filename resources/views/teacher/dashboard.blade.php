<x-app-layout>
    <div class="pb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 mt-6 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Dashboard Pengajar</h2>
                <p class="text-gray-500 mt-1">Kelola kelas dan pantau perkembangan siswamu di sini.</p>
            </div>
            <div>
                <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg hover:shadow-indigo-200 transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Kursus Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- === KOLOM KIRI (STATISTIK & BANNER) === --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Grid Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Stat Card 1 --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                                📚
                            </div>
                            <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-md">Total</span>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Kursus Aktif</p>
                        <h3 class="text-4xl font-black text-gray-800 tracking-tight">{{ \App\Models\Course::where('teacher_id', Auth::id())->count() }}</h3>
                    </div>

                    {{-- Stat Card 2 --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                                👥
                            </div>
                            <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-md">Total</span>
                        </div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Siswa Terdaftar</p>
                        <h3 class="text-4xl font-black text-gray-800 tracking-tight">
                            {{ \App\Models\Enrollment::whereHas('course', function($q){ $q->where('teacher_id', Auth::id()); })->count() }}
                        </h3>
                    </div>
                </div>

                {{-- Banner Info Teacher --}}
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Ingin Kursus Lebih Menarik?</h3>
                            <p class="text-indigo-100 text-sm max-w-md leading-relaxed">
                                Tambahkan materi video yang berkualitas dan perbarui konten secara berkala untuk meningkatkan *engagement* siswa Anda.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ route('teacher.courses.index') }}" class="px-6 py-3 bg-white text-indigo-600 text-sm font-bold rounded-xl hover:bg-indigo-50 transition shadow-md">
                                Kelola Materi
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- === KOLOM KANAN (QUICK ACCESS LIST) === --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-lg shadow-gray-100/50 h-fit">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 text-lg">Kursus Terbaru</h3>
                    <a href="{{ route('teacher.courses.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @foreach(\App\Models\Course::where('teacher_id', Auth::id())->latest()->take(4)->get() as $course)
                        <a href="{{ route('teacher.courses.edit', $course) }}" class="flex items-center p-3 bg-gray-50 rounded-2xl hover:bg-indigo-50 transition group border border-transparent hover:border-indigo-100">
                            <div class="h-12 w-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-xl shrink-0 shadow-sm group-hover:scale-105 transition overflow-hidden">
                                @if($course->image_path)
                                    <img src="{{ asset($course->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    💻
                                @endif
                            </div>
                            <div class="ml-4 overflow-hidden flex-1">
                                <h4 class="font-bold text-gray-800 text-sm truncate group-hover:text-indigo-600 transition">{{ $course->title }}</h4>
                                <div class="flex items-center mt-1">
                                    <span class="text-[10px] font-semibold text-gray-500 bg-white px-1.5 py-0.5 rounded border border-gray-200">
                                        {{ $course->category->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-2 text-gray-300 group-hover:text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    @endforeach
                    
                    @if(\App\Models\Course::where('teacher_id', Auth::id())->count() == 0)
                        <div class="text-center py-8 text-gray-400 text-sm">
                            Belum ada kursus dibuat.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>