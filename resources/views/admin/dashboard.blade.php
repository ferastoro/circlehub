<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm uppercase tracking-widest text-indigo-500 font-semibold">Control Center</p>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">{{ __('Admin Dashboard') }}</h2>
                <p class="text-sm text-gray-500">Ringkasan cepat performa platform dan aksi penting.</p>
            </div>
            <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ now()->format('d M Y') }}</span>
        </div>
    </x-slot>

    @php
        use App\Models\User;
        use App\Models\Category;
        use App\Models\Course;

        $totalUsers = User::count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalCategories = Category::count();
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 'active')->count();
        $newestUsers = User::latest()->take(5)->get();
    @endphp

    <div class="py-10 bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="p-6 bg-white rounded-2xl shadow-sm border border-indigo-50">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Pengguna</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</h3>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">👥</span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm text-gray-600">
                        <div class="p-3 bg-indigo-50 rounded-xl">
                            <p class="text-xs text-indigo-700 font-semibold">Teacher</p>
                            <p class="text-lg font-bold text-indigo-900">{{ $totalTeachers }}</p>
                        </div>
                        <div class="p-3 bg-sky-50 rounded-xl">
                            <p class="text-xs text-sky-700 font-semibold">Student</p>
                            <p class="text-lg font-bold text-sky-900">{{ $totalStudents }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-sm text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-indigo-100">Course &amp; Category</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $totalCourses }} Course</h3>
                            <p class="text-sm text-indigo-100">{{ $totalCategories }} kategori tersedia</p>
                        </div>
                        <div class="text-4xl">📚</div>
                    </div>
                    <div class="mt-5 flex items-center gap-4">
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-wide text-indigo-100">Course Aktif</p>
                            <div class="h-2 rounded-full bg-indigo-200 overflow-hidden">
                                <div class="h-2 bg-white/80 rounded-full" style="width: {{ $totalCourses ? ($activeCourses / max($totalCourses, 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <span class="text-lg font-semibold">{{ $activeCourses }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400">Shortcut</p>
                            <h3 class="text-lg font-bold text-gray-900">Akses Cepat Modul</h3>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span> Online
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="group p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:shadow-lg transition-all duration-200 bg-gradient-to-br from-white to-indigo-50/50">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-800">Manajemen Pengguna</p>
                                <span class="text-2xl">🛠️</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Kelola Admin, Teacher, dan Student.</p>
                            <span class="mt-3 inline-flex items-center text-xs font-semibold text-indigo-600">Buka Modul →</span>
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="group p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:shadow-lg transition-all duration-200 bg-gradient-to-br from-white to-purple-50/60">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-800">Manajemen Kategori</p>
                                <span class="text-2xl">🏷️</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Tambah atau edit kategori course.</p>
                            <span class="mt-3 inline-flex items-center text-xs font-semibold text-indigo-600">Atur Kategori →</span>
                        </a>

                        <a href="{{ route('admin.courses.index') }}" class="group p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:shadow-lg transition-all duration-200 bg-gradient-to-br from-white to-sky-50/60">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-800">Kelola Course</p>
                                <span class="text-2xl">📘</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Review seluruh course &amp; konten.</p>
                            <span class="mt-3 inline-flex items-center text-xs font-semibold text-indigo-600">Kelola Course →</span>
                        </a>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Pengguna Terbaru</h3>
                        <span class="text-xs text-gray-500">{{ now()->format('H:i') }}</span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($newestUsers as $user)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($user->status ?? 'pending') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
