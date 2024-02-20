@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
@section('title', 'Internal Memo')

@section('content')
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row ">
                        <div class=" col-12">
                            <div class="row">

                                <div class="col-6">
                                    <h3 class="text" style="font-weight: bold; margin:0 "> Internal Memo
                                        <a class="btn btn-sm btn-dark dropdown-toggle px-2" href="#" role="button"
                                            data-toggle="dropdown" aria-expanded="false">
                                            @if ($data->publish == 0)
                                                <i class="fas fa-exclamation-circle rounded-circle mr-1"
                                                    style="color: #e18916"></i>
                                                Draft
                                            @elseif ($data->publish == 1)
                                                <i class="fas fa-check-circle rounded-circle mr-1"
                                                    style="color: rgb(36, 194, 57)"></i>
                                                Published
                                            @endif
                                        </a>
                                        @if ($data->publish == 0)
                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(169px, 54px, 0px);">
                                                <p class="dropdown-item">
                                                    <a type="button" class="btn btn-danger btn-round btn-sm text-sm "
                                                        href="{{ route('publish.memo', $data->id) }}">Publish</a>
                                                </p>
                                            </div>
                                        @endif
                                    </h3>
                                </div>
                                @if ($data->publish == 0)
                                <div class=" col-md-6 col-lg-6 mt-2" style="text-align: right; display:inline-block">
                                    @can('edit-internal-memo', Auth::user())
                                    <button type="button" class="btn btn-sm waves-effect"
                                        style="background-color: #47708F; color:white" data-toggle="modal"
                                        data-target="#modal-edit-data" id="edit-data">Edit</button>
                                    @endcan
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Title</td>
                                        <td> {{ $data->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Author</td>
                                        <td>{{ $data->user->name }}</td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td>Created Date</td>
                                        <td> {{ date('d-M-Y H:i A', strtotime($data->created_at)) }} </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td> {!! $data->description !!} </td>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <b>Attachment :</b>
                        <div class="row mt-5 mb-5">

                            @forelse ($data->attachment as $x)
                                <div class="col-12">
                                    <a href="{{ asset('uploads/announcment/' . $x->upload_file) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        {{ $x->upload_file }}
                                    </a>
                                </div>
                            @empty
                                <div class=" col text-center">
                                    <b> no attachment </b>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-center" id="modal-edit-data" tabindex="-1" role="dialog"
        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('internal_memo.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input class="form-control" name="title" value="{{ $data->title }}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="resindtial_address">Description</label>
                            <textarea id="editor" class="form-control" name="description" required rows="4" cols="50">{{ $data->description }}</textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log('Editor initialized successfully!');
            })
            .catch(error => {
                console.error('Error initializing the editor:', error);
            });
    </script>
@endpush
