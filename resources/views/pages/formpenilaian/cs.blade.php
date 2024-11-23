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
                <div class="p-6 space-y-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            Filter
                        </button>

                        <div class=""><a href="{{ url('penilaian-cs/create') }}" type="button"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Tambah</a>
                        </div>
                    </div>
                    <div class="">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    {{-- @foreach ($penilaian as $row) --}}
                                    <tr>
                                        <!-- Show only selected display columns -->
                                        @foreach ($displayColumns as $column)
                                            @if (request('display_columns') === null)
                                                <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                                    {{ ucwords(str_replace('_', ' ', $column)) }}
                                                </th>
                                            @else
                                                @if (request()->has('display_columns') && in_array($column, request('display_columns')))
                                                    <th scope="col"
                                                        class="px-6 py-3 whitespace-nowrap dark:text-white">
                                                        {{ ucwords(str_replace('_', ' ', $column)) }}
                                                    </th>
                                                @endif
                                            @endif
                                        @endforeach 
                                    </tr>
                                    {{-- @endforeach  --}}
                                </thead>
                                <tbody> 
                                    @foreach ($penilaian as $row)
                                        <tr>
                                            @php
                                                // dd(request('display_columns'));
                                            @endphp
                                            <!-- Show only selected display columns -->
                                            @foreach ($displayColumns as $column)
                                                @if (request('display_columns') === null)
                                                    <td class=" px-4 py-2">{{ $row->$column }}</td>
                                                @else
                                                    @if (request()->has('display_columns') && in_array($column, request('display_columns')))
                                                        <td class=" px-4 py-2">{{ $row->$column }}</td>
                                                    @endif
                                                @endif
                                            @endforeach 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex justify-center items-center">
                                {{ $penilaian->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-7xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form method="GET" action="{{ url('penilaian-cs') }}">
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
                                                <input type="checkbox" name="{{ $column }}[]"
                                                    value="{{ $value }}"
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
                            <button type="button" onclick="toggleModal(false)"
                                class="bg-gray-400 text-white py-2 px-4 rounded">Close</button>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Apply
                                Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
