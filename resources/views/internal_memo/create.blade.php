@extends('layouts.app')
@push('css')

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    </head>
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
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form id="basic-form" method="post" action="{{ route('internal_memo.store') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <h3>Internal Memo</h3>
                            <section>
                                <h5 class="mb-0">Internal Memo</h5>
                                <p>provide your co-workers and managers with information on projects, goals, deadlines,
                                    problems and other topics.</p>
                                <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <div class="form-group has-validation">
                                            <label for="title">Title<span class="text-danger">*</span></label>
                                            <div>
                                                <input class="form-control" required value="{{ old('title') }}"
                                                    name="title" type="text" id="title">
                                            </div>
                                            @if ($errors->has('title'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFileSm" class="form-label">Attachment</label>
                                            <input class="form-control" name="upload_file[]" id="formFileSm" type="file">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-12">
                                            <div class="form-group has-validation">
                                                <label for="publish">Save Type<span class="text-danger">*</span></label>
                                                <select id="publish" required name="publish" class="form-control">
                                                    <option value="">Choose..</option>
                                                    <option value="1">Save & Publish</option>
                                                    <option value="0">Save as Draft</option>
                                                </select>
                                                @if ($errors->has('publish'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('publish') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group clearfix">
                                                <label for="approval_line_id">Announce To :</label>
                                                <select id="receipt_dept" required name="receipt_dept[]"
                                                    class="form-control selectpicker" multiple data-live-search="true">
                                                    <option value="all">All</option>
                                                    @foreach ($department as $x)
                                                        <option value="{{ $x->id }}"> {{ $x->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="resindtial_address">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea id="editor" name="description" required rows="4" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
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
