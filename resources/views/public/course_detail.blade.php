<x-public-layout>
    <div class="bg-gray-50 min-h-screen">
        @include('layouts.public_nav') 

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('catalog') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">&larr; Kembali ke Catalog</a>

            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: Deskripsi dan Konten --}}
                    <div class="lg:col-span-2">
                        <span class="text-sm font-semibold text-indigo-600 uppercase">{{ $course->category->name }}</span>
                        <h1 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $course->title }}</h1>
                        <p class="text-gray-500 mt-1">Oleh: <span class="font-semibold text-gray-800">{{ $course->teacher->name }}</span></p>

                        <div class="mt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Deskripsi Course</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
                        </div>

                        {{-- Daftar Isi / Konten Pelajaran --}}
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Isi Materi ({{ $course->contents->count() }} Pelajaran)</h3>
                            
                            <div class="space-y-3">
                                @forelse ($course->contents->sortBy('order_sequence') as $content)
                                    <div class="p-4 bg-gray-100 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <span class="font-semibold text-indigo-600">{{ $content->order_sequence }}.</span>
                                            <p class="text-gray-800">{{ $content->title }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $isEnrolled ? 'Akses' : 'Preview' }}</span>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Materi belum tersedia.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- ... (Setelah daftar materi) ... --}}

                <hr class="my-10 border-gray-200">

                {{-- === FORUM DISKUSI === --}}
                <div class="mt-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Forum Diskusi Kelas</h3>

                    {{-- Form Pertanyaan Baru (Hanya muncul jika Enrolled atau Teacher) --}}
                    @auth
                        @if($isEnrolled || $isTeacher || Auth::user()->hasRole('admin'))
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 mb-8">
                                <h4 class="text-lg font-semibold text-gray-800 mb-3">Punya Pertanyaan?</h4>
                                <form action="{{ route('forum.store', $course) }}" method="POST">
                                    @csrf
                                    <textarea name="body" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Tulis pertanyaan atau diskusi Anda di sini..." required></textarea>
                                    <div class="mt-3 text-right">
                                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition">
                                            Kirim Pertanyaan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                                <p class="text-sm text-yellow-700">Anda harus terdaftar di kelas ini untuk bergabung dalam diskusi.</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 p-4 rounded-xl mb-8 text-center">
                            <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Login</a> untuk melihat dan berpartisipasi dalam diskusi.
                        </div>
                    @endauth

                    {{-- Daftar Diskusi --}}
                    <div class="space-y-8">
                        @forelse ($course->forumPosts as $post)
                            <div class="flex space-x-4">
                                {{-- Avatar --}}
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                </div>
                                
                                <div class="flex-grow">
                                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="font-bold text-gray-900">{{ $post->user->name }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{ $post->created_at->diffForHumans() }}</span>
                                                @if($post->user->role == 'teacher')
                                                    <span class="bg-purple-100 text-purple-700 text-xs px-2 py-0.5 rounded-full ml-2">Pengajar</span>
                                                @endif
                                            </div>
                                            {{-- Hapus Tombol --}}
                                            @if(Auth::id() === $post->user_id || $isTeacher)
                                                <form action="{{ route('forum.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus diskusi ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-500 text-xs">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                        <p class="text-gray-700 mt-2 text-sm leading-relaxed">{{ $post->body }}</p>
                                    </div>

                                    {{-- Balasan / Replies --}}
                                    <div class="ml-4 mt-4 space-y-4 border-l-2 border-gray-100 pl-4">
                                        @foreach ($post->replies as $reply)
                                            <div class="flex space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-bold">
                                                        {{ substr($reply->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded-xl flex-grow">
                                                    <div class="flex justify-between">
                                                        <span class="font-bold text-gray-800 text-sm">{{ $reply->user->name }}</span>
                                                        <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-gray-600 text-sm mt-1">{{ $reply->body }}</p>
                                                </div>
                                            </div>
                                        @endforeach

                                        {{-- Form Reply (Menggunakan AlpineJS untuk Toggle) --}}
                                        @auth
                                            @if($isEnrolled || $isTeacher || Auth::user()->hasRole('admin'))
                                                <div x-data="{ open: false }" class="mt-2">
                                                    <button @click="open = !open" class="text-sm text-indigo-600 font-semibold hover:underline">
                                                        Balas
                                                    </button>
                                                    <div x-show="open" class="mt-2">
                                                        <form action="{{ route('forum.store', $course) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="parent_id" value="{{ $post->id }}">
                                                            <textarea name="body" rows="2" class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tulis balasan..." required></textarea>
                                                            <button type="submit" class="mt-2 px-4 py-1.5 bg-gray-800 text-white text-xs font-bold rounded hover:bg-gray-900">Kirim Balasan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                Belum ada diskusi. Jadilah yang pertama bertanya!
                            </div>
                        @endforelse
                    </div>
                </div>

                    {{-- KOLOM KANAN: Sidebar Aksi --}}
                    <div class="lg:col-span-1 border-l pl-8 border-gray-200">
                        <div class="sticky top-10">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Course</h3>
                            
                            <div class="mb-6 pb-6 border-b border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">Pengajar</p>
                                <p class="font-bold text-gray-900">{{ $course->teacher->name }}</p>
                                
                                {{-- 🔥 PERBAIKAN: Tombol Hubungi Teacher --}}
                                <a href="mailto:{{ $course->teacher->email }}?subject=Tanya tentang course {{ $course->title }}" 
                                class="inline-flex items-center mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Hubungi Teacher
                                </a>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Tanggal Mulai: <span class="font-medium">{{ $course->start_date }}</span></p>
                            <p class="text-sm text-gray-600 mb-4">Tanggal Selesai: <span class="font-medium">{{ $course->end_date }}</span></p>

                            {{-- TOMBOL AKSI UTAMA (Enrollment Logic) --}}
                            @auth
                                @if(Auth::user()->hasRole('student'))
                                    @if($isEnrolled)
                                      <a href="{{ $firstLesson ? route('student.lesson.show', [$course, $firstLesson]) : '#' }}" 
                                        class="w-full block text-center px-4 py-3 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition {{ $firstLesson ? '' : 'opacity-50 cursor-not-allowed' }}">
                                            Lanjutkan Kursus &rarr; 
                                        </a>
                                        <p class="text-xs text-gray-500 mt-2">Progress: 0% Selesai</p>                                    @else
                                        {{-- Tombol untuk Enrollment --}}
                                        <form method="POST" action="{{ route('enroll.store', $course) }}">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition">
                                                Ikuti Course Ini
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <p class="text-sm text-orange-600 font-medium">Anda login sebagai {{ ucfirst(Auth::user()->role) }}</p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full block text-center px-4 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition">
                                    Login untuk Mengikuti Course
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</x-public-layout>