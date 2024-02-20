<table>
    <tr>
        <th rowspan="2" colspan="2">
            <h3>Export Report Data Employee </h3>
        </th>
    </tr>
</table>
<table style="border: 1px black;">
    <thead>
        <tr>
            <th style="background-color:#DCDCDC">ID</th>
            <th style="background-color:#DCDCDC">NIK</th>
            <th style="background-color:#DCDCDC">Name</th>
            <th style="background-color:#DCDCDC">Email</th>
            <th style="background-color:#DCDCDC">Phone</th>
            <th style="background-color:#DCDCDC">PT.</th>
            <th style="background-color:#DCDCDC">Branch</th>
            <th style="background-color:#DCDCDC">Level</th>
            <th style="background-color:#DCDCDC">Division</th>
            <th style="background-color:#DCDCDC">Department</th>
            <th style="background-color:#DCDCDC">Job Position</th>
            <th style="background-color:#DCDCDC">Join Date</th>
            <th style="background-color:#DCDCDC">End Date</th>
            <th style="background-color:#DCDCDC">Resign Date</th>
            <th style="background-color:#DCDCDC">Status</th>
            <th style="background-color:#DCDCDC">Birth Date</th>
            <th style="background-color:#DCDCDC">Birth Place</th>
            <th style="background-color:#DCDCDC">Citizen ID Address</th>
            <th style="background-color:#DCDCDC">Residential Address</th>
            <th style="background-color:#DCDCDC">NPWP</th>
            <th style="background-color:#DCDCDC">PKTP Status</th>
            <th style="background-color:#DCDCDC">Religion</th>
            <th style="background-color:#DCDCDC">Gender</th>
            <th style="background-color:#DCDCDC">Martial status</th>
            <th style="background-color:#DCDCDC">Approval Line</th>
            <th style="background-color:#DCDCDC">Manager</th>
            <th style="background-color:#DCDCDC">Grade</th>
            <th style="background-color:#DCDCDC">Golongan</th>
            <th style="background-color:#DCDCDC">Emergency Name</th>
            <th style="background-color:#DCDCDC">Emergency Number</th>
            <th style="background-color:#DCDCDC">Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $x)
        <tr>
            <td>{{ $x->id }}</td>
            <td>{{ $x->nik }}</td>
            <td>{{ $x->name }} </td>
            <td>{{ $x->email }}</td>
            <td>{{ $x->mobile_phone }}</td>
            <td>{{ $x->organization }}</td>
            <td>{{ $x->location }}</td>
            <td>{{$x->level}}</td>
            <td>{{ $x->division }}</td>
            <td>{{ $x->department }}</td>
            <td>{{ $x->level . '-'. $x->position}}</td>
            <td>{{$x->join_date}}</td>
            <td>{{$x->end_date}}</td>
            <td>{{$x->resign_date}}</td>
            <td>{{$x->status_employee}}</td>
            <td>{{$x->birth_date}}</td>
            <td>{{$x->birth_place}}</td>
            <td>{{$x->citizen_id_address}}</td>
            <td>{{$x->resindtial_address}}</td>
            <td>{{$x->NPWP}}</td>
            <td>{{$x->PKTP_status}}</td>
            <td>{{$x->religion}}</td>
            <td>{{$x->gender}}</td>
            <td>{{$x->marital_status}}</td>
            <td>{{$x->approval_line}}</td>
            <td>{{$x->manager}}</td>
            <td>{{$x->grade}}</td>
            <td>{{$x->golongan}}</td>
            <td>{{$x->emergency_name}}</td>
            <td>{{$x->emergency_number}}</td>
            <td>@if ($x->active == 0) In Active @else Active @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>
