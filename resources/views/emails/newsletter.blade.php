<x-guest-layout>

    <div class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        {{ $newsletter->title }}
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ $newsletter->content }}
    </div>

</x-guest-layout>
