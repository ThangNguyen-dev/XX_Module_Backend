@extends('layouts.app')
@extends('layouts.header')
@section('content')
<!-- chart source -->
<link href="{{ asset('public/css/Chart.css') }}" rel="stylesheet">
<script src="{{asset('public/js/Chart.bundle.js')}}"></script>
<script src="{{asset('public/js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('public/js/Chart.js')}}"></script>
<script src="{{asset('public/js/Chart.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/css/Chart.css')}}">
<link rel="stylesheet" href="{{asset('public/css/Chart.min.css')}}">

<script>
    <?= "var colors = " . ($dataChart['colors']) ?>;
    <?= "var colors2 = " . ($dataChart['colors2']) ?>;
    <?= "var lables = " . ($dataChart['labels']) ?>;
    <?= "var vaccinators = " . ($dataChart['vaccinators']) ?>;
    <?= "var capacities = " . ($dataChart['capacities'])  ?>;
</script>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="campaigns/index.html">Manage Campaigns</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{$campaign->name}}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{route('campaign.show', $campaign->id)}}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link active" href="{{route('campaign.report', $campaign->id)}}">Place capacity</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$campaign->name}}</h1>
                </div>
                <span class="h6">{{date('F d, Y', strtotime($campaign->date))}}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Place Capacity</h2>
                </div>
            </div>

            <canvas class="chart" id="chart"></canvas>

        </main>
    </div>
</div>
<script>
    var ctx = document.getElementById('chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: lables,
            datasets: [{
                    label: 'Vaccinator',
                    data: vaccinators,
                    backgroundColor: colors,
                    borderWidth: 1
                },
                {
                    label: 'Capacity',
                    data: capacities,
                    backgroundColor: colors2,
                    borderWidth: 1
                }

            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
@endsection