<div class=" col-span-2 p-4 bg-gray-100 rounded-xl">
    <p class="text-center font-semibold">{{ $title }}
    </p>
    <canvas id="{{ $id }}"></canvas>
</div> 
<script>
    const {{$id}} = document.getElementById('{{ $id }}');

    new Chart({{ $id }}, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($penilai as $tes)

                    "{{ $tes['tahun'] }}",
                @endforeach
            ],
            datasets: [
                @for ($i = 0; $i < count($penilai[0]['data']); $i++)
                    {
                        label: '{{ $penilai[0]['data'][$i]['kecepatan'] }}',
                        data: [
                            @for ($j = 0; $j < 3; $j++)
                                {{ $penilai[$j]['data'][$i]['jumlah'] }},
                            @endfor

                        ],
                    },
                @endfor
            ]
        }
    })
</script>
