<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase text-indigo-500 font-semibold">Halo, {{ Auth::user()->name }}</p>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">{{ __('Dashboard Saya') }}</h2>
                <p class="text-sm text-gray-500">Pantau progres belajar dan lanjutkan course favoritmu.</p>
            </div>
            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Member Aktif</span>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-indigo-50">
                    <p class="text-xs text-gray-500">Course Diikuti</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalEnrollments }}</h3>
                        <span class="text-lg">📚</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-emerald-50">
                    <p class="text-xs text-gray-500">Course Selesai</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold text-emerald-700">{{ $completedEnrollments }}</h3>
                        <span class="text-lg">✅</span>
                    </div>
                    <p class="text-xs text-emerald-700 mt-1">Terus lanjutkan progresmu!</p>
                </div>
                <div class="p-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-sm text-white">
                    <p class="text-xs text-indigo-100">Rata-rata Progres</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold">{{ number_format($averageProgress, 0) }}%</h3>
                        <span class="text-lg">⏳</span>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-white/30 overflow-hidden">
                        <div class="h-2 bg-white rounded-full" style="width: {{ $averageProgress }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="px-6 pt-6 pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Course yang Anda Ikuti</h3>
                        <p class="text-sm text-gray-500">Lanjutkan perjalanan belajar dengan sekali klik.</p>
                    </div>
                    <a href="{{ route('catalog') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Cari Course Baru →</a>
                </div>

                <div class="px-6 pb-6 space-y-4">
                    @forelse ($enrollments as $enrollment)
                        <div class="p-4 border rounded-xl shadow-sm bg-gradient-to-br from-white to-indigo-50/40 flex flex-col md:flex-row md:items-center gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ $enrollment->course->category->name }}</span>
                                    <span class="text-xs text-gray-500">Oleh {{ $enrollment->course->teacher->name }}</span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mt-2">{{ $enrollment->course->title }}</h4>
                            </div>

                            <div class="w-full md:w-72">
                                <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                    <span class="text-gray-600">Progress</span>
                                    <span class="text-indigo-700">{{ $enrollment->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                                <div class="mt-3 flex items-center justify-between">
                                    @php
                                        $firstLesson = $enrollment->course->contents()->orderBy('order_sequence')->first();
                                    @endphp

                                    <span class="text-xs {{ $enrollment->status === 'completed' ? 'text-emerald-600' : 'text-gray-500' }}">{{ $enrollment->status === 'completed' ? 'Selesai' : 'Sedang Berjalan' }}</span>

                                    @if ($firstLesson)
                                        <a href="{{ route('student.lesson.show', [$enrollment->course, $firstLesson]) }}" class="text-sm bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg shadow-sm">
                                            {{ $enrollment->progress_percentage == 100 ? 'Lihat Ulang' : 'Lanjutkan' }}
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">Materi belum tersedia</span>
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

                <div class="px-6 pb-6">
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
