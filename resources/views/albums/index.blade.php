<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Albums') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @forelse($albums as $album)
                        <div class="border-b border-gray-200 pb-2">
                            <a href="{{ route('albums.show', $album) }}" class="text-blue-600 hover:underline font-medium">
                                {{ $album->title }} ({{ $album->artist->name }})
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">No albums found.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <a href="{{ route('albums.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Create New Album
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
