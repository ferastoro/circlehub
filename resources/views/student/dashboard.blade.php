<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700">My Learning Dashboard</h2>

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
                    <span class="px-2 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full">{{ $enrollment->course->category->name }}</span>
                </div>

                <div class="mt-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-gray-500">Progress</span>
                        <span class="text-xs font-bold text-indigo-600">{{ $enrollment->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    @php $firstLesson = $enrollment->course->contents()->orderBy('order_sequence')->first(); @endphp
                    @if($firstLesson)
                        <a href="{{ route('student.lesson.show', [$enrollment->course, $firstLesson]) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Continue Learning &rarr;</a>
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