<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white dark:bg-ellas-card shadow-sm dark:shadow-[0_0_15px_rgba(0,0,0,0.3)] sm:rounded-lg border border-gray-200 dark:border-ellas-nav transition-colors duration-300">
            {{ $content }}
        </div>
    </div>
</div>