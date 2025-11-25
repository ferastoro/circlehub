<x-app-layout>
    <div class="pb-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Pengajar</h2>
                <p class="text-gray-500">Kelola kelas dan pantau perkembangan siswamu.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('teacher.courses.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Kursus
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- === KOLOM KIRI (STATISTIK) === --}}
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 h-min">
                
                {{-- Stat Card 1 --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl">
                            📚
                        </div>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">Total</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Kursus Saya</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ \App\Models\Course::where('teacher_id', Auth::id())->count() }}</h3>
                </div>

                {{-- Stat Card 2 --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-12 w-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">
                            👥
                        </div>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">Total</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Siswa Terdaftar</p>
                    {{-- Menghitung total enrollment di course milik teacher --}}
                    <h3 class="text-3xl font-black text-gray-800">
                        {{ \App\Models\Enrollment::whereHas('course', function($q){ $q->where('teacher_id', Auth::id()); })->count() }}
                    </h3>
                </div>

                {{-- Banner Info --}}
                <div class="col-span-1 sm:col-span-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-2">Butuh Bantuan Mengajar?</h3>
                        <p class="text-indigo-100 text-sm mb-6 max-w-md">
                            Pastikan materi yang Anda upload memiliki kualitas audio dan video yang baik agar siswa nyaman belajar.
                        </p>
                        <a href="#" class="px-5 py-2 bg-white text-indigo-600 text-sm font-bold rounded-xl hover:bg-indigo-50 transition">
                            Panduan Pengajar
                        </a>
                    </div>
                </div>

            </div>

            {{-- === KOLOM KANAN (QUICK ACCESS) === --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm h-min">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Kursus Terbaru</h3>
                
                <div class="space-y-4">
                    @foreach(\App\Models\Course::where('teacher_id', Auth::id())->latest()->take(4)->get() as $course)
                        <div class="flex items-center p-3 bg-gray-50 rounded-2xl hover:bg-indigo-50 transition cursor-pointer group">
                            <div class="h-12 w-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-xl shrink-0 shadow-sm group-hover:scale-105 transition">
                                💻
                            </div>
                            <div class="ml-4 overflow-hidden">
                                <h4 class="font-bold text-gray-800 text-sm truncate group-hover:text-indigo-600 transition">{{ $course->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $course->category->name }}</p>
                            </div>
                        </div>
                    @endforeach
                    
                    <a href="{{ route('teacher.courses.index') }}" class="block text-center w-full py-3 text-sm font-bold text-gray-500 hover:text-indigo-600 border border-dashed border-gray-300 rounded-xl hover:border-indigo-300 transition mt-4">
                        Lihat Semua Kursus
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>