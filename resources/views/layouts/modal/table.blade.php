
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="DataTable" class="table DataTable table-striped table-hover"
                                style="font-size:12px; border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Date join</th>
                                            <th>End join</th>
                                            <th>Posisi</th>
                                            <th>Level</th>
                                            <th>Grade</th>
                                            <th>Golongan</th>
                                            <th>Department</th>
                                            <th>Divisi</th>
                                            <th>Organization</th>
                                            <th>Location</th>
                                        </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->user as $c)
                                        <tr>
                                            <td><a href="{{route('employee.show', $c->id)}}"> {{ $c->nik }} </td>
                                            <td>{{ $c->name }} {{$c->active == 0 ? '❌' : '' }}  </td>
                                            <td>{{$c->status_employee}}</td>
                                            <td>{{$c->join_date}}</td>
                                            <td>{{$c->end_date}}</td>
                                            <td>
                                                @if ($c->level)
                                                {{ $c->level->name }}
                                                @else
                                                -
                                                @endif
                                                -
                                                @if ( $c->position)
                                                {{  $c->position->name }}
                                                @else
                                                -
                                                @endif

                                            </td>
                                            <td>
                                                @if ($c->level)
                                                {{ $c->level->name }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{$c->grade}}</td>
                                            <td>{{$c->golongan}}</td>
                                            <td>{{  isset($c->department->name) ? $c->department->name : '-' }}</td>
                                            <td>{{  isset($c->division->name) ? $c->division->name : '-' }}</td>
                                            <td>{{  isset($c->organization->name) ? $c->organization->name : '-' }}</td>
                                            <td>{{  isset($c->location) ? $c->location->name : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
