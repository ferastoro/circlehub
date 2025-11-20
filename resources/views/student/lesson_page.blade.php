<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }} / Materi {{ $content->order_sequence }}: {{ $content->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @elseif (session('error'))
                 <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="prose max-w-none text-gray-800">
                    <h1 class="text-3xl font-bold">{{ $content->title }}</h1>
                    <p class="text-sm text-gray-500 mb-6">Course: {{ $course->title }} | Pengajar: {{ $course->teacher->name }}</p>

                    <div class="mt-4 border-t pt-4">
                        {!! nl2br(e($content->body)) !!} {{-- Menggunakan nl2br untuk line breaks sederhana --}}
                    </div>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-between items-center">
                    
                    <div>
                        {{-- Tombol Mark as Done --}}
                        @if(!$isCompleted)
                        <form method="POST" action="{{ route('student.lesson.mark_done', [$course, $content]) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Tandai Selesai (Mark as Done)
                            </button>
                        </form>
                        @else
                        <span class="text-green-600 font-bold inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Materi Sudah Selesai
                        </span>
                        @endif
                    </div>

                    {{-- Tombol Lanjutkan --}}
                    <div>
                        @if($nextContent)
                            <a href="{{ route('student.lesson.show', [$course, $nextContent]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Lanjutkan &rarr;
                            </a>
                        @else
                            <a href="{{ route('course.show', $course->slug) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali ke Course Detail
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>