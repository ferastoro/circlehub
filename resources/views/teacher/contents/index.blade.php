<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materi Kursus: ') . $course->title }}
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
                    <h3 class="text-lg font-medium text-gray-900">Daftar Materi</h3>
                    <a href="{{ route(Auth::user()->role . '.courses.contents.create', $course) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Tambah Materi
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Urutan</th>
                                <th class="py-3 px-6 text-left">Judul Materi</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse ($contents as $content)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap font-bold text-gray-800">
                                    {{ $content->order_sequence }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $content->title }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route(Auth::user()->role . '.courses.contents.edit', [$course, $content]) }}" class="w-6 h-6 transform hover:text-purple-500 hover:scale-110" title="Edit Materi">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        {{-- TOMBOL HAPUS --}}
                                        <button type="button" class="w-6 h-6 transform hover:text-red-500 hover:scale-110" onclick="if(confirm('Yakin ingin menghapus materi {{ $content->title }}?')) { document.getElementById('delete-form-{{ $content->id }}').submit(); }" title="Hapus Materi">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10H4M3 6h18"></path></svg>
                                        </button>

                                        {{-- FORM TERSEMBUNYI UNTUK DELETE --}}
                                        <form id="delete-form-{{ $content->id }}" method="POST" action="{{ route(Auth::user()->role . '.courses.contents.destroy', [$course, $content]) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-3 px-6 text-center text-gray-500">
                                    Belum ada materi untuk course ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $contents->links() }}
                </div>
                
                <div class="mt-6 text-right">
                    <a href="{{ route(Auth::user()->role . '.courses.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        &larr; Kembali ke Daftar Course
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>