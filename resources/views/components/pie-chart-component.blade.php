<div class=" col-span-2 p-4 bg-gray-100 rounded-xl">
    <p class="text-center font-semibold">{{$title}}
    </p>
    <canvas id="{{$id}}"></canvas>
</div>
@php
    // dd($sur);
@endphp
<script>
    const {{ $id }} = document.getElementById('{{ $id }}');
    new Chart({{ $id }}, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach ($sur as $tes)
                    "{{ $tes['kecepatan'] }}",
                @endforeach
            ],
            datasets: [{
                labels: '{{$title}}',
                data: [
                    @foreach ($sur as $tes)
                        {{ $tes['jumlah'] }},
                    @endforeach
                ],
                hoverOffset: 4
            }]
        }
    })
</script>
