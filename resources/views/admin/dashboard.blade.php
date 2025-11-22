<x-app-layout>
    {{-- Wrapper Konten Utama --}}
    <div class="py-6">
        
        {{-- Welcome Banner --}}
        <div class="relative bg-indigo-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-xl z-0">
            {{-- Dekorasi Background --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-40 h-40 bg-purple-500 opacity-20 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10 text-white">
                <h2 class="text-3xl font-extrabold mb-2">Halo, Admin {{ Auth::user()->name }}! 👋</h2>
                <p class="text-indigo-100 max-w-2xl">
                    Kelola seluruh ekosistem CircleHub dari sini. Pantau pertumbuhan pengguna, kelola kursus, dan pastikan platform berjalan lancar.
                </p>
            </div>
        </div>

        {{-- Statistik Cards (Grid) --}}
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 z-0 relative">
            <div class="flex items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <div class="p-4 mr-4 text-indigo-600 bg-indigo-50 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                </div>
            </div>

            <div class="flex items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <div class="p-4 mr-4 text-purple-600 bg-purple-50 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Kursus Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Course::count() }}</p>
                </div>
            </div>

            <div class="flex items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <div class="p-4 mr-4 text-pink-600 bg-pink-50 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Kategori</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        <h3 class="mb-4 text-xl font-bold text-gray-800">Aksi Cepat</h3>
        <div class="grid gap-6 md:grid-cols-2 z-0 relative">
            <a href="{{ route('admin.users.create') }}" class="group relative flex items-center justify-between p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-indigo-100 transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600">Tambah User Baru</h4>
                        <p class="text-sm text-gray-500">Daftarkan guru atau siswa manual</p>
                    </div>
                </div>
                <span class="text-gray-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            </a>

            <a href="{{ route('admin.courses.create') }}" class="group relative flex items-center justify-between p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-100 transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-purple-600">Buat Kursus Baru</h4>
                        <p class="text-sm text-gray-500">Tambahkan materi pembelajaran</p>
                    </div>
                </div>
                <span class="text-gray-300 group-hover:text-purple-600 group-hover:translate-x-1 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            </a>
        </div>
    </div>
</x-app-layout>