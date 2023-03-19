<x-app-layout>
    <x-slot available_seats="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($bus) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($bus) ? route('buses.update', $bus->id) : route('buses.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($bus)
                            @method('put')
                        @endisset
                                
                        <div>
                            <x-input-label for="name" value="name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$bus->name ?? old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="available_seats" value="Available Seats" />
                            <x-text-input id="available_seats" name="available_seats" type="number" min='1' class="mt-1 block w-full" :value="$bus->available_seats ?? old('available_seats')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('available_seats')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>