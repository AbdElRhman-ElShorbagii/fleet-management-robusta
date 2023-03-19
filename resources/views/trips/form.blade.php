<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($trip) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($trip) ? route('trips.update', $trip->id) : route('trips.store') }}" class="mt-6 space-y-6">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($trip)
                            @method('put')
                        @endisset
                
                        <div>
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$trip->name ?? old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="start_station_id" value="From Station" />
                            <select name="start_station_id" value="{{$trip->start_station_id ?? old('start_station_id')}}" class="mt-1 block">
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}" {{ $station->id == $trip->start_station_id ? 'selected' : '' }}>{{$station->name}}</option>
                                @endforeach
                           </select>                                                                    
                            <x-input-error class="mt-2" :messages="$errors->get('start_station_id')" />
                        </div>
                        <div>
                            <x-input-label for="end_station_id" value="To Station" />
                            <select name="end_station_id" value="{{$trip->end_station_id ?? old('end_station_id')}}" class="mt-1 block">
                                <option value="">Select Station</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}" {{ $station->id == $trip->end_station_id ? 'selected' : '' }}>{{$station->name}}</option>
                                @endforeach
                           </select>                                                                    
                            <x-input-error class="mt-2" :messages="$errors->get('end_station_id')" />
                        </div>
                        <div>
                            <x-input-label for="bus_id" value="Bus" />
                            <select name="bus_id" :value="$trip->bus_id ?? old('bus_id')" class="mt-1 block">
                                <option value="">Select Bus</option>
                                @foreach($buses as $bus)
                                    <option value="{{$bus->id}}" {{ $bus->id == $trip->bus_id ? 'selected' : '' }}>{{$bus->name}}</option>
                                @endforeach
                           </select>                                                                    
                            <x-input-error class="mt-2" :messages="$errors->get('bus_id')" />
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