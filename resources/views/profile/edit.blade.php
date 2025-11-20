<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (Auth::user()->hasRole('student'))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-6">
                    @include('profile.partials.student-course-list')
                </div>
            @elseif (Auth::user()->hasRole('teacher'))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-6">
                    @include('profile.partials.teacher-course-list')
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
