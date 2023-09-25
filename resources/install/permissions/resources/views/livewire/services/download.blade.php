<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Order - Flight {{ $selectedFlight->flight_no }} - {{ $selectedFlight->registration }}</title>
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            border: 1px solid black;
            margin: 0;
            padding: 0;
        }

        .card-body {
            padding-left: 10px;
            padding-right: 10px;
            border: 1px solid #dee2e6;
        }

        .table-responsive {
        overflow-x: auto;
        }

        .text-end {
            text-align: right;
        }

        table {
        width: 100%;
        margin-bottom: 0;
        color: #333;
        background-color: transparent;
        border-collapse: collapse;
        }

        thead th {
        text-align: left;
        border-bottom: 1px solid #dee2e6;
        }

        th, td {
        padding: .3rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        }

        td[colspan="100%"] {
        text-align: center;
        }
    </style>
</head>
<body>
    <div class="card-body">
        <div style="text-align: center; margin: 1rem;">
            <h3 style="margin: 1px;"> {{ $selectedFlight->flight_no }} - {{ $selectedFlight->registration }}</h3>
            {{ $selectedFlight->destination }} {{ date('H:i', strtotime($selectedFlight->scheduled_time_arrival)) }}
            {{ $selectedFlight->origin }} {{ date('H:i', strtotime($selectedFlight->scheduled_time_departure)) }} <br>
            Work-Oder No: {{ preg_replace('/\b(\w)\w*\s*/', '$1', ucwords(config('app.name', 'Laravel'))) }}{{ str_pad($selectedFlight->id, 6, '0', STR_PAD_LEFT) }} <br>
            Date: {{ $selectedFlight->created_at->format('d M, Y') }}
        </div>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Duration</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($selectedFlight->service as $index => $value )
                    <tr>
                        <td>{{ $index + 1 }}. {{ $value->service->service }}</td>
                        <td>{{ $value->start }}</td>
                        <td>{{ $value->finish }}</td>
                        <td>{{ date('H:i', strtotime($value->finish) - strtotime($value->start)) }}</td>
                        <td class="text-end">{{ $value->service->price. " $" }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100%">No Services for this flight Yet</td>
                    </tr>
                    @endforelse
                    @if(count($selectedFlight->service) > 0)
                    <tr>
                        <td colspan="3"><strong>Total Services</strong></td>
                        <td colspan="1"><strong>{{ count($selectedFlight->service) }} Services</strong></td>
                        <td colspan="1" class="text-end"><strong>{{ $selectedFlight->service->sum(function ($service) { 
                            return $service->service->price;
                            }) }} $</strong>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>    
</body>
</html>