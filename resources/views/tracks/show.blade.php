<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $track->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p><span class="font-semibold">Album:</span> {{ $track->album->title }}</p>
                    <p><span class="font-semibold">Artist:</span> {{ $track->album->artist->name }}</p>
                    <p><span class="font-semibold">Duration:</span> {{ $track->duration }}s</p>

                    @if($track->file_path)
                        <audio controls class="mt-4 w-full">
                            <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @endif

                    <div class="flex items-center space-x-4 mt-6">
                        <a href="{{ route('tracks.edit', $track) }}" class="text-blue-600 hover:underline">Edit</a>

                        <form method="POST" action="{{ route('tracks.destroy', $track) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
