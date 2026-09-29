@props(['kicker'])

<div class="mb-10 translate-y-6 text-center opacity-0 transition-all duration-700 ease-out" data-reveal>
    @if ($kicker)
        <p class="text-xs font-semibold tracking-widest text-indigo-600 uppercase dark:text-indigo-400">{{ $kicker }}</p>
    @endif

    <h2 {{ $attributes->merge(['class' => 'mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white']) }}>
        {{ $slot }}
    </h2>

    <span class="mx-auto mt-4 block h-1 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500"></span>
</div>
