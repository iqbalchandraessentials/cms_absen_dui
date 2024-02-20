<table>
    <tr>
        <th rowspan="2" colspan="2">
            <h3>Export Report Data Absent - {{ $start_date }} - {{ $end_date }}</h3>
        </th>
    </tr>
</table>
<table style="border: 1px black;">
    <thead>
        <tr>
            <th>Date</th>
            <th>Date In</th>
            <th>Date Out</th>
            <th>Name</th>
            <th>Nik</th>
            <th>Organization</th>
            <th>Division</th>
            <th>Department</th>
            <th>Position</th>
            <th>Level</th>
            <th>Shift Name</th>
            <th>Schedule In</th>
            <th>Schedule Out</th>
            <th>Clock In</th>
            <th>Clock Out</th>
            <th>Overtime</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $userId => $userData)
            @foreach ($userData as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->date_in }}</td>
                    <td>{{ $item->date_out }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->organization_name }}</td>
                    <td>{{ $item->division_name }}</td>
                    <td>{{$item->department_name}}</td>
                    <td>{{ $item->job_position }}</td>
                    <td>{{ $item->job_level }}</td>
                    <td>{{ $item->shift_name }} </td>
                    <td>{{ $item->schedule_in }}</td>
                    <td>{{ $item->schedule_out }}</td>
                    @if ($item->img_check_in == 'request_attendance')
                        <td style="background-color:#FFFF00">{{ $item->check_in }}</td>
                    @else
                        <td>{{ $item->check_in }}</td>
                    @endif
                    @if ($item->img_check_out == 'request_attendance')
                        <td style="background-color:#FFFF00">{{$item->check_out}}</td>
                    @else
                        <td>{{ $item->check_out }}</td>
                    @endif
                    @if (isset($item->overtime_before) || isset($item->overtime_after))
                        <td>{{ $item->overtime_before }} - {{$item->overtime_after}}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
