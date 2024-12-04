<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @php
        // dd($kecepatantransaksi);
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form class="grid grid-cols-2 gap-6 p-4" id="formfilter" method="GET">
                    <div class="">
                        <label for="countries"
                            class="block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white">Pilih
                            Filter Tampilan</label>
                        <select id="countries" name="filter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            <option value="">All</option>
                            <option value="cs" {{ $request['filter'] === 'cs' ? 'selected' : '' }}>Customer Service
                            </option>
                            <option value="teller" {{ $request['filter'] === 'teller' ? 'selected' : '' }}>Teller
                            </option>
                        </select>
                    </div>
                    <div class="">
                        <label for="tampilan"
                            class="block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white">Pilih
                            Filter Chart</label>
                        <select id="tampilan" name="tampilan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            <option value="">All</option>
                            <option value="tahun" {{ $request['tampilan'] === 'cs' ? 'selected' : '' }}>Perbadingan
                                tahun
                            </option>
                            <option value="seluruh" {{ $request['tampilan'] === 'teller' ? 'selected' : '' }}>
                                Perbadingan Keseluruhan</option>
                        </select>
                    </div>

                </form>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-4 gap-6">
                        @if (($request['filter'] === 'cs' && $request['filter'] !== 'teller') || $request['filter'] === null)

                            @if ($request['tampilan'] === 'tahun')
                                <x-bar-component title="Survey Penilaian Pelayanan Customer Service" :penilai="$pendapatcs"
                                    id="pendapatCs"></x-bar-component>
                                <x-bar-component
                                    title="Survey Penilaian Kecepatan Transaksi Customer
                                    Service"
                                    :penilai="$kecepatancs" id="kecepatanCs"></x-bar-component>
                                <x-bar-component title="Survey Penilaian Penjelasan yang Diberikan Customer Service"
                                    :penilai="$penjelasancs" id="penjelasanCs"></x-bar-component>
                                <x-bar-component title="Survey Penilaian Kebersihan" :penilai="$kebersihancs"
                                    id="kebersihancs"></x-bar-component>
                                <x-bar-component title="Survey Penilaian Pelayanan Satpam" :penilai="$satpamcs"
                                    id="satpamCs"></x-bar-component>
                                <x-bar-component title="Survey Diminta Uang Imbalan" :penilai="$imbalancs"
                                    id="imbalanCs"></x-bar-component>
                                {{-- <x-bar-component
                                    title="Survey Apakah Diminta Imbalan dalam bertransaksi di bank sumut"
                                    :penilai="$dimintaimbalan" id="dimintaImbalan"></x-bar-component> --}}
                            @else
                                <x-pie-chart-component title="Survey Penilaian Pelayanan Customer Service"
                                    :sur="$pendapatcs" id="pendapatCs"></x-pie-chart-component>
                                <x-pie-chart-component title="Survey Penilaian Kecepatan Transaksi Customer Service"
                                    :sur="$kecepatancs" id="kecepatanCs"></x-pie-chart-component>
                                <x-pie-chart-component
                                    title="Survey Penilaian Penjelasan yang Diberikan Customer Service"
                                    :sur="$penjelasancs" id="penjelasanCs"></x-pie-chart-component>
                                <x-pie-chart-component title="Survey Penilaian Kebersihan" :sur="$kebersihancs"
                                    id="kebersihancs"></x-pie-chart-component>
                                <x-pie-chart-component title="Survey Penilaian Pelayanan Satpam" :sur="$satpamcs"
                                    id="satpamCs"></x-pie-chart-component>
                                <x-pie-chart-component title="Survey Diminta Uang Imbalan" :sur="$imbalancs"
                                    id="imbalanCs"></x-pie-chart-component>
                            @endif
                        @endif
                        @if (($request['filter'] === 'teller' && $request['filter'] !== 'cs') || $request['filter'] === null)
                            @if ($request['tampilan'] === 'tahun')
                                <x-bar-component title="Survey Pendapat Pelayanan Teller" :penilai="$pelayananteller"
                                    id="pelayananTeller"></x-bar-component>
                                <x-bar-component title="Survey Pendapat Kecepatan Transaksi Teller" :penilai="$kecepatanteller"
                                    id="kecepatanTeller"></x-bar-component>
                                <x-bar-component title="Survey Pendapat Kebersihan dan Kenyamanan Tempat"
                                    :penilai="$kebersihantempat" id="kebersihanteller"></x-bar-component>
                                <x-bar-component title="Survey Pendapat Pelayan Satpam Mengarahkan Untuk Transaksi"
                                    :penilai="$pendapatpelayansatpam" id="satpamteller"></x-bar-component>
                                {{-- <x-bar-component
                                    title="Survey Apakah Diminta Imbalan dalam bertransaksi di bank sumut"
                                    :penilai="$dimintaimbalan" id="dimintaImbalan"></x-bar-component> --}}
                            @else
                                <x-pie-chart-component :sur="$pendapatpelayansatpam"
                                    title="Survey Pendapat Pelayan Satpam Mengarahkan Untuk Transaksi"
                                    id="satpamTransaksi"></x-pie-chart-component>
                                @php
                                    // dd($dimintaimbalan);
                                @endphp
                                <x-pie-chart-component
                                    title="Survey Apakah Diminta Imbalan dalam bertransaksi di bank sumut"
                                    :sur="$dimintaimbalan" id="dimintaImbalan"></x-pie-chart-component>
                                <x-pie-chart-component title="Survey Pendapat Pelayanan Teller" :sur="$pelayananteller"
                                    id="pelayananTeller"></x-pie-chart-component>
                                <x-pie-chart-component title="Survey Pendapat Kecepatan Transaksi Teller"
                                    :sur="$kecepatanteller" id="kecepatanTeller"></x-pie-chart-component>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        < script src = "https://cdn.jsdelivr.net/npm/chart.js" >
    </script>
    <script>
        const data = @json($data);

        const labels = Object.keys(data); // Semua label unik setelah normalisasi
        const counts = Object.values(data); // Jumlah masing-masing label

        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Jumlah {{ ucwords(str_replace('_', ' ', request('kolom', 'pendapat_tentang_pelayanan_teler'))) }}",
                    data: counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script> --}}
    {{-- </script> --}}
    <script>
        document.getElementById('countries').addEventListener('change', function() {
            // Mengirimkan form secara otomatis
            document.getElementById('formfilter').submit();
        });
        document.getElementById('tampilan').addEventListener('change', function() {
            // Mengirimkan form secara otomatis
            document.getElementById('formfilter').submit();
        });
    </script>

</x-app-layout>
