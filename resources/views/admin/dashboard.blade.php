<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Akses Cepat Modul CMS</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('admin.users.index') }}" class="block p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-150">
                    <h4 class="text-xl font-bold text-gray-900">👥 User Management</h4>
                    <p class="mt-2 text-sm text-gray-600">Kelola Admin, Teacher, dan Student.</p>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="block p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-150 opacity-70 cursor-not-allowed">
                    <h4 class="text-xl font-bold text-gray-900">🏷️ Category Management</h4>
                    <p class="mt-2 text-sm text-gray-600">Tambah/Edit Kategori Course.</p>
                </a>
                
                <div class="p-6 bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                    <h4 class="text-xl font-bold text-gray-900">📈 Total Users</h4>
                    <p class="mt-2 text-3xl font-extrabold text-indigo-600">
                        {{ \App\Models\User::count() }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>