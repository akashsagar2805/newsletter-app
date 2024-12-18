<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <h2 class="text-xl font-bold">Create Newsletter</h2>
        <form action="{{ route('newsletters.store') }}" method="POST">
            @csrf
            <div class="mt-4">
                <label for="title" class="block text-sm font-medium">Title</label>
                <input type="text" id="title" name="title" class="block w-full mt-1 border-gray-300 rounded-md">
            </div>
            <div class="mt-4">
                <label for="content" class="block text-sm font-medium">Content</label>
                <textarea id="content" name="content" rows="4" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
            </div>
            <div class="mt-4">
                <label for="scheduled_at" class="block text-sm font-medium">Scheduled At</label>
                <input type="datetime-local" id="scheduled_at" name="scheduled_at" class="block w-full mt-1 border-gray-300 rounded-md">
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
