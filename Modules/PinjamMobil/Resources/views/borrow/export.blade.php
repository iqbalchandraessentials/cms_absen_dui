<table>
    <tr>
        <th rowspan="2" colspan="2">
            <h3>Export Report</h3>
        </th>
    </tr>
</table>
<table style="border: 1px black;">
    <thead>
        <tr>

            <th style="background-color:#DCDCDC">Request Date</th>
            <th style="background-color:#DCDCDC">Requested by</th>
            <th style="background-color:#DCDCDC">Department</th>
            <th style="background-color:#DCDCDC">Position</th>
            <th style="background-color:#DCDCDC">Vehicles</th>
            <th style="background-color:#DCDCDC">Start Date</th>
            <th style="background-color:#DCDCDC">End Date</th>
            <th style="background-color:#DCDCDC">Fom</th>
            <th style="background-color:#DCDCDC">To</th>
            <th style="background-color:#DCDCDC">Driver</th>
            <th style="background-color:#DCDCDC">Status</th>
            <th style="background-color:#DCDCDC">Cost Center:</th>
            <th style="background-color:#DCDCDC">Last KM:</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $y)
        <tr>
            <td>{{ date('Y-m-d', strtotime($y['request_date'])) }}</td>
            <td> {{ $y['users']['name'] }} </td>
            <td> {{ $y['users']['department']['name'] }} </td>
            <td> {{ $y['users']['position']['name'] }} </td>
            <td>{{ $y['vehicles']['type'] }}</td>
            <td>{{ $y['start_date'] }} </td>
            <td>{{ $y['end_date'] }}</td>
            <td>{{ $y['from'] }}</td>
            <td>{{ $y['to'] }}</td>
            <td>{{ $y['drivers']['name'] ?? '-' }}</td>
                @php
                $status = $y['status_mobil'];
                @endphp
                @if($status == 0)
                    <td> Menunggu approval atasan</td>
                @elseif($status == 1)
                    <td> Menunggu approval GA</td>
                @elseif($status == 2)
                    <td> Disetujui GA</td>
                @elseif($status == 3)
                    <td> Dibatalkan</td>
                @elseif($status == 4)
                    <td> Menunggu pengembalian</td>
                @elseif($status == 5)
                    <td> Selesai</td>
                @else
                    <td> Status tidak dikenali</td>
                @endif
            <td>{{ $y['cost_center'] }}</td>
            <td>{{ $y['km_history']['next_km'] ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
