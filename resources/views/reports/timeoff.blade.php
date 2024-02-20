<table>
    <tr>
        <th rowspan="2" colspan="2">
            <h3>Export Report Timeoff - {{ $start_date }} -  {{ $end_date }}</h3>
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
            <th style="background-color:#DCDCDC">Waktu Pengajuan</th>
            <th style="background-color:#DCDCDC">Start Date</th>
            <th style="background-color:#DCDCDC">End Date</th>
            <th style="background-color:#DCDCDC">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $item)
        <tr>
            <td>{{ $item->user->nik }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->user->organization->name }}</td>
            <td>{{ $item->user->location->name }}</td>
            <td>{{ $item->created_at->format('Y-m-d') }}</td>
            <td>{{ date('Y-m-d', strtotime($item->start_date)) }}</td>
            <td>{{ date('Y-m-d', strtotime($item->start_date)) }}</td>
            <td>@if ($item->approve == 0) Pending @elseif ($item->approve == 1) Approved @else Cancel @endif </td>
        </tr>
        @endforeach
    </tbody>
</table>
