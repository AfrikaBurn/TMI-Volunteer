<?php

use Carbon\Carbon;

?>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2em;
    }

    table, th, td {
        border: 1px solid black;
    }

    thead tr {
        background-color: #434343;
        color: #fff;
    }

    th, td {
        padding: 0.5em 1em;
    }
</style>

@foreach($departments as $department)
    <h1>{{ $department->name }}</h1>

    @foreach($department->shifts()->orderBy('duration', 'desc')->orderBy('start_date')->groupBy('name')->get() as $shift)
        <?php

        $shift_ids = $department->shifts()->where('name', $shift->name)->get()->pluck('id');

        ?>
        <table>
            <thead>
                <tr>
                    <th>{{ $shift->name }}</th>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Username</th>
                    <th>Real Name</th>
                </tr>
            </thead>

            <tbody>
                @foreach($department->slots()->whereIn('shift_id', $shift_ids)->orderBy('start_date')->orderBy('start_time')->get() as $slot)
                    <?php

                    $date = new Carbon($slot->start_date);
                    $day = $date->formatLocalized('%A');
                    $start = strtotime($slot->start_time);
                    $end = strtotime($slot->end_time);

                    ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>{{ $slot->start_date }}</td>
                        <td>{{ $day }}</td>
                        <td>{{ $slot->start_time }} ({{ date("h:i a", $start) }})</td>
                        <td>{{ $slot->end_time }} ({{ date("h:i a", $end) }})</td>
                        <td>
                            @if(count($slot->user))
                                <b>{{ $slot->user->name }}</b>
                            @else
                                OPEN
                            @endif
                        </td>
                        <td><b>{{ $slot->user->data->real_name or '' }}</b></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endforeach
