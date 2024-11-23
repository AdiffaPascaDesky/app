@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Penilaian CS Bank Sumut') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ url('/penilaian-cs') }}">
                    <div class="flex flex-wrap">
                        <!-- Display-only Columns -->
                        <div class="m-2 w-full">
                            <h3 class="font-bold">Display Columns</h3>
                            <div class="space-y-2">
                                @foreach ($displayColumns as $column)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="display_columns[]" value="{{ $column }}" 
                                            {{ request()->has('display_columns') && in_array($column, request('display_columns')) ? 'checked' : '' }}
                                            class="text-blue-500 form-checkbox h-4 w-4 rounded border-gray-300 focus:ring focus:ring-blue-200">
                                        <span>{{ ucwords(str_replace('_', ' ', $column)) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
        
                        <!-- Value Filter Columns -->
                        @foreach ($distinctValues as $column => $values)
                            <div class="m-2 w-full">
                                <h3 class="font-bold">{{ ucwords(str_replace('_', ' ', $column)) }}</h3>
                                <div class="space-y-2">
                                    @foreach ($values as $value)
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" name="{{ $column }}[]" value="{{ $value }}" 
                                                {{ request()->has($column) && in_array($value, request($column)) ? 'checked' : '' }}
                                                class="text-blue-500 form-checkbox h-4 w-4 rounded border-gray-300 focus:ring focus:ring-blue-200">
                                            <span>{{ $value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" onclick="toggleModal()" class="bg-gray-400 text-white py-2 px-4 rounded">Close</button>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Apply Filter</button>
                    </div>
                </form>
                
                <table class="table-auto w-full mt-6 border border-gray-300">
                    <thead>
                        <tr>
                            <!-- Show only selected display columns -->
                            @foreach ($displayColumns as $column)
                                @if (request()->has('display_columns') && in_array($column, request('display_columns')))
                                    <th class="px-4 py-2 border">{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                                @endif
                            @endforeach
                            @foreach ($filterColumns as $column)
                                <th class="px-4 py-2 border">{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penilaian as $row)
                            <tr>
                                <!-- Show only selected display columns -->
                                @foreach ($displayColumns as $column)
                                    @if (request()->has('display_columns') && in_array($column, request('display_columns')))
                                        <td class="border px-4 py-2">{{ $row->$column }}</td>
                                    @endif
                                @endforeach
                                @foreach ($filterColumns as $column)
                                    <td class="border px-4 py-2">{{ $row->$column }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <script>
        function toggleModal() {
            const modal = document.getElementById('filterModal');
            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
