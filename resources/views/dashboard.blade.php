<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase text-indigo-500 font-semibold">Selamat datang</p>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">{{ __('Dashboard') }}</h2>
                <p class="text-sm text-gray-500">Ringkasan singkat aktivitas akun Anda.</p>
            </div>
            <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ now()->format('d M Y') }}</span>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-8 flex flex-col gap-4 text-gray-900">
                    <div class="flex items-center gap-3">
                        <span class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">✨</span>
                        <div>
                            <h3 class="text-xl font-bold">Akun Siap Digunakan</h3>
                            <p class="text-sm text-gray-500">Terima kasih telah bergabung. Jelajahi fitur sesuai peran Anda.</p>
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3 text-sm text-gray-600">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-white to-indigo-50 border border-indigo-50">
                            <p class="text-xs uppercase text-indigo-500 font-semibold">Profil</p>
                            <p class="mt-1 text-gray-800">Perbarui data pribadi dan keamanan akun.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-white to-purple-50 border border-purple-50">
                            <p class="text-xs uppercase text-purple-500 font-semibold">Dashboard</p>
                            <p class="mt-1 text-gray-800">Akses pintasan sesuai role Anda.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-white to-emerald-50 border border-emerald-50">
                            <p class="text-xs uppercase text-emerald-500 font-semibold">Bantuan</p>
                            <p class="mt-1 text-gray-800">Hubungi admin jika membutuhkan dukungan.</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">Ubah Profil</a>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-indigo-200 text-indigo-700 rounded-lg hover:bg-indigo-50">Lihat Menu Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
