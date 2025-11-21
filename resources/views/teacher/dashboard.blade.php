<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm uppercase tracking-widest text-indigo-500 font-semibold">Welcome back</p>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">{{ __('Teacher Dashboard') }}</h2>
                <p class="text-sm text-gray-500">Kelola course, pantau murid, dan rancang materi terbaikmu.</p>
            </div>
            <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ now()->format('d M Y') }}</span>
        </div>
    </x-slot>

    @php
        use Illuminate\Support\Str;
    @endphp

    <div class="py-10 bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-indigo-50">
                    <p class="text-xs text-gray-500">Course Saya</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalCourses }}</h3>
                        <span class="text-lg">📚</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-emerald-50">
                    <p class="text-xs text-gray-500">Course Aktif</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold text-emerald-700">{{ $activeCourses }}</h3>
                        <span class="text-lg">🚀</span>
                    </div>
                    <p class="text-xs text-emerald-700 mt-1">Pastikan materi selalu up to date.</p>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-sky-50">
                    <p class="text-xs text-gray-500">Total Siswa</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold text-sky-700">{{ $totalStudents }}</h3>
                        <span class="text-lg">👥</span>
                    </div>
                </div>
                <div class="p-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-sm text-white">
                    <p class="text-xs text-indigo-100">Total Materi</p>
                    <div class="flex items-end justify-between mt-1">
                        <h3 class="text-3xl font-bold">{{ $totalLessons }}</h3>
                        <span class="text-lg">📝</span>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-white/30 overflow-hidden">
                        <div class="h-2 bg-white rounded-full" style="width: {{ $totalCourses ? min(100, ($totalLessons / ($totalCourses * 5)) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="px-6 pt-6 pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Course Terbaru</h3>
                        <p class="text-sm text-gray-500">Tinjau performa dan akses cepat ke konten.</p>
                    </div>
                    <a href="{{ route('teacher.courses.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Kelola Course →</a>
                </div>
                <div class="px-6 pb-6 space-y-4">
                    @forelse ($courses as $course)
                        <div class="p-4 border rounded-xl shadow-sm bg-gradient-to-br from-white to-indigo-50/40">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">{{ $course->category->name ?? 'Tanpa Kategori' }}</p>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">{{ $course->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($course->description, 120) }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs rounded-full {{ $course->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($course->status) }}</span>
                            </div>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">{{ $course->enrollments_count }}</span>
                                    <span>Murid terdaftar</span>
                                </div>
                                <a href="{{ route('teacher.courses.edit', $course) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Kelola Konten</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            Belum ada course yang dipublikasikan. <a href="{{ route('teacher.courses.create') }}" class="text-indigo-600 font-medium hover:text-indigo-800">Buat Course Baru</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
