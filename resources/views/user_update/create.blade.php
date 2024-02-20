<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Form Karyawan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('style/dist/assets/images/icon.png') }}">

    <!-- App css -->
    <link href="{{ asset('style/dist/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('style/dist/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/dist/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <!-- Plugins css -->
    <link href="{{ asset('style/dist/assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('style/dist/assets/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/dist/assets/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- picker --}}
    <link href="{{ asset('style/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/dist/assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('style/dist/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet') }}" type="text/css" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @stack('css')
</head>

<body>
    <header id="topnav">
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="dropdown notification-list">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="" class="logo text-center logo-dark">
                        <span class="logo-lg">
                            <img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="40">
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="24">
                        </span>
                    </a>

                    <a href="" class="logo text-center logo-light">
                        <span class="logo-lg">
                            <img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="40">
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('style/dist/assets/images/icon.png') }}" alt="" height="24">
                        </span>
                    </a>
                </div>
            </div> <!-- end container-fluid-->
        </div>

    </header>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form id="basic-form" method="post" action="{{ route('up.update_employee') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf

                                <div>
                                    <h3>Personal data</h3>
                                    <section>
                                        <h5 class="mb-0">Personal data</h5>
                                        <p>Fill all employee personal basic information data </p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>NIK (Nomor Induk Karyawan)<span class="text-danger">*</span></label>
                                                    <div>
                                                        <input id="nik" name="nik" type="text" class="form-control" value="{{ $user->nik }}">
                                                        <input id="id_user" name="id_user" type="text" class="form-control" value="{{ $user->id }}" hidden>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nama Lengkap (Sesuai dengan KTP)<span class="text-danger">*</span></label>
                                                    <input id="name" name="name" type="text" class="form-control" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Hp.<span class="text-danger">*</span></label>
                                                    <input id="mobile_phone" name="mobile_phone" type="text" class="form-control" value="{{ $user->mobile_phone }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor yang terhubung dengan aplikasi Whatsapp<span class="text-danger">*</span></label>
                                                    <input id="other_phone" name="other_phone" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tempat Lahir<span class="text-danger">*</span></label>
                                                    <input id="birth_place" name="birth_place" type="text" class="form-control" value="{{ $user->birth_place }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir<span class="text-danger">*</span></label>
                                                    <input id="birth_date" name="birth_date" type="date" class="form-control" value="{{ $user->birth_date }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Agama<span class="text-danger">*</span></label>
                                                    <select id="religion" name="religion" class="form-control">
                                                        <option value="" {{ empty($user->religion) ? 'selected' : '' }}>Choose...</option>
                                                        @php
                                                            $religions = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                                                        @endphp
                                                        @foreach ($religions as $religion)
                                                            <option value="{{ $religion }}" {{ $user->religion == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Induk Kependudukan (KTP)<span class="text-danger">*</span></label>
                                                    <input id="citizen_id" name="citizen_id" type="text" class="form-control" value="{{ $user->citizen_id }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Alamat KTP<span class="text-danger">*</span></label>
                                                    <textarea name="citizen_address" id="citizen_address" rows="5" class="form-control">{{ $user->citizen_id_address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>RT<span class="text-danger">*</span></label>
                                                    <input id="citizen_rt" name="citizen_rt" type="text" class="form-control" value="{{ $user->rt_id ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>RW<span class="text-danger">*</span></label>
                                                    <input id="citizen_rw" name="citizen_rw" type="text" class="form-control" value="{{ $user->rw_id ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kelurahan<span class="text-danger">*</span></label>
                                                    <input id="citizen_kelurahan" name="citizen_kelurahan" type="text" class="form-control" value="{{ $user->kelurahan_id ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kecamatan<span class="text-danger">*</span></label>
                                                    <input id="citizen_kecamatan" name="citizen_kecamatan" type="text" class="form-control" value="{{ $user->kecamatan_id ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kabupaten<span class="text-danger">*</span></label>
                                                    <input id="citizen_kabupaten" name="citizen_kabupaten" type="text" class="form-control" value="{{ $user->kabupaten_id ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Provinsi<span class="text-danger">*</span></label>
                                                    <input id="citizen_provinsi" name="citizen_provinsi" type="text" class="form-control" value="{{ $user->provinsi_id ?? '-' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Alamat Domisili<span class="text-danger">*</span></label>
                                                    <textarea name="domisili_address" id="domisili_address" rows="5" class="form-control">{{ $user->resindtial_address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>RT<span class="text-danger">*</span></label>
                                                    <input id="domisili_rt" name="domisili_rt" type="text" class="form-control" value="{{ $user->domisili_rt ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>RW<span class="text-danger">*</span></label>
                                                    <input id="domisili_rw" name="domisili_rw" type="text" class="form-control" value="{{ $user->domisili_rw ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Kelurahan<span class="text-danger">*</span></label>
                                                    <input id="domisili_kelurahan" name="domisili_kelurahan" type="text" class="form-control" value="{{ $user->domisili_kelurahan ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Kecamatan<span class="text-danger">*</span></label>
                                                    <input id="domisili_kecamatan" name="domisili_kecamatan" type="text" class="form-control" value="{{ $user->domisili_kecamatan ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Kabupaten<span class="text-danger">*</span></label>
                                                    <input id="domisili_kabupaten" name="domisili_kabupaten" type="text" class="form-control" value="{{ $user->domisili_kabupaten ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Provinsi<span class="text-danger">*</span></label>
                                                    <input id="domisili_provinsi" name="domisili_provinsi" type="text" class="form-control" value="{{ $user->domisili_provinsi ?? '-' }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Status Perkawinan<span class="text-danger">*</span></label>
                                                    <select id="marital_status" name="marital_status" class="form-control">
                                                        <option value="" {{ empty($user->marital_status) ? 'selected' : '' }}>Choose...</option>
                                                        @php
                                                            $marital_status_all = ['Belum Kawin', 'Kawin ', 'Duda', 'Janda'];
                                                        @endphp
                                                        @foreach ($marital_status_all as $marital_status)
                                                            <option value="{{ $marital_status }}" {{ $user->marital_status == $marital_status ? 'selected' : '' }}>{{ $marital_status }}</option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-validation">
                                                    <label>Status PTKP<span class="text-danger">*</span></label>
                                                    <select id="status_ptkp" name="status_ptkp" class="form-control">
                                                        <option value="" selected>Choose...</option>
                                                        <option value="TK-0 (Tidak Kawin)">TK-0 (Tidak Kawin)</option>
                                                        <option value="TK-1 (Tidak Kawin dengan 1 Anak)">TK-1 (Tidak Kawin dengan 1 Anak)</option>
                                                        <option value="TK-2 (Tidak Kawin dengan 2 Anak)">TK-2 (Tidak Kawin dengan 2 Anak)</option>
                                                        <option value="TK-3 (Tidak Kawin dengan 3 Anak atau Lebih)">TK-3 (Tidak Kawin dengn 3 Anak atau Lebih)</option>
                                                        <option value="K-0 (Kawin)">K-0 (Kawin)</option>
                                                        <option value="K-1 (Kawin dengan 1 Anak)">K-1 (Kawin dengan 1 Anak)</option>
                                                        <option value="K-2 (Kawin dengan 2 Anak)">K-2 (Kawin dengan 2 Anak)</option>
                                                        <option value="K-3 (Kawin dengan 3 Anak atau Lebih)">K-3 (Kawin dengan 3 Anak atau Lebih)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor NPWP<span class="text-danger">*</span></label>
                                                    <input id="npwp" name="npwp" type="text" class="form-control" value="{{ $user->NPWP ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Kartu Keluarga<span class="text-danger">*</span></label>
                                                    <input id="kk" name="kk" type="text" class="form-control" value="{{ $user->kartu_keluarga ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nama Ibu Kandung<span class="text-danger">*</span></label>
                                                    <input id="mother_name" name="mother_name" type="text" class="form-control" value="{{ $user->mother_name ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Apakah anda memiliki rekening BCA ?<span class="text-danger">*</span></label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input option_bca" type="radio" name="option_rek_bca" id="rek_bca_yes" value="yes">
                                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input option_bca" type="radio" name="option_rek_bca" id="rek_bca_no" value="no">
                                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        {{-- Employment data --}}
                                    </section>


                                    <h3>Rekening BCA</h3>
                                    <section>
                                        <h5 class="mb-0">Info rekening</h5>
                                        <p>Fill all data information</p>

                                        <div class="row">
                                            <div class="col-sm-6 other_bank_input">
                                                <div class="form-group">
                                                    <label>Nama bank selain BCA</label>
                                                    <input id="other_bank_account" name="other_bank_account" type="text" value="{{ $user->other_bank_name }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Rekening</label>
                                                    <input id="bank_account" name="bank_account" type="text" class="form-control" value="{{ $user->norek }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nama Pemilik Rekening</label>
                                                    <input id="user_account_bank" name="user_account_bank" type="text" class="form-control" value="{{ $user->user_account_bank }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Foto Buku Rekening<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="book_bank_file" name="book_bank_file">
                                                    <p class="mb-0 mt-3" style="font-size:12px"><span class="text-danger">*</span>Format image: jpeg, png, jpg.</p>
                                                    <p class="mt-0" style="font-size:12px"><span class="text-danger">*</span>File pdf yang diunggah maksimal 1MB.</p>

                                                </div>
                                            </div>
                                        </div>
                                    </section>


                                    <h3>Berkas Pendukung</h3>
                                    <section>
                                        <h5 class="mb-0">Berkas Pendukung</h5>
                                        <p>Upload file</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group clearfix">
                                                    <label>KTP<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="ktp_file" name="ktp_file" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group clearfix">
                                                    <label>NPWP<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="npwp_file" name="npwp_file" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group clearfix">
                                                    <label>Kartu Keluarga<span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" id="kk_file" name="kk_file" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group clearfix">
                                                    <label>Buku Nikah</label>
                                                    <input type="file" class="form-control" id="marriage_book_file" name="marriage_book_file" required>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mb-0" style="font-size:12px"><span class="text-danger">*</span>Format image: jpeg, png, jpg.</p>
                                        <p class="mt-0" style="font-size:12px"><span class="text-danger">*</span>File pdf yang diunggah maksimal 1MB.</p>

                                    </section>
                                    <h3>Finish</h3>
                                    <section>
                                        <div class="form-group clearfix row">
                                            <div class="col-lg-12">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox-h" type="checkbox">
                                                    <label for="checkbox-h">
                                                        I agree with the <a href="#">Terms and Conditions</a>.
                                                    </label>
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
        </div> <!-- end container-fluid -->
    </div>
    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    2022 - 2023 &copy; DieselOneGroup
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

    <!-- Vendor js -->
    <script src="{{ asset('style/dist/assets/js/vendor.min.js') }}"></script>

    <!-- Dashboard init js-->
    <script src="{{ asset('style/dist/assets/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('style/dist/assets/js/app.min.js') }}"></script>

    <!-- Plugins Js -->
    <script src="{{ asset('style/dist/assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/multiselect/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/jquery-quicksearch/jquery.quicksearch.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/autocomplete/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <!-- plugins -->
    <script src="{{ asset('style/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>

    <!--Form Wizard-->
    <script src="{{ asset('style/dist/assets/libs/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('style/dist/assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>

    <!-- Init js-->
    <script src="{{ asset('style/dist/assets/js/pages/form-wizard.init.js') }}"></script>
</body>
<script>
    $(document).ready(function() {
        $(document).on('change', '.option_bca', function() {
            console.log($(this).val());
            if ($(this).val() === 'yes') {
                $('.other_bank_input').hide();
            } else {
                $('.other_bank_input').show();
            }
        });
    });
</script>

</html>
