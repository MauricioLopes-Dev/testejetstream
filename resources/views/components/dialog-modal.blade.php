@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4 border-b border-ellas-nav bg-ellas-card">
        <div class="text-lg font-orbitron font-medium text-white">
            {{ $title }}
        </div>

        <div class="mt-4 font-biorhyme text-sm text-gray-400">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-ellas-dark/50 text-end rounded-b-lg">
        {{ $footer }}
    </div>
</x-modal>