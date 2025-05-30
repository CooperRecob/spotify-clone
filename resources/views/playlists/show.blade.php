<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $playlist->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @forelse($playlist->tracks as $track)
                        <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                            <a href="{{ route('tracks.show', $track) }}" class="text-blue-600 hover:underline font-medium">
                                {{ $track->title }} - {{ $track->album->artist->name }}
                            </a>
                            <form method="POST" action="{{ route('playlists.removeTrack', [$playlist, $track]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Remove</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500">No tracks in this playlist.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('playlists.addTrack', $playlist) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="track_id" class="block text-sm font-medium text-gray-700">Add Track</label>
                            <select id="track_id" name="track_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach(App\Models\Track::all() as $track)
                                    <option value="{{ $track->id }}">{{ $track->title }} - {{ $track->album->artist->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Add Track
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('playlists.edit', $playlist) }}" class="text-blue-600 hover:underline font-medium">Edit</a>

                <form method="POST" action="{{ route('playlists.destroy', $playlist) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
