@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Internal Memo')

@section('breadcrumb')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Internal Memo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6">
                            <h3 class="text" style="font-weight: bold; margin:0 ">Internal Memo</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                            @can('create-internal-memo', Auth::user())
                                <a href="{{ route('internal_memo.create') }}" class="button" style="color: #fff; font-weight:500"> Create</a>
                            @endcan
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="DataTable" class="table table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Author</th>
                                            <th>Title</th>
                                            <th>Created_at</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $x)
                                            <tr onclick="redirect('{{ route('internal_memo.show', $x->id) }}')">
                                                <td>{{ $x->user->name }}</td>
                                                <td>{{ $x->title }}</td>
                                                <td>{{ $x->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    @if ($x->publish == 0)
                                                        <i class="fas fa-exclamation-circle rounded-circle mr-1" style="color: #f1b53d"></i>
                                                        Draft
                                                    @elseif ($x->publish == 1)
                                                        <i class="fas fa-check-circle rounded-circle mr-1" style="color: rgb(36, 194, 57)"></i>
                                                        Published
                                                    @endif
                                                </td>
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
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#DataTable').DataTable();
        });

        function redirect(url) {
            window.location.href = url;
        }
    </script>
@endpush
