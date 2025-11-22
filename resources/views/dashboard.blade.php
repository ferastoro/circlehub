<x-app-layout>
    <div class="pb-6">
        {{-- Welcome Banner Khusus Teacher --}}
        <div class="relative bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-xl text-white">
            <div class="absolute top-0 left-0 w-full h-full bg-pattern opacity-10"></div> {{-- Bisa tambah pattern --}}
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👨‍🏫</h2>
                    <p class="text-purple-100">Siap membagikan ilmu hari ini? Pantau perkembangan kelas Anda di sini.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-bold rounded-xl shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Kursus
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 mb-8 md:grid-cols-3">
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Kursus Saya</p>
                    <p class="text-3xl font-black text-gray-800">{{ \App\Models\Course::where('teacher_id', Auth::id())->count() }}</p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>

            {{-- Contoh placeholder --}}
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Materi</p>
                    {{-- Menghitung total content dari semua course milik teacher --}}
                    <p class="text-3xl font-black text-gray-800">
                        {{ \App\Models\CourseContent::whereHas('course', function($q){ $q->where('teacher_id', Auth::id()); })->count() }}
                    </p>
                </div>
                <div class="h-12 w-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>

        <h3 class="mb-4 text-xl font-bold text-gray-800">Kelola Kursus Terbaru</h3>
        {{-- Bisa ditambahkan list course terbaru di sini jika diinginkan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <img src="https://illustrations.popsy.co/amber/surr-teaching.svg" alt="Teaching" class="h-40 mx-auto mb-4 opacity-80">
            <p class="text-gray-500">Kelola detail kursus dan materi Anda melalui menu <a href="{{ route('teacher.courses.index') }}" class="text-purple-600 font-bold hover:underline">Course Saya</a>.</p>
        </div>
    </div>
</x-app-layout>