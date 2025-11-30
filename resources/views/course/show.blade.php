@if($course)
    {{-- 1. LOGIC: Calculate Image URL ONLY ONCE here --}}
    @php
        $videoId = '';
        // Default fallback image
        $thumbnailUrl = asset('images/placeholder-video.jpg'); 
        
        // Check if there is a video and extract thumbnail
        if (isset($course->coursedetails[0]) && preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $course->coursedetails[0]->content, $match)) {
            $videoId = $match[1];
            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"; 
        }
    @endphp

    {{-- 2. SEO SECTION: Pass data to Layout --}}
    @section('title', $course->name)
    @section('meta_description', Str::limit($course->description ?? 'Học khóa học ' . $course->name . ' online.', 155))
    @section('meta_image', $thumbnailUrl) 

    @section('og_title', $course->name)
    @section('og_description', Str::limit($course->description ?? 'Học khóa học ' . $course->name . ' online.', 200))
    @section('og_image', $thumbnailUrl)
    
    {{-- 3. CONTENT: Render the page --}}
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->name }}
            </h2>
        </x-slot>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2">
                                <div class="rounded-xl overflow-hidden shadow-lg mb-6">
                                    {{-- USE THE VARIABLE WE CALCULATED AT TOP --}}
                                    <img src="{{ $thumbnailUrl }}" alt="Video Thumbnail" class="w-full aspect-video object-cover">
                                </div>

                                <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $course->name }}</h1>
                                
                                {{-- ... (Keep your Course Info: Category, Grade, Time) ... --}}
                                <div class="flex items-center mb-4 text-sm text-gray-600">
                                    <div class="flex items-center mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <span>{{ $course->category->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Lớp {{ $course->grade }}</span>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Mô tả khóa học</h2>
                                    <p class="text-gray-600" style="text-align: justify; line-height: 1.5;">
                                        {!! nl2br(e($course->description ?? '')) !!}
                                    </p>
                                </div>

                                {{-- ... (Keep your Course Content/Accordion logic here) ... --}}
                                <div class="mb-8">
                                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Nội dung khóa học</h2>
                                    <div class="space-y-3">
                                        @forelse($course->coursedetails as $index => $detail)
                                            {{-- Calculate logic for Detail Items --}}
                                            @php
                                            $detailVideoId = '';
                                            $detailThumbnailUrl = asset('images/placeholder-video.jpg');
                                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $detail->content ?? '', $match)) {
                                                $detailVideoId = $match[1];
                                                $detailThumbnailUrl = "https://img.youtube.com/vi/{$detailVideoId}/hqdefault.jpg";
                                            }
                                            @endphp
                                            
                                            <div x-data="{ open: false }" class="border border-gray-200 rounded-lg overflow-hidden">
                                                <button @click="open = !open" class="w-full bg-gray-50 px-4 py-3 flex justify-between items-center cursor-pointer hover:bg-gray-100 focus:outline-none">
                                                    <div class="font-medium text-left">{{ $index + 1 }}. {{ $detail->name }}</div>
                                                    <svg :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <div x-show="open" x-collapse class="p-4 bg-white border-t border-gray-200">
                                                    <p class="text-gray-600 text-sm mb-2">{{ $detail->description ?? '' }}</p>
                                                    <div class="rounded-xl overflow-hidden shadow-md mb-2">
                                                        <img src="{{ $detailThumbnailUrl }}" alt="Detail Thumbnail" class="w-full aspect-video object-cover">
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-gray-600">Chưa có nội dung chi tiết.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-1">
                                {{-- ... (Your Price, Buy Buttons, and Includes list) ... --}}
                                <div class="border border-gray-200 rounded-xl shadow-sm p-6 sticky top-4">
                                    <div class="mb-4">
                                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ number_format($course->price) }} VND</div>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span>Truy cập trọn đời</span>
                                        </div>
                                    </div>

                                    @auth
                                        @if(!auth()->user()->courses->contains($course->id))
                                            {{-- Buy Buttons --}}
                                            <form action="{{ route('cart.add', $course) }}" method="POST" class="mb-4">
                                                @csrf
                                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md flex items-center justify-center">
                                                    Thêm vào giỏ hàng
                                                </button>
                                            </form>
                                            <form action="{{ route('cart.buy', $course) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full border border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3 px-4 rounded-lg">Mua ngay</button>
                                            </form>
                                        @else
                                            <a href="{{ route('course.learn', $course->id) }}" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg text-center block">Bắt đầu học</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg text-center block">Đăng nhập để đăng ký</a>
                                    @endauth

                                    <div class="divide-y divide-gray-200 mt-4">
                                        <div class="py-4">
                                            <h3 class="font-medium text-gray-800 mb-2">Khóa học bao gồm:</h3>
                                            {{-- List items --}}
                                            <ul class="space-y-2 text-sm text-gray-600">
                                                <li class="flex items-center"><svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Tài liệu học tập</li>
                                            </ul>
                                        </div>
                                        <div class="py-4">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                               target="_blank" 
                                               class="flex items-center justify-center w-full text-blue-600 hover:text-blue-800 font-medium cursor-pointer p-2 rounded-lg hover:bg-blue-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                                </svg>
                                                Chia sẻ lên Facebook
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@else
    <p>Khóa học không tồn tại.</p>
@endif

{{-- Schema.org script --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $course->name ?? '' }}",
  "description": "{{ Str::limit($course->description ?? '', 150) }}",
  "sku": "{{ $course->id ?? '' }}",
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "VND",
    "price": "{{ $course->price ?? 0 }}",
    "availability": "https://schema.org/InStock"
  }
}
</script>