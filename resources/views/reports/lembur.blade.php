<table>
    <tr>
        <th rowspan="2" colspan="2">
            <h3>Export Report Lembur - {{ $start_date }} -  {{ $end_date }}</h3>
        </th>
    </tr>
</table>
<table style="border: 1px black;">
    <thead>
        <tr>
            <th style="background-color:#DCDCDC">NIK</th>
            <th style="background-color:#DCDCDC">Name</th>
            <th style="background-color:#DCDCDC">PT.</th>
            <th style="background-color:#DCDCDC">Branch</th>
            <th style="background-color:#DCDCDC">Selected Date</th>
            <th style="background-color:#DCDCDC">Durasi Before</th>
            <th style="background-color:#DCDCDC">Durasi After</th>
            <th style="background-color:#DCDCDC">Status</th>
            <th style="background-color:#DCDCDC">Filing date</th>
            <th style="background-color:#DCDCDC">Approve Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $item)
        <tr>
            <td>{{ $item->user->nik }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->user->organization->name }}</td>
            <td>{{ $item->user->location->name }}</td>
            <td>{{ date('Y-m-d', strtotime($item->selected_date))  }}</td>
            <td>{{ $item->overtime_duration_before ??0  }}</td>
            <td>{{ $item->overtime_duration_after ?? 0 }}</td>
            <td>@if ($item->approve == 0) Pending @elseif ($item->approve == 1) Approved @else Cancel @endif </td>
            <td>{{  date('Y-m-d', strtotime($item->request_date))   }}</td>
            <td>{{  date('Y-m-d', strtotime($item->approve_date)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
