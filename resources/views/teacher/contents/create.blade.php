<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Materi Baru untuk: ') . $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route(Auth::user()->role . '.courses.contents.store', $course) }}">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Judul Materi')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="body" :value="__('Isi Materi (Teks atau Media)')" />
                        <textarea id="body" name="body" rows="8" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('body') }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="order_sequence" :value="__('Urutan Materi (Angka)')" />
                        <x-text-input id="order_sequence" class="block mt-1 w-full" type="number" name="order_sequence" :value="old('order_sequence')" placeholder="Kosongkan untuk urutan terakhir otomatis" />
                        <x-input-error :messages="$errors->get('order_sequence')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route(Auth::user()->role . '.courses.contents.index', $course) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>
                            {{ __('Simpan Materi') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>