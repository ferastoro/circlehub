<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-xl font-bold text-gray-800 mb-6">Course yang Anda Ikuti</h3>

                <div class="space-y-6">
                    @forelse ($enrollments as $enrollment)
                    <div class="p-4 border rounded-lg shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center bg-gray-50">
                        
                        <div class="flex-grow">
                            <h4 class="text-lg font-bold text-indigo-700">{{ $enrollment->course->title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">Oleh: {{ $enrollment->course->teacher->name }}</p>
                            <p class="text-xs text-gray-500">{{ $enrollment->course->category->name }}</p>
                        </div>

                        <div class="mt-3 md:mt-0 md:ms-4 w-full md:w-1/3">
                            <p class="text-xs font-semibold mb-1">
                                Progress: {{ $enrollment->progress_percentage }}%
                                @if($enrollment->status == 'completed')
                                    <span class="text-green-600">(Selesai)</span>
                                @endif
                            </p>
                            
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                            </div>
                            
                            {{-- Tombol Lanjutkan Course --}}
                            <div class="mt-3 text-right">
                                @php
                                    $firstLesson = $enrollment->course->contents()->orderBy('order_sequence')->first();
                                @endphp

                                @if ($firstLesson)
                                    <a href="{{ route('student.lesson.show', [$enrollment->course, $firstLesson]) }}" class="text-sm bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-3 rounded">
                                        {{ $enrollment->progress_percentage == 100 ? 'Lihat Ulang' : 'Lanjutkan Belajar' }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-500">Menunggu Materi</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        Anda belum terdaftar di course manapun. <a href="{{ route('catalog') }}" class="text-indigo-600 font-medium hover:text-indigo-800">Lihat Course Catalog</a>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>