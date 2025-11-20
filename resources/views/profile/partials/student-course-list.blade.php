<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Course yang Saya Ikuti') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Lihat progres dan riwayat course yang pernah Anda ikuti.
        </p>
    </header>

    <div class="mt-6 space-y-4">
        @forelse ($enrollments as $enrollment)
            <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-bold text-indigo-700">{{ $enrollment->course->title }}</h3>
                        <p class="text-xs text-gray-500">Oleh: {{ $enrollment->course->teacher->name }}</p>
                    </div>
                    <a href="{{ route('course.show', $enrollment->course->slug) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Lihat Course &rarr;
                    </a>
                </div>
                
                <div class="mt-3">
                    <p class="text-xs font-semibold mb-1">
                        Progress: {{ $enrollment->progress_percentage }}%
                        <span class="{{ $enrollment->status == 'completed' ? 'text-green-600' : 'text-gray-500' }}">
                            ({{ ucfirst($enrollment->status) }})
                        </span>
                    </p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Anda belum terdaftar di course manapun.</p>
        @endforelse
    </div>
</section>