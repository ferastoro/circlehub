<x-app-layout>
    <div class="pb-6">
        <h2 class="my-6 text-2xl font-bold text-gray-800">Kursus Saya 📚</h2>

        <div class="grid gap-6 mb-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
            @forelse ($enrollments as $enrollment)
            <div class="flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 overflow-hidden group">
                
                {{-- Thumbnail (Ambil dari course) --}}
                <div class="h-32 bg-gray-200 relative overflow-hidden">
                    <img src="{{ $enrollment->course->image_path ? asset($enrollment->course->image_path) : 'https://placehold.co/600x400/EEE/31343C?text=Course' }}" 
                         alt="{{ $enrollment->course->title }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-bold text-indigo-600 shadow-sm">
                        {{ $enrollment->progress_percentage }}%
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <span class="text-xs font-bold text-gray-400 uppercase mb-1">{{ $enrollment->course->category->name }}</span>
                    <h4 class="text-lg font-bold text-gray-900 mb-2 leading-snug hover:text-indigo-600 transition">
                        <a href="{{ route('course.show', $enrollment->course->slug) }}">
                            {{ $enrollment->course->title }}
                        </a>
                    </h4>
                    
                    <div class="mt-auto pt-4">
                        {{-- Progress Bar Mini --}}
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-3">
                            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                        </div>
                        
                        @php $firstLesson = $enrollment->course->contents()->orderBy('order_sequence')->first(); @endphp
                        @if($firstLesson)
                            <a href="{{ route('student.lesson.show', [$enrollment->course, $firstLesson]) }}" class="block w-full text-center py-2 px-4 text-xs font-bold text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                                Lanjutkan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada kursus.</p>
                    <a href="{{ route('catalog') }}" class="text-indigo-600 font-bold hover:underline">Cari di Katalog</a>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">{{ $enrollments->links() }}</div>
    </div>
</x-app-layout>