<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div>
        MVT</br>
        {{ $mvt->flight->flight_no }}/{{ ($mvt->flight->flight_type == 'arrival') ? 
            date("d", strtotime($mvt->flight->scheduled_time_arrival)) . "." . $mvt->flight->registration . "." . $mvt->flight->destination : 
            date("d", strtotime($mvt->flight->scheduled_time_departure)) . "." . $mvt->flight->registration . "." . $mvt->flight->origin }}</br>
        @if ($mvt->flight->flight_type == 'arrival')
        AA{{ date("Hi", strtotime($mvt->touchdown)) }}/{{ date("Hi", strtotime($mvt->onblocks)) }}</br>
        @else
        AD{{ date("Hi", strtotime($mvt->offblocks)) }}/{{ date("Hi", strtotime($mvt->airborne)) }}
        EA{{ date("Hi", strtotime($mvt->airborne) + strtotime($mvt->flight_time ?? 0)) }} {{ $mvt->flight->destination }}</br>
        @if (empty($outputdelay))  @else {{ "DL". $outputdelay ?? null }}</br> @endif
        PX{{ $mvt->passengers ?? 00 }}</br>
        @if (empty($outputedelay))  @else {{ "EDL" .$outputedelay ?? null }}</br> @endif
        @if (empty($outputdelay))  @else {{ "DLA" .$outputdla ?? null }}</br> @endif
        @if (empty($outputdescription))  @else {!! "SI ". nl2br(e($outputdescription)) ?? null !!}</br> @endif
        @if (empty($mvt->remarks))  @else SI {{ strtoupper($mvt->remarks ?? null) }}</br> @endif
        SI EET {{ date("Hi", strtotime($mvt->flight_time ?? 0)) }} HRS
        @endif
    </div>
</body>
</html>