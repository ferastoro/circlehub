<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700">My Learning Dashboard</h2>

    {{-- 🔥 TAMBAHKAN BAGIAN INI UNTUK MENAMPILKAN ERROR/SUKSES --}}
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm" role="alert">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-sm" role="alert">
            <span class="font-bold">Gagal:</span> {{ session('error') }}
        </div>
    @endif
    {{-- 🔥 BATAS TAMBAHAN --}}
    
    <div class="grid gap-6 mb-8">
        @forelse ($enrollments as $enrollment)
        <div class="flex flex-col bg-white rounded-lg shadow-sm border border-gray-100 md:flex-row overflow-hidden">
            <div class="h-2 md:h-auto md:w-2 bg-indigo-500"></div>
            <div class="p-6 flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 hover:text-indigo-600 transition">
                            <a href="{{ route('course.show', $enrollment->course->slug) }}">{{ $enrollment->course->title }}</a>
                        </h4>
                        <p class="text-sm text-gray-600 mt-1">Mentor: {{ $enrollment->course->teacher->name }}</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="px-2 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full mb-2">{{ $enrollment->course->category->name }}</span>
                        
                        {{-- Status Selesai --}}
                        @if($enrollment->progress_percentage == 100)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold text-green-700 bg-green-100">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Completed
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-gray-500">Progress</span>
                        <span class="text-xs font-bold text-indigo-600">{{ $enrollment->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $enrollment->progress_percentage }}%"></div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    @php $firstLesson = $enrollment->course->contents()->orderBy('order_sequence')->first(); @endphp
                    
                    {{-- Tombol Lanjut Belajar (Jika belum 100%) --}}
                    @if($firstLesson && $enrollment->progress_percentage < 100)
                        <a href="{{ route('student.lesson.show', [$enrollment->course, $firstLesson]) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            Continue Learning &rarr;
                        </a>
                    @elseif($firstLesson && $enrollment->progress_percentage == 100)
                         <a href="{{ route('student.lesson.show', [$enrollment->course, $firstLesson]) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            Review Materi
                        </a>
                    @endif

                    {{-- 🔥 TOMBOL DOWNLOAD SERTIFIKAT (Hanya jika 100%) --}}
                    @if($enrollment->progress_percentage == 100)
                        <a href="{{ route('student.certificate.download', $enrollment->course) }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 shadow-sm transition transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Sertifikat
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center bg-white rounded-lg shadow-xs">
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kursus</h3>
            <div class="mt-6">
                <a href="{{ route('catalog') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Browse Catalog</a>
            </div>
        </div>
        @endforelse
    </div>
    
    <div class="mt-4">{{ $enrollments->links() }}</div>
</x-app-layout>