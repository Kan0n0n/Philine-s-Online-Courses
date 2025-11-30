<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icon -->
        <link rel="icon" type="image" href="{{ asset('favicon.webp') }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- CANONICAL TAG FIX --}}
        <link rel="canonical" href="{{ url()->current() }}" />

        {{-- META DESCRIPTION FIX --}}
        <meta name="description" content="@yield('meta_description', 'This is the default description of my shop.')">
        
        {{-- META KEYWORDS FIX --}}
        <meta name="keywords" content="@yield('meta_keywords', 'course, education, learn, online')">

        {{-- SOCIAL SHARING TAGS (Open Graph) --}}
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', config('app.name'))">
        <meta property="og:description" content="@yield('meta_description', 'Mô tả mặc định cho website của bạn.')">
        <meta property="og:image" content="@yield('meta_image', asset('Images/images.png'))">

        {{-- TWITTER CARDS --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', config('app.name'))">
        <meta name="twitter:description" content="@yield('meta_description', 'Mô tả mặc định.')">
        <meta name="twitter:image" content="@yield('meta_image', asset('Images/images.png'))">

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-1Q1GKH3QN9"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-1Q1GKH3QN9');
        </script>
    </head>
    <body class="font-sans antialiased">


        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <!-- @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset -->

            <!-- Page Content -->
            <main class="py-10">
                @if (session('success'))
                    <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(()=> show = false, 4000)"
                    x-show="show"
                    x-transition.opacity.duration.200ms
                    class="fixed top-4 right-4 z-50 w-80"
                    role="alert"
                >
                    <div class="bg-green-100 border border-green-600 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Thành công!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        
                        <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                            <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                </div>
                @endif

                @if($errors->any())
                    <div
                        x-data="{ showErr: true }"
                        x-init="setTimeout(()=> showErr = false, 6000)"
                        x-show="showErr"
                        x-transition.opacity.duration.200ms
                        class="fixed top-24 right-4 z-50 w-96"
                        role="alert"
                    >
                        <div class="relative rounded-lg shadow-lg border border-red-200 bg-white overflow-hidden">
                            <div class="flex items-start gap-3 p-4">
                                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                                <button
                                    type="button"
                                    @click="showErr = false"
                                    class="ml-auto text-gray-400 hover:text-gray-600"
                                    aria-label="Close"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/6929bb10a4feed197ff8c2b2/1jb5g5fh1';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
                })();
            </script>
            <!--End of Tawk.to Script-->
        </div>

        <div id="fb-root"></div>
            <div id="fb-customer-chat" class="fb-customerchat"></div>

                <script>
                var chatbox = document.getElementById('fb-customer-chat');
                chatbox.setAttribute("page_id", "DÁN_ID_PAGE_CUA_BAN_VÀO_ĐÂY"); // <--- THAY ID Ở ĐÂY
                chatbox.setAttribute("attribution", "biz_inbox");
                </script>

                <script>
                window.fbAsyncInit = function() {
                    FB.init({
                    xfbml            : true,
                    version          : 'v18.0' // Phiên bản mới nhất
                    });
                };

                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
                </script>
    </body>

    @include('layouts.footer')
</html>
