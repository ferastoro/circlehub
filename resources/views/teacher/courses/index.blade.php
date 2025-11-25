<x-app-layout>
    <div class="pb-6">
        <div class="flex justify-between items-center mt-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Kelola Kursus Saya</h2>
            <a href="{{ route('teacher.courses.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-md transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kursus Baru
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-xl border border-green-200 shadow-sm" role="alert">
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 mb-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($courses as $course)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition duration-300 flex flex-col overflow-hidden group">
                
                {{-- Thumbnail Area --}}
                <div class="h-40 bg-gray-100 relative overflow-hidden">
                    <img src="{{ $course->image_path ? asset($course->image_path) : 'https://placehold.co/600x400/EEE/31343C?text=No+Cover' }}" 
                         alt="{{ $course->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm {{ $course->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">{{ $course->category->name }}</span>
                        <span class="text-xs text-gray-400 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ $course->enrollments->count() }} Murid
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 leading-snug">
                        {{ $course->title }}
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">
                        {{ $course->start_date }} — {{ $course->end_date }}
                    </p>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-4 border-t border-gray-100 grid grid-cols-3 gap-2">
                        {{-- Manage Content --}}
                        <a href="{{ route('teacher.courses.contents.index', $course) }}" class="flex flex-col items-center justify-center py-2 rounded-lg hover:bg-indigo-50 text-indigo-600 transition group/btn" title="Kelola Materi">
                            <svg class="w-5 h-5 mb-1 group-hover/btn:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[10px] font-bold">Materi</span>
                        </a>

                        {{-- Edit Course --}}
                        <a href="{{ route('teacher.courses.edit', $course) }}" class="flex flex-col items-center justify-center py-2 rounded-lg hover:bg-yellow-50 text-yellow-600 transition group/btn" title="Edit Info">
                            <svg class="w-5 h-5 mb-1 group-hover/btn:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span class="text-[10px] font-bold">Edit</span>
                        </a>

                        {{-- Delete Course --}}
                        <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="w-full h-full" onsubmit="return confirm('Yakin ingin menghapus kursus ini? Semua materi dan data siswa akan hilang.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full h-full flex flex-col items-center justify-center py-2 rounded-lg hover:bg-red-50 text-red-600 transition group/btn" title="Hapus Kursus">
                                <svg class="w-5 h-5 mb-1 group-hover/btn:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10H4M3 6h18"></path></svg>
                                <span class="text-[10px] font-bold">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    </div>
</x-app-layout>