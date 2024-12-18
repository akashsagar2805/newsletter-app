<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <a href="{{ route('newsletters.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create Newsletter</a>

        <table class="w-full mt-5 border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Scheduled At</th>
                    <th class="border px-4 py-2">Progress</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newsletters as $newsletter)
                    <tr>
                        <td class="border px-4 py-2">{{ $newsletter->title }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($newsletter->process_status) }}</td>
                        <td class="border px-4 py-2">{{ $newsletter->scheduled_at }}</td>
                        <td class="border px-4 py-2">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div
                                    class="bg-blue-600 h-4 rounded-full"
                                    style="width: {{ ($newsletter->sent_count / ($newsletter->total_users ?: 1)) * 100 }}%;">
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">
                                {{ $newsletter->sent_count ?? 0 }} of {{ $newsletter->total_users ?? 0 }} emails sent
                            </p>
                        </td>
                        <td class="border px-4 py-2">
                            @if ($newsletter->process_status === 'pending')
                                <form action="{{ route('newsletters.start', $newsletter) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-500 text-white px-4 py-2 rounded">Start</button>
                                </form>
                            @elseif ($newsletter->process_status === 'started' || $newsletter->process_status === 'in-progress')
                                <span class="text-gray-500">In Progress</span>
                            @elseif ($newsletter->process_status === 'completed')
                                <span class="text-gray-500">Completed</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
