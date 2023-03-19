<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Show' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Name' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $trip->name }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'From Station' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $trip->startStation->name }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'To Station' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $trip->endStation->name }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Created At' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $trip->created_at }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Updated At' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $trip->updated_at }}
                        </p>
                    </div>
                    <a href="{{ route('trips.index') }}" class="bg-blue-500 text-black px-4 py-2 rounded-md">BACK</a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="border-collapse table-auto w-full text-sm">
                        <thead>
                            <tr>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 text-left">Stop Station(s)</th>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 text-left">Created At</th>
                                <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 text-left">Updated At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            {{-- populate our trip data --}}
                            @foreach ($tripStops as $tripStop)
                                <tr>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $tripStop->station->name }}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $tripStop->created_at }}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $tripStop->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
