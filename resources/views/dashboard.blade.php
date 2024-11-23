<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-4 gap-6">
                        <div class="p-4 bg-gray-100 rounded-xl">
                            <p class="text-center font-semibold">Survey Penilaian Pelayanan Customer Service</p>
                            <canvas id="piechart"></canvas>
                        </div>
                        <div class=" col-span-3 p-4 bg-gray-100 rounded-xl">
                            <p class="text-center font-semibold">Survey Penilaian Kecepatan Transaksi Customer Service
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
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
                        data: [{{ $kecepatantransaksi[0]['jumlah'] }}, {{ $kecepatantransaksi[3]['jumlah'] }},
                            {{ $kecepatantransaksi[6]['jumlah'] }}
                        ],
                    }, {
                        label: 'Lambat',
                        data: [{{ $kecepatantransaksi[1]['jumlah'] }}, {{ $kecepatantransaksi[4]['jumlah'] }},
                            {{ $kecepatantransaksi[7]['jumlah'] }}
                        ],
                    }, {
                        label: 'Cepat',
                        data: [{{ $kecepatantransaksi[2]['jumlah'] }}, {{ $kecepatantransaksi[5]['jumlah'] }},
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
                        gridLines:{
                            display: false,
                        },
                        grid: {
                            display: false,
                        },
                        beginAtZero: true
                    },
                    y: { 
                        gridLines:{
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
                labels: ['Sangat Bersih dan Sangat nyaman', 'Bersih dan Nyaman', 'Kurang Bersih dan Tidak Nyaman',
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
    </script>
</x-app-layout>
