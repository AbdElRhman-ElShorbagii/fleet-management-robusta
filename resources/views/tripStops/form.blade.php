<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($tripStop) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($tripStop) ? route('trip-stops.update', $tripStop->id) : route('trip-stops.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($tripStop)
                            @method('put')
                        @endisset                
                        <div>
                            <x-input-label for="trip_id" value="Trip" />
                            <select name="trip_id" :value="$tripStop->trip_id ?? old('trip_id')" class="mt-1 block">
                                <option value="">Select Trip</option>
                                @foreach($trips as $trip)
                                    <option value="{{$trip->id}}">{{$trip->name}}</option>
                                    @isset($tripStop)
                                        <option value="{{$trip->id}}" {{ $trip->id == $tripStop->trip_id ? 'selected' : '' }} >{{$tripStop->trip->name}}</option>
                                    @endisset
                                @endforeach
                           </select>                                                                    
                            <x-input-error class="mt-2" :messages="$errors->get('trip_id')" />
                        </div>
                        <div>
                            <x-input-label for="station_id" value="Station" />
                            <select name="station_id" :value="$tripStop->station_id ?? old('station_id')" class="mt-1 block">
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}">{{$station->name}}</option>
                                    @isset($tripStop)
                                        <option value="{{$station->id}}" {{ $tripStop->station_id == $station->id ? 'selected' : '' }} >{{$tripStop->station->name}}</option>
                                    @endisset
                                @endforeach
                           </select>                                                                    
                            <x-input-error class="mt-2" :messages="$errors->get('station_id')" />
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