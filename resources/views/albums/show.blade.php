<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $album->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p class="text-gray-700"><span class="font-semibold">By:</span> {{ $album->artist->name }}</p>

                    @forelse($album->tracks as $track)
                        <div class="border-b border-gray-200 pb-2">
                            <span class="font-medium">{{ $track->title }}</span>
                            <span class="text-sm text-gray-500">({{ $track->duration }}s)</span>
                        </div>
                    @empty
                        <p class="text-gray-500">No tracks in this album.</p>
                    @endforelse

                    <div class="flex space-x-4 pt-4">
                        <a href="{{ route('albums.edit', $album) }}" class="text-blue-600 hover:underline font-medium">Edit</a>

                        <form method="POST" action="{{ route('albums.destroy', $album) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
