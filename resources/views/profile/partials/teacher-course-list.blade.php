<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Course yang Saya Ajarkan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Monitor progres murid dan course yang Anda kelola.
        </p>
    </header>

    <div class="mt-6 space-y-4">
        @forelse ($taughtCourses as $course)
            <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-indigo-700">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600">Total Pelajaran: {{ $course->contents->count() }}</p>
                    </div>
                    <a href="{{ route('teacher.courses.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Kelola Course &rarr;
                    </a>
                </div>
                
                <div class="mt-3 border-t pt-3">
                    <p class="text-sm font-bold text-gray-800 mb-2">
                        Murid Terdaftar: {{ $course->enrollments->count() }}
                    </p>
                    
                    <ul class="text-xs space-y-1">
                        @foreach ($course->enrollments->take(5) as $enrollment)
                            <li>
                                <span class="font-medium text-gray-700">{{ $enrollment->user->name }}</span>
                                - Progress: {{ $enrollment->progress_percentage }}%
                            </li>
                        @endforeach
                        @if($course->enrollments->count() > 5)
                            <li class="text-gray-500">dan {{ $course->enrollments->count() - 5 }} murid lainnya...</li>
                        @endif
                    </ul>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Anda belum mengajarkan course apapun.</p>
        @endforelse
    </div>
</section>