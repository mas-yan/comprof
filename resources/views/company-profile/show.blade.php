<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow">

        <script>
            (function () {
                var stored = localStorage.getItem('theme');
                var isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', isDark);
            })();
        </script>

        <title>{{ $metaTitle }}</title>
        <meta name="description" content="{{ $metaDescription }}">
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Open Graph --}}
        <meta property="og:type" content="website">
        <meta property="og:locale" content="id_ID">
        <meta property="og:site_name" content="{{ $companyName }}">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:url" content="{{ url()->current() }}">
        @if ($profile?->logo_url)
            <meta property="og:image" content="{{ $profile->logo_url }}">
        @endif

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDescription }}">
        @if ($profile?->logo_url)
            <meta name="twitter:image" content="{{ $profile->logo_url }}">
        @endif

        @if ($jsonLd)
            <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 focus:rounded-full focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-white">
            Langsung ke konten
        </a>

        <header data-site-header class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/80 backdrop-blur transition-shadow duration-300 dark:border-slate-800/70 dark:bg-slate-950/80">
            <div class="relative mx-auto flex max-w-6xl items-center justify-between gap-4 px-6 py-4">
                <a href="{{ url('/') }}" data-scroll-top class="flex items-center gap-3 font-semibold" aria-label="{{ $companyName }}">
                    @if ($profile?->logo_url)
                        <img src="{{ $profile->logo_url }}" alt="Logo {{ $companyName }}" class="h-12 w-auto max-w-[10rem] object-contain">
                    @endif
                    @if ($profile?->name || ! $profile?->logo_url)
                        <span>{{ $companyName }}</span>
                    @endif
                </a>

                @if ($profile)
                    <nav class="hidden gap-8 text-sm font-medium lg:flex" aria-label="Navigasi utama">
                        <a href="#tentang" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">Tentang</a>
                        @if ($services->isNotEmpty())
                            <a href="#produk-layanan" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">Layanan</a>
                        @endif
                        @if ($advantages->isNotEmpty())
                            <a href="#kenapa-kami" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">Kenapa Kami</a>
                        @endif
                        @if ($testimonials->isNotEmpty())
                            <a href="#testimoni" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">Testimoni</a>
                        @endif
                        @if ($faqs->isNotEmpty())
                            <a href="#faq" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">FAQ</a>
                        @endif
                    </nav>
                @endif

                <div class="flex items-center gap-2">
                    @if ($profile)
                        <a
                            href="#kontak"
                            class="hidden items-center rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-black sm:inline-flex dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200"
                        >
                            Hubungi Kami
                        </a>
                    @endif

                    <button
                        type="button"
                        data-theme-toggle
                        aria-label="Ganti tema terang/gelap"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-600 transition-colors hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="hidden h-5 w-5 dark:block">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5m-15 0H3m15.364-6.364-1.06 1.06M6.697 17.303l-1.06 1.06m12.727 0-1.06-1.06M6.697 6.697l-1.06-1.06M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-5 w-5 dark:hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>

                    @if ($profile)
                        <button
                            type="button"
                            data-menu-toggle
                            aria-expanded="false"
                            aria-controls="mobile-menu"
                            aria-label="Buka menu navigasi"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-600 hover:bg-slate-100 lg:hidden dark:text-slate-300 dark:hover:bg-slate-900"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>
                        </button>
                    @endif
                </div>

                @if ($profile)
                    <nav
                        id="mobile-menu"
                        data-menu-panel
                        aria-label="Navigasi mobile"
                        class="absolute inset-x-0 top-full hidden flex-col gap-1 border-b border-slate-200 bg-white p-4 shadow-lg lg:hidden dark:border-slate-800 dark:bg-slate-950"
                    >
                        <a href="#tentang" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">Tentang</a>
                        @if ($services->isNotEmpty())
                            <a href="#produk-layanan" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">Layanan</a>
                        @endif
                        @if ($advantages->isNotEmpty())
                            <a href="#kenapa-kami" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">Kenapa Kami</a>
                        @endif
                        @if ($galleryImages->isNotEmpty())
                            <a href="#galeri" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">Galeri</a>
                        @endif
                        @if ($testimonials->isNotEmpty())
                            <a href="#testimoni" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">Testimoni</a>
                        @endif
                        @if ($faqs->isNotEmpty())
                            <a href="#faq" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">FAQ</a>
                        @endif
                        <a href="#kontak" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">Kontak</a>
                    </nav>
                @endif
            </div>
        </header>

        <main id="konten">
            @if ($profile)
                @php
                    $trustBadge = $customers->isNotEmpty()
                        ? 'Dipercaya '.$customers->count().'+ Klien'
                        : 'Profil Perusahaan Resmi';
                @endphp

                <section class="relative overflow-hidden">
                    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
                        <div class="animate-blob absolute -top-24 -left-24 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl dark:bg-indigo-700/20"></div>
                        <div class="animate-blob animation-delay-2000 absolute -right-24 top-1/3 h-72 w-72 rounded-full bg-violet-300/40 blur-3xl dark:bg-violet-700/20"></div>
                        <div class="animate-blob animation-delay-4000 absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-fuchsia-300/30 blur-3xl dark:bg-fuchsia-700/10"></div>
                    </div>

                    <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-6 py-20 sm:py-28 lg:grid-cols-2 lg:gap-16">
                        <div class="animate-fade-in-up text-center lg:text-left">
                            <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/60 px-4 py-1.5 text-xs font-medium text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-300">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                {{ $trustBadge }}
                            </span>

                            <h1 class="mt-6 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                                <span class="text-gradient-brand">{{ $companyName }}</span>
                            </h1>

                            @if ($profile->description)
                                <p class="mx-auto mt-6 max-w-xl text-lg text-slate-600 lg:mx-0 dark:text-slate-400">
                                    {{ Str::limit(strip_tags($profile->description), 200) }}
                                </p>
                            @endif

                            <div class="mt-10 flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                                <a
                                    href="#kontak"
                                    class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-indigo-500/40"
                                >
                                    Hubungi Kami
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                                <a
                                    href="#tentang"
                                    class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition-all hover:-translate-y-0.5 hover:border-slate-400 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-900"
                                >
                                    Tentang Kami
                                </a>
                            </div>
                        </div>

                        <div class="animate-fade-in-up" style="animation-delay: 150ms">
                            @if ($profile->hero_image_url)
                                <img
                                    src="{{ $profile->hero_image_url }}"
                                    alt="{{ $companyName }}"
                                    class="aspect-[4/3] w-full rounded-3xl object-cover shadow-2xl ring-1 ring-black/5 dark:ring-white/10"
                                >
                            @else
                                <div class="flex aspect-[4/3] w-full items-center justify-center rounded-3xl bg-gradient-to-br from-indigo-500 to-violet-600 p-12 shadow-2xl">
                                    @if ($profile->logo_url)
                                        <img
                                            src="{{ $profile->logo_url }}"
                                            alt="Logo {{ $companyName }}"
                                            class="max-h-28 w-full max-w-xs object-contain drop-shadow-lg sm:max-h-32"
                                        >
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                @if ($customers->isNotEmpty())
                    <section id="pelanggan" aria-labelledby="pelanggan-heading" class="border-t border-slate-200 py-16 dark:border-slate-800">
                        <div class="mx-auto max-w-5xl px-6">
                            <p id="pelanggan-heading" class="mb-8 text-center text-sm font-medium text-slate-500 dark:text-slate-400">
                                Dipercaya oleh berbagai klien terkemuka
                            </p>
                        </div>

                        @php
                            // Repeat the logo set enough times so the marquee track is always
                            // wider than the viewport, however few customers are configured.
                            $marqueeRepeats = max(2, (int) ceil(10 / max($customers->count(), 1)));
                            $marqueeSet = collect();
                            for ($i = 0; $i < $marqueeRepeats; $i++) {
                                $marqueeSet = $marqueeSet->concat($customers);
                            }
                        @endphp

                        <div
                            class="relative translate-y-6 overflow-hidden opacity-0 transition-all duration-700 ease-out [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]"
                            data-reveal
                        >
                            <div class="animate-marquee flex w-max items-center gap-16">
                                @foreach ($marqueeSet->concat($marqueeSet) as $customer)
                                    @php $logo = $customer->website_url ? 'a' : 'span'; @endphp
                                    <{{ $logo }}
                                        @if ($customer->website_url) href="{{ $customer->website_url }}" target="_blank" rel="noopener noreferrer" @endif
                                        class="flex shrink-0 items-center"
                                        title="{{ $customer->name }}"
                                    >
                                        <img
                                            src="{{ $customer->logo_url }}"
                                            alt="{{ $customer->name }}"
                                            loading="lazy"
                                            class="h-10 w-auto opacity-60 grayscale transition-all hover:opacity-100 hover:grayscale-0 sm:h-12"
                                        >
                                    </{{ $logo }}>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                @if ($profile->description)
                    <section id="tentang" aria-labelledby="tentang-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-3xl px-6">
                            <x-section-heading kicker="Siapa Kami" id="tentang-heading">Tentang Kami</x-section-heading>

                            <div
                                class="translate-y-6 rounded-3xl border border-slate-200 bg-slate-50 p-8 opacity-0 shadow-sm transition-all duration-700 ease-out sm:p-10 dark:border-slate-800 dark:bg-slate-900/50"
                                data-reveal
                            >
                                <div class="leading-relaxed whitespace-pre-line text-slate-600 dark:text-slate-400">{{ $profile->description }}</div>
                            </div>
                        </div>
                    </section>
                @endif

                @if ($services->isNotEmpty())
                    <section id="produk-layanan" aria-labelledby="produk-layanan-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-5xl px-6">
                            <x-section-heading kicker="Layanan Kami" id="produk-layanan-heading">Produk &amp; Layanan</x-section-heading>

                            <div
                                class="relative translate-y-6 opacity-0 transition-all duration-700 ease-out"
                                data-slider
                                data-autoplay="3500"
                                data-reveal
                            >
                                <div
                                    data-slider-track
                                    class="scrollbar-hide flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-2"
                                >
                                    @foreach ($services as $service)
                                        <div
                                            class="group relative w-[85%] shrink-0 snap-start overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-indigo-500/10 sm:w-[46%] lg:w-[31%] dark:border-slate-800 dark:bg-slate-900"
                                        >
                                            <span class="absolute inset-x-0 top-0 z-10 h-1 origin-left scale-x-0 bg-gradient-to-r from-indigo-500 to-violet-500 transition-transform duration-300 group-hover:scale-x-100"></span>

                                            <div class="aspect-video overflow-hidden">
                                                @if ($service->image_url)
                                                    <img
                                                        src="{{ $service->image_url }}"
                                                        alt="{{ $service->name }}"
                                                        loading="lazy"
                                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                    >
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-indigo-500 to-violet-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" class="h-12 w-12 text-white/80">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38a23.978 23.978 0 0 1-7.577 1.22c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-6">
                                                <h3 class="mb-2 font-semibold text-slate-900 dark:text-white">{{ $service->name }}</h3>
                                                @if ($service->description)
                                                    <p class="mb-4 text-sm text-slate-600 dark:text-slate-400">{{ Str::limit($service->description, 120) }}</p>
                                                @endif
                                                @if ($service->price)
                                                    <span class="inline-block rounded-full bg-gradient-to-r from-indigo-50 to-violet-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:from-indigo-500/10 dark:to-violet-500/10 dark:text-indigo-300">
                                                        {{ $service->price }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($services->count() > 1)
                                    <button
                                        type="button"
                                        data-slider-prev
                                        aria-label="Layanan sebelumnya"
                                        class="absolute top-1/2 left-0 hidden -translate-x-4 -translate-y-1/2 rounded-full bg-white p-2.5 text-slate-900 shadow-lg transition-all hover:scale-110 sm:block dark:bg-slate-800 dark:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        data-slider-next
                                        aria-label="Layanan berikutnya"
                                        class="absolute top-1/2 right-0 hidden -translate-y-1/2 translate-x-4 rounded-full bg-white p-2.5 text-slate-900 shadow-lg transition-all hover:scale-110 sm:block dark:bg-slate-800 dark:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif

                @if ($advantages->isNotEmpty())
                    <section id="kenapa-kami" aria-labelledby="kenapa-kami-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-5xl px-6">
                            <x-section-heading kicker="Keunggulan Kami" id="kenapa-kami-heading">Kenapa Memilih Kami</x-section-heading>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($advantages as $advantage)
                                    <div
                                        class="translate-y-6 rounded-2xl border border-slate-200 bg-white p-6 opacity-0 shadow-sm transition-all duration-700 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900"
                                        data-reveal
                                        style="transition-delay: {{ min($loop->index * 75, 300) }}ms"
                                    >
                                        <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                            <x-advantage-icon :name="$advantage->icon" class="h-6 w-6" />
                                        </span>
                                        <h3 class="mb-1 font-semibold text-slate-900 dark:text-white">{{ $advantage->title }}</h3>
                                        @if ($advantage->description)
                                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $advantage->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                @if ($galleryImages->isNotEmpty())
                    <section id="galeri" aria-labelledby="galeri-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-5xl px-6">
                            <x-section-heading kicker="Galeri" id="galeri-heading">Momen &amp; Aktivitas Kami</x-section-heading>

                            <div
                                data-carousel
                                data-autoplay="5000"
                                class="relative translate-y-6 overflow-hidden rounded-3xl opacity-0 shadow-2xl ring-1 ring-black/5 transition-all duration-700 ease-out dark:ring-white/10"
                                data-reveal
                            >
                                <div class="relative aspect-[16/9] w-full sm:aspect-[21/9]">
                                    @foreach ($galleryImages as $image)
                                        <div
                                            data-carousel-slide
                                            class="absolute inset-0 transition-opacity duration-700 {{ $loop->first ? 'opacity-100' : 'opacity-0 pointer-events-none' }}"
                                        >
                                            <img
                                                src="{{ $image->image_url }}"
                                                alt="{{ $image->caption ?: ($companyName.' - galeri') }}"
                                                loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                                class="h-full w-full object-cover"
                                            >
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent"></div>
                                            @if ($image->caption)
                                                <div class="absolute inset-x-0 bottom-0 px-6 py-5">
                                                    <p class="text-sm font-medium text-white sm:text-base">{{ $image->caption }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                @if ($galleryImages->count() > 1)
                                    <button
                                        type="button"
                                        data-carousel-prev
                                        aria-label="Gambar sebelumnya"
                                        class="absolute top-1/2 left-3 -translate-y-1/2 rounded-full bg-white/90 p-2.5 text-slate-900 shadow-lg backdrop-blur transition-all hover:scale-110 hover:bg-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        data-carousel-next
                                        aria-label="Gambar berikutnya"
                                        class="absolute top-1/2 right-3 -translate-y-1/2 rounded-full bg-white/90 p-2.5 text-slate-900 shadow-lg backdrop-blur transition-all hover:scale-110 hover:bg-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>

                                    <div class="absolute inset-x-0 bottom-3 flex justify-center gap-2" role="tablist" aria-label="Pilih gambar galeri">
                                        @foreach ($galleryImages as $image)
                                            <button
                                                type="button"
                                                data-carousel-dot
                                                data-active="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-label="Ke gambar {{ $loop->iteration }}"
                                                class="h-2 w-2 rounded-full bg-white/50 transition-all data-[active=true]:w-6 data-[active=true]:bg-white"
                                            ></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif

                @if ($testimonials->isNotEmpty())
                    <section id="testimoni" aria-labelledby="testimoni-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-5xl px-6">
                            <x-section-heading kicker="Kata Mereka" id="testimoni-heading">Apa Kata Klien Kami</x-section-heading>

                            <div
                                class="relative translate-y-6 opacity-0 transition-all duration-700 ease-out"
                                data-slider
                                data-autoplay="4500"
                                data-reveal
                            >
                                <div
                                    data-slider-track
                                    class="scrollbar-hide flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-2"
                                >
                                    @foreach ($testimonials as $testimonial)
                                        <div class="w-[85%] shrink-0 snap-start rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:w-[46%] lg:w-[31%] dark:border-slate-800 dark:bg-slate-900">
                                            <div class="mb-3 text-amber-400" aria-label="{{ $testimonial->rating }} dari 5 bintang">
                                                {{ str_repeat('★', $testimonial->rating).str_repeat('☆', 5 - $testimonial->rating) }}
                                            </div>
                                            <p class="mb-6 text-sm text-slate-600 dark:text-slate-400">&ldquo;{{ $testimonial->content }}&rdquo;</p>
                                            <div class="flex items-center gap-3">
                                                @if ($testimonial->avatar_url)
                                                    <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                                                        {{ Str::substr($testimonial->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $testimonial->name }}</p>
                                                    @if ($testimonial->position)
                                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $testimonial->position }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($testimonials->count() > 1)
                                    <button
                                        type="button"
                                        data-slider-prev
                                        aria-label="Testimoni sebelumnya"
                                        class="absolute top-1/2 left-0 hidden -translate-x-4 -translate-y-1/2 rounded-full bg-white p-2.5 text-slate-900 shadow-lg transition-all hover:scale-110 sm:block dark:bg-slate-800 dark:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        data-slider-next
                                        aria-label="Testimoni berikutnya"
                                        class="absolute top-1/2 right-0 hidden -translate-y-1/2 translate-x-4 rounded-full bg-white p-2.5 text-slate-900 shadow-lg transition-all hover:scale-110 sm:block dark:bg-slate-800 dark:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif

                @if ($faqs->isNotEmpty())
                    <section id="faq" aria-labelledby="faq-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-3xl px-6">
                            <x-section-heading kicker="Pertanyaan Umum" id="faq-heading">FAQ</x-section-heading>

                            <div class="space-y-3">
                                @foreach ($faqs as $faq)
                                    <details
                                        class="group translate-y-6 rounded-2xl border border-slate-200 bg-white p-5 opacity-0 shadow-sm transition-all duration-700 ease-out open:shadow-md dark:border-slate-800 dark:bg-slate-900"
                                        data-reveal
                                        style="transition-delay: {{ min($loop->index * 75, 300) }}ms"
                                    >
                                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-medium text-slate-900 [&::-webkit-details-marker]:hidden dark:text-white">
                                            {{ $faq->question }}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 shrink-0 text-indigo-600 transition-transform group-open:rotate-45 dark:text-indigo-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </summary>
                                        <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">{{ $faq->answer }}</p>
                                    </details>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                <section class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                    <div class="mx-auto max-w-5xl px-6">
                        <div
                            class="relative translate-y-6 overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-14 text-center opacity-0 shadow-xl transition-all duration-700 ease-out sm:px-16"
                            data-reveal
                        >
                            <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
                                <div class="absolute -top-16 -left-16 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
                                <div class="absolute -right-16 -bottom-16 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
                            </div>

                            <h2 class="text-2xl font-bold text-white sm:text-3xl">Siap Bekerja Sama dengan Kami?</h2>
                            <p class="mx-auto mt-3 max-w-xl text-indigo-100">
                                Hubungi tim kami sekarang dan mulai wujudkan kebutuhan digital perusahaan Anda.
                            </p>
                            <a
                                href="#kontak"
                                class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-indigo-700 shadow-lg transition-all hover:-translate-y-0.5 hover:shadow-xl"
                            >
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </section>

                <section id="kontak" aria-labelledby="kontak-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                    <div class="mx-auto max-w-5xl px-6">
                        <x-section-heading kicker="Hubungi Kami" id="kontak-heading">Kontak</x-section-heading>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            @if ($profile->address)
                                <div
                                    class="translate-y-6 rounded-2xl border border-slate-200 bg-white p-6 opacity-0 shadow-sm transition-all duration-700 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900"
                                    data-reveal
                                >
                                    <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-1 font-medium text-slate-900 dark:text-white">Alamat</h3>
                                    <p class="text-sm whitespace-pre-line text-slate-600 dark:text-slate-400">{{ $profile->address }}</p>
                                </div>
                            @endif

                            @if ($profile->phone)
                                <div
                                    class="translate-y-6 rounded-2xl border border-slate-200 bg-white p-6 opacity-0 shadow-sm transition-all duration-700 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900"
                                    data-reveal
                                    style="transition-delay: 75ms"
                                >
                                    <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 0 0 2.25-2.25v-1.372a1.5 1.5 0 0 0-1.209-1.47l-3.24-.648a1.5 1.5 0 0 0-1.44.44l-.792.92a12.06 12.06 0 0 1-5.688-5.688l.92-.792a1.5 1.5 0 0 0 .44-1.44l-.648-3.24A1.5 1.5 0 0 0 5.372 2.25H4a1.75 1.75 0 0 0-1.75 1.75Z" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-1 font-medium text-slate-900 dark:text-white">Telepon</h3>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $profile->phone) }}" class="text-sm text-slate-600 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                                        {{ $profile->phone }}
                                    </a>
                                </div>
                            @endif

                            @if ($profile->email)
                                <div
                                    class="translate-y-6 rounded-2xl border border-slate-200 bg-white p-6 opacity-0 shadow-sm transition-all duration-700 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900"
                                    data-reveal
                                    style="transition-delay: 150ms"
                                >
                                    <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-1 font-medium text-slate-900 dark:text-white">Email</h3>
                                    <a href="mailto:{{ $profile->email }}" class="text-sm break-all text-slate-600 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                                        {{ $profile->email }}
                                    </a>
                                </div>
                            @endif

                            @if ($profile->operating_hours)
                                <div
                                    class="translate-y-6 rounded-2xl border border-slate-200 bg-white p-6 opacity-0 shadow-sm transition-all duration-700 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900"
                                    data-reveal
                                    style="transition-delay: 225ms"
                                >
                                    <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-1 font-medium text-slate-900 dark:text-white">Jam Operasional</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $profile->operating_hours }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                @if ($profile->facebook_url || $profile->instagram_url || $profile->x_url || $profile->whatsapp_number)
                    <section id="sosial-media" aria-labelledby="sosial-media-heading" class="border-t border-slate-200 py-20 sm:py-24 dark:border-slate-800">
                        <div class="mx-auto max-w-5xl px-6 text-center">
                            <x-section-heading kicker="Terhubung" id="sosial-media-heading">Ikuti Kami</x-section-heading>

                            <div class="flex flex-wrap items-center justify-center gap-4">
                                @if ($profile->facebook_url)
                                    <a
                                        href="{{ $profile->facebook_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Facebook"
                                        class="group inline-flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:-translate-y-1 hover:border-transparent hover:bg-[#1877F2] hover:text-white hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                        </svg>
                                    </a>
                                @endif
                                @if ($profile->instagram_url)
                                    <a
                                        href="{{ $profile->instagram_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Instagram"
                                        class="group inline-flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:-translate-y-1 hover:border-transparent hover:bg-gradient-to-tr hover:from-[#f9ce34] hover:via-[#ee2a7b] hover:to-[#6228d7] hover:text-white hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.44.645-1.44 1.44s.644 1.44 1.44 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                        </svg>
                                    </a>
                                @endif
                                @if ($profile->x_url)
                                    <a
                                        href="{{ $profile->x_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="X (Twitter)"
                                        class="group inline-flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:-translate-y-1 hover:border-transparent hover:bg-black hover:text-white hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                        </svg>
                                    </a>
                                @endif
                                @if ($profile->whatsapp_number)
                                    <a
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp_number) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="WhatsApp"
                                        class="group inline-flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:-translate-y-1 hover:border-transparent hover:bg-[#25D366] hover:text-white hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif
            @else
                <section class="relative overflow-hidden">
                    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
                        <div class="animate-blob absolute -top-24 -left-24 h-72 w-72 rounded-full bg-indigo-300/40 blur-3xl dark:bg-indigo-700/20"></div>
                        <div class="animate-blob animation-delay-2000 absolute -right-24 top-1/3 h-72 w-72 rounded-full bg-violet-300/40 blur-3xl dark:bg-violet-700/20"></div>
                    </div>
                    <div class="relative mx-auto flex max-w-2xl flex-col items-center px-6 py-24 text-center sm:py-32">
                        <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl">Profil perusahaan belum diisi</h1>
                        <p class="mt-4 text-slate-600 dark:text-slate-400">
                            Silakan tambahkan data perusahaan melalui panel admin agar halaman ini menampilkan informasi perusahaan Anda.
                        </p>
                        <a
                            href="{{ url('/admin') }}"
                            class="mt-8 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all hover:-translate-y-0.5 hover:shadow-xl"
                        >
                            Buka Panel Admin
                        </a>
                    </div>
                </section>
            @endif
        </main>

        <footer class="border-t border-slate-800/60 bg-slate-950 py-16 text-slate-400">
            <div class="mx-auto max-w-6xl px-6">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-4">
                    <div class="lg:col-span-2">
                        <div class="mb-3 flex items-center gap-3">
                            @if ($profile?->logo_url)
                                <img src="{{ $profile->logo_url }}" alt="Logo {{ $companyName }}" class="h-9 w-auto max-w-[9rem] object-contain">
                            @endif
                            @if ($profile?->name || ! $profile?->logo_url)
                                <span class="font-semibold text-white">{{ $companyName }}</span>
                            @endif
                        </div>
                        @if ($profile?->description)
                            <p class="max-w-sm text-sm text-slate-400">{{ Str::limit(strip_tags($profile->description), 140) }}</p>
                        @endif

                        <form method="POST" action="{{ route('newsletter.subscribe') }}" class="mt-6 max-w-sm">
                            @csrf
                            <label for="newsletter-email" class="mb-2 block text-sm font-medium text-white">Dapatkan info & promo terbaru</label>
                            <div class="flex flex-col gap-2 sm:flex-row">
                                <input
                                    type="email"
                                    name="email"
                                    id="newsletter-email"
                                    required
                                    placeholder="Alamat email Anda"
                                    class="w-full rounded-full border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-white placeholder:text-slate-500 focus:border-indigo-500 focus:outline-none sm:flex-1"
                                >
                                <button
                                    type="submit"
                                    class="shrink-0 rounded-full bg-white px-5 py-2 text-sm font-semibold text-slate-900 transition-colors hover:bg-slate-200"
                                >
                                    Berlangganan
                                </button>
                            </div>
                            @if (session('newsletter_success'))
                                <p class="mt-2 text-sm text-emerald-400">{{ session('newsletter_success') }}</p>
                            @endif
                            @error('email')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>

                    @if ($profile)
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-white">Navigasi</h3>
                            <ul class="space-y-2 text-sm">
                                <li><a href="#tentang" class="transition-colors hover:text-white">Tentang</a></li>
                                @if ($services->isNotEmpty())
                                    <li><a href="#produk-layanan" class="transition-colors hover:text-white">Layanan</a></li>
                                @endif
                                @if ($advantages->isNotEmpty())
                                    <li><a href="#kenapa-kami" class="transition-colors hover:text-white">Kenapa Kami</a></li>
                                @endif
                                @if ($galleryImages->isNotEmpty())
                                    <li><a href="#galeri" class="transition-colors hover:text-white">Galeri</a></li>
                                @endif
                                @if ($testimonials->isNotEmpty())
                                    <li><a href="#testimoni" class="transition-colors hover:text-white">Testimoni</a></li>
                                @endif
                                @if ($faqs->isNotEmpty())
                                    <li><a href="#faq" class="transition-colors hover:text-white">FAQ</a></li>
                                @endif
                                <li><a href="#kontak" class="transition-colors hover:text-white">Kontak</a></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-white">Sosial Media</h3>
                            <ul class="space-y-2 text-sm">
                                @if ($profile->facebook_url)
                                    <li><a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Facebook</a></li>
                                @endif
                                @if ($profile->instagram_url)
                                    <li><a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Instagram</a></li>
                                @endif
                                @if ($profile->x_url)
                                    <li><a href="{{ $profile->x_url }}" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">X (Twitter)</a></li>
                                @endif
                                @if ($profile->whatsapp_number)
                                    <li><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">WhatsApp</a></li>
                                @endif
                                @if ($profile->email)
                                    <li><a href="mailto:{{ $profile->email }}" class="transition-colors hover:text-white">{{ $profile->email }}</a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-slate-800 pt-6 text-xs text-slate-500 sm:flex-row">
                    <p>&copy; {{ now()->year }} {{ $companyName }}. Seluruh hak cipta dilindungi.</p>
                    <p>Dibuat dengan Laravel &amp; Filament</p>
                </div>
            </div>
        </footer>

        <button
            type="button"
            data-back-to-top
            aria-label="Kembali ke atas"
            class="fixed right-6 bottom-6 z-30 inline-flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white opacity-0 shadow-lg shadow-indigo-500/30 transition-opacity duration-300 pointer-events-none hover:shadow-xl"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </body>
</html>
