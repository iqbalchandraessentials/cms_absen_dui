<table>
    <tr>
        <th rowspan="2" colspan="2">
            <h3>Export Report Cuti Tahunan </h3>
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
            <th style="background-color:#DCDCDC">Kuota Cuti</th>
            <th style="background-color:#DCDCDC">Sisa Cuti</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->user->nik }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->user->organization->name }}</td>
            <td>{{ $item->user->location->name }}</td>
            <td>{{ $item->kuota_cuti }}</td>
            <td>{{ $item->sisa_cuti }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
