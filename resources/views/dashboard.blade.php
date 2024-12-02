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
                            <div class="p-4 bg-gray-100 rounded-xl">
                                <p class="text-center font-semibold">Survey Penilaian Pelayanan Customer Service</p>
                                <canvas id="piechart"></canvas>
                            </div>
                            <div class=" col-span-3 p-4 bg-gray-100 rounded-xl">
                                <p class="text-center font-semibold">Survey Penilaian Kecepatan Transaksi Customer
                                    Service
                                </p>
                                <canvas id="kecepatan"></canvas>
                            </div>
                            <div class=" col-span-3 p-4 bg-gray-100 rounded-xl">
                                <p class="text-center font-semibold">Survey Penilaian Penjelasan yang Diberikan Customer
                                    Service
                                </p>
                                <canvas id="penjelasan"></canvas>
                            </div>
                            <div class=" p-4 bg-gray-100 rounded-xl">
                                <p class="text-center font-semibold">Survey Penilaian Kebersihan
                                </p>
                                <canvas id="kebersihan"></canvas>
                            </div>
                            <div class=" col-span-2 p-4 bg-gray-100 rounded-xl">
                                <p class="text-center font-semibold">Survey Penilaian Pelayanan Satpam
                                </p>
                                <canvas id="satpam"></canvas>
                            </div>
                            <div class=" col-span-2 p-4 bg-gray-100 rounded-xl">
                                <p class="text-center font-semibold">Survey Diminta Uang Imbalan
                                </p>
                                <canvas id="imbalan"></canvas>
                            </div>
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
                                <x-pie-chart-component
                                    title="Survey Pendapat Pelayanan Teller"
                                    :sur="$pelayananteller" id="pelayananTeller"></x-pie-chart-component>
                                <x-pie-chart-component
                                    title="Survey Pendapat Kecepatan Transaksi Teller"
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
        @if (($request['filter'] === 'cs' && $request['filter'] !== 'teller') || $request['filter'] === null)
            const pelayanancs = document.getElementById('piechart');
            new Chart(pelayanancs, {
                type: 'doughnut',
                data: {
                    labels: ['Tidak Ramah', 'Kurang Ramah', 'Ramah', 'Sangat Ramah'],
                    datasets: [{
                        labels: 'Bagaiman Pendapat Saudara/i Tentang Pelayanan Yang Diberikan CS: ',
                        data: [{{ $tidakramah }}, {{ $kurangramah }}, {{ $ramah }},
                            {{ $sangatramah }}
                        ],
                        hoverOffset: 4
                    }]
                }
            })
            const kecepatancs = document.getElementById('kecepatan');
            new Chart(kecepatancs, {
                type: 'bar',
                data: {
                    labels: ['2022', '2023', '2024'],
                    datasets: [

                        {
                            label: 'Sangat Lambat',
                            data: [{{ $kecepatantransaksi[0]['jumlah'] }},
                                {{ $kecepatantransaksi[3]['jumlah'] }},
                                {{ $kecepatantransaksi[6]['jumlah'] }}
                            ],
                        }, {
                            label: 'Lambat',
                            data: [{{ $kecepatantransaksi[1]['jumlah'] }},
                                {{ $kecepatantransaksi[4]['jumlah'] }},
                                {{ $kecepatantransaksi[7]['jumlah'] }}
                            ],
                        }, {
                            label: 'Cepat',
                            data: [{{ $kecepatantransaksi[2]['jumlah'] }},
                                {{ $kecepatantransaksi[5]['jumlah'] }},
                                {{ $kecepatantransaksi[8]['jumlah'] }}
                            ],
                        }
                    ]
                }
            })
            const penjelasan = document.getElementById('penjelasan');
            new Chart(penjelasan, {
                type: 'bar',
                data: {
                    labels: ['Jelas', 'Jelas Tetapi Kurang Tepat', 'Kurang Jelas', 'Tidak Jelas'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [{{ $jelas }}, {{ $jelastidaktepat }}, {{ $kurangjelas }},
                            {{ $tidakjelas }}
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(54, 162, 235)',
                            'rgba(255, 206, 86)',
                            'rgba(75, 192, 192)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                    }]
                },
                options: {
                    indexAxis: 'y', // mengatur axis menjadi horizontal
                    scales: {
                        x: {
                            ticks: {
                                display: false,
                            },
                            gridLines: {
                                display: false,
                            },
                            grid: {
                                display: false,
                            },
                            beginAtZero: true
                        },
                        y: {
                            gridLines: {
                                display: false,
                            },
                            grid: {
                                display: false,
                            },
                        }
                    }
                }
            })
            const kebersihan = document.getElementById('kebersihan');
            new Chart(kebersihan, {
                type: 'pie',
                data: {
                    labels: ['Sangat Bersih dan Sangat nyaman', 'Bersih dan Nyaman',
                        'Kurang Bersih dan Tidak Nyaman',
                        'Tidak Bersih dan Tidak Nyaman'
                    ],
                    datasets: [{
                        label: 'Jumlah',
                        data: [{{ $sangatbersih }}, {{ $bersih }}, {{ $kurangbersih }},
                            {{ $tidakbersih }}
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(54, 162, 235)',
                            'rgba(255, 206, 86)',
                            'rgba(75, 192, 192)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // mengatur axis menjadi horizontal
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false,
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            })
            const satpam = document.getElementById('satpam');
            new Chart(satpam, {
                type: 'doughnut',
                data: {
                    labels: ['Ramah dan Sigap', 'Ramah Tetapi Tidak Sigak', 'Tidak Ramah Tetapi Sigap',
                        'Tidak Ramah dan Tidak Sigap'
                    ],
                    datasets: [{
                        label: 'Jumlah',
                        data: [{{ $ramah }}, {{ $ramahtidak }}, {{ $tidakramah }},
                            {{ $tidakramahtidak }}
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(54, 162, 235)',
                            'rgba(255, 206, 86)',
                            'rgba(75, 192, 192)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // mengatur axis menjadi horizontal
                    scales: {
                        x: {
                            display: false,
                            beginAtZero: true
                        },
                        y: {
                            display: false,
                        }
                    }
                }
            })
            const imbalan = document.getElementById('imbalan');
            new Chart(imbalan, {
                type: 'pie',
                data: {
                    labels: ['Ada', 'Tidak Ada'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [{{ $ada }}, {{ $tidak }}],
                        backgroundColor: [
                            'rgba(213, 180, 19, 1)',
                            'rgba(230, 67, 87, 1)'
                        ],
                        borderColor: [],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // mengatur axis menjadi horizontal
                    scales: {
                        x: {
                            display: false,
                            beginAtZero: true
                        },
                        y: {
                            display: false,
                        }
                    }
                }
            })
        @endif
    </script>
</x-app-layout>
