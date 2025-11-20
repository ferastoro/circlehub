<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ Auth::user()->hasRole('admin') ? 'Semua' : 'Course Saya' }}</h3>
                    <a href="{{ route(Auth::user()->role . '.courses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Tambah Course
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Course</th>
                                <th class="py-3 px-6 text-left">Category</th>
                                <th class="py-3 px-6 text-left">Teacher</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($courses as $course)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <span class="font-medium">{{ $course->title }}</span>
                                    <div class="text-xs text-gray-500">{{ $course->start_date }} - {{ $course->end_date }}</div>
                                </td>
                                <td class="py-3 px-6 text-left">{{ $course->category->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $course->teacher->name }}</td>
                                <td class="py-3 px-6 text-center">
                                    <span class="{{ $course->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} py-1 px-3 rounded-full text-xs">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        {{-- TOMBOL MANAGE CONTENT --}}
                                        <a href="{{ route(Auth::user()->role . '.courses.contents.index', $course) }}" class="w-6 h-6 transform hover:text-indigo-500 hover:scale-110" title="Manage Content">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </a>

                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route(Auth::user()->role . '.courses.edit', $course) }}" class="w-6 h-6 transform hover:text-purple-500 hover:scale-110" title="Edit Course">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        {{-- TOMBOL HAPUS --}}
                                        <button type="button" class="w-6 h-6 transform hover:text-red-500 hover:scale-110" onclick="if(confirm('Yakin ingin menghapus course {{ $course->title }}?')) { document.getElementById('delete-form-{{ $course->id }}').submit(); }" title="Hapus Course">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10H4M3 6h18"></path></svg>
                                        </button>

                                        {{-- FORM TERSEMBUNYI UNTUK DELETE --}}
                                        <form id="delete-form-{{ $course->id }}" method="POST" action="{{ route(Auth::user()->role . '.courses.destroy', $course) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $courses->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>