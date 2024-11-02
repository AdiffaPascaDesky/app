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
                        <div class=""></div>
                        <div class=""><a href="{{ url('penilaian-cs/create') }}" type="button"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Tambah</a>
                        </div>
                    </div>
                    <div class="">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Nama Unit Kantor Bank Sumut
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Nama Nasabah
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Nomor Handphone Nasabah
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Bagaimana pendapat saudara/i tentang pelayanan yang diberikan Customer
                                            Service
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Bagaimana pendapat saudara/i tentang kecepatan transaksi Customer Service
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Bagaimana pendapat saudara/i tentang penjelasan yang diberikan Customer
                                            Service tentang kebutuhan transaksi saudara/i
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Sebutkan Nama Customer Service yang dinilai
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Bagaimana pendapat saudara/i tentang kebersihan dan kenyamanan Bank Sumut
                                            tempat saudara bertransaksi.
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Bagaimana pendapat saudara/i tentang pelayanan yang diberikan satpam dalam
                                            mengarahkan anda untuk bertransaksi ke Customer Service
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Sebutkan nama satpam yang dinilai
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Apakah dalam bertransaksi di Bank Sumut ini saudara/i ada diminta uang
                                            imbalan atas pelayanan yang saudara/i dapatkan.
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Sebutkan nama pegawai Bank Sumut (Jika minta uang imbalan atas pelayanan
                                            yang saudara/i dapatkan)
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Saran untuk perbaikan layanan Bank Sumut
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Email Address
                                        </th>
                                        <th scope="col" class="px-6 py-3 whitespace-nowrap dark:text-white">
                                            Tanggal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($penilaians as $data)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $data->nama_unit }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $data->nama_nasabah }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->nomor_handphone }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->pendapat_tentang_pelayanan_yang_diberikan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->pendapat_tentang_kecepatan_transaksi }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->pendapat_tentang_penjelasan_yang_diberikan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->nama_cs }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->pendapat_tentang_kebersihan }}
                                            </td> 
                                            <td class="px-6 py-4">
                                                {{ $data->pendapat_tentang_pelayanan_satpam }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->nama_satpam }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->diminta_uang_imbalan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->nama_pegawai_meminta_imbalan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->saran_perbaikan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $data->email }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ Carbon::parse($data->created_at)->translatedFormat('d F Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex justify-center items-center">
                                {{$penilaians->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
