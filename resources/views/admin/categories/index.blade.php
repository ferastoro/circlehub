<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori Course') }}
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
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    @php
                        // Cek apakah ada request untuk EDIT
                        $isEdit = request()->has('edit_id');
                        $editCategory = null;
                        if ($isEdit) {
                            $editCategory = $categories->where('id', request('edit_id'))->first();
                        }
                    @endphp

                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        {{ $isEdit ? 'Edit Kategori: ' . $editCategory->name : 'Tambah Kategori Baru' }}
                    </h3>

                    <form method="POST" action="{{ $isEdit ? route('admin.categories.update', $editCategory) : route('admin.categories.store') }}">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" :value="__('Nama Kategori')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $editCategory->name ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if($isEdit)
                                <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal Edit</a>
                            @endif
                            <x-primary-button>
                                {{ $isEdit ? 'Update Kategori' : 'Simpan Kategori' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>


                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Kategori Tersedia</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Slug</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($categories as $category)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $category->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $category->slug }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center space-x-2">
                                            {{-- TOMBOL EDIT --}}
                                            <a href="{{ route('admin.categories.index', ['edit_id' => $category->id]) }}" class="w-6 h-6 transform hover:text-purple-500 hover:scale-110" title="Edit Kategori">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            
                                            {{-- TOMBOL HAPUS --}}
                                            <button type="button" class="w-6 h-6 transform hover:text-red-500 hover:scale-110" onclick="if(confirm('Yakin ingin menghapus kategori {{ $category->name }}?')) { document.getElementById('delete-form-{{ $category->id }}').submit(); }" title="Hapus Kategori">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10H4M3 6h18"></path></svg>
                                            </button>

                                            <form id="delete-form-{{ $category->id }}" method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: none;">
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
                        {{ $categories->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>