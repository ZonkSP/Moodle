@extends('layouts.app')

@section('content')
<div class="container h-auto w-auto mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Estadísticas</h2>
    <div id="chartsContainer" class="flex flex-wrap gap-4 justify-center items-center">
        <div class="flex justify-center items-center" style="width: 600px; height: 400px;">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <script id="chart-data" type="application/json">
        @json($data)
    </script>
</div>
@endsection
