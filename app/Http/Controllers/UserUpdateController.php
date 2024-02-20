<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\FileUploadEmployee;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class UserUpdateController extends Controller
{
    public function index()
    {
        return view('user_update.auth-user.login');
    }


    public function login(Request $request)
    {
        $nik = $request->nik;
        $date = $request->tanggal_lahir;
        $user = User::where(['nik' => $nik, 'birth_date' => $date])->first();

        if ($user) {
            return view('user_update.create', compact('user'));
        } else {
            return redirect()->route('up.index')->with('error', 'NIK dan tanggal lahir tidak sesuai');
        }
    }

    public function update_employee(Request $request)
    {

        // $this->validate($request, [
        //     'image.*' => 'mimes:jpg,bmp,png,pdf,docx|max:1024',
        //     'nik' => 'required|unique:users,nik',
        //     'citizen_id' => 'required|min:10|unique:users,citizen_id',
        //     'email' => 'required|string|email|unique:users,email',
        // ]);

        $id_user = $request->id_user;
        $nik = $request->nik;
        $name = $request->name;
        $mobile_phone = $request->mobile_phone;
        $other_phone = $request->other_phone;
        $birth_place = $request->birth_place;
        $birth_date = $request->birth_date;
        $religion = $request->religion;
        $citizen_id = $request->citizen_id;
        $citizen_address = $request->citizen_address;
        $citizen_rt = $request->citizen_rt;
        $citizen_rw = $request->citizen_rw;
        $citizen_kelurahan = $request->citizen_kelurahan;
        $citizen_kecamatan = $request->citizen_kecamatan;
        $citizen_kabupaten = $request->citizen_kabupaten;
        $citizen_provinsi = $request->citizen_provinsi;
        $domisili_address = $request->domisili_address;
        $domisili_rt = $request->domisili_rt;
        $domisili_rw = $request->domisili_rw;
        $domisili_kelurahan = $request->domisili_kelurahan;
        $domisili_kecamatan = $request->domisili_kecamatan;
        $domisili_kabupaten = $request->domisili_kabupaten;
        $domisili_provinsi = $request->domisili_provinsi;
        $marital_status = $request->marital_status;
        $status_ptkp = $request->status_ptkp;
        $npwp = $request->npwp;
        $kk = $request->kk;
        $mother_name = $request->mother_name;
        $other_bank_account = $request->other_bank_account;
        $bank_account = $request->bank_account;

        $user_account_bank = $request->user_account_bank;
        $book_account = $request->file('book_bank_file');
        $ktp_file = $request->file('ktp_file');
        $npwp_file = $request->file('npwp_file');
        $kk_file = $request->file('kk_file');
        $marriage_book_file = $request->file('marriage_book_file');

        if (empty($book_account)) {
            $book_account_upload = null;
        } elseif ($book_account->getClientMimeType() == 'application/pdf') {
            $file_name = 'Bank Account' . '_' . $nik . '.' . $book_account->extension();
            $destination = public_path('/uploads/bank_account');
            $book_account->move($destination, $file_name);
            $book_account_upload = $file_name;
        } else {
            $input['imagename'] = 'Bank Account' . '_' . $nik . '.' . $book_account->extension();
            $destinationPath = public_path('/uploads/bank_account');
            $img = Image::make($book_account->path());
            $img->resize(700, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $book_account_upload = $input['imagename'];
        }


        if (empty($ktp_file)) {
            $ktp_upload = null;
        } elseif ($ktp_file->getClientMimeType() == 'application/pdf') {
            $file_name = 'KTP' . '_' . $nik . '.' . $ktp_file->extension();
            $destination = public_path('/uploads/ktp');
            $ktp_file->move($destination, $file_name);
            $ktp_upload = $file_name;
        } else {
            $input['imagename'] = 'KTP' . '_' . $nik . '.' . $ktp_file->extension();
            $destinationPath = public_path('/uploads/ktp');
            $img = Image::make($ktp_file->path());
            $img->resize(700, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $ktp_upload = $input['imagename'];
        }

        if (empty($npwp_file)) {
            $npwp_upload = null;
        } elseif ($npwp_file->getClientMimeType() == 'application/pdf') {
            $file_name = 'NPWP' . '_' . $nik . '.' . $npwp_file->extension();
            $destination = public_path('/uploads/npwp');
            $npwp_file->move($destination, $file_name);
            $npwp_upload = $file_name;
        } else {
            $input['imagename'] = 'NPWP' . '_' . $nik . '.' . $npwp_file->extension();
            $destinationPath = public_path('/uploads/npwp');
            $img = Image::make($npwp_file->path());
            $img->resize(700, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $npwp_upload = $input['imagename'];
        }

        if (empty($kk_file)) {
            $kk_upload = null;
        } elseif ($kk_file->getClientMimeType() == 'application/pdf') {
            $file_name = 'Kartu Keluarga' . '_' . $nik . '.' . $kk_file->extension();
            $destination = public_path('/uploads/kk');
            $kk_file->move($destination, $file_name);
            $kk_upload = $file_name;
        } else {
            $input['imagename'] = 'Kartu Keluarga' . '_' . $nik . '.' . $kk_file->extension();
            $destinationPath = public_path('/uploads/kk');
            $img = Image::make($kk_file->path());
            $img->resize(700, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $kk_upload = $input['imagename'];
        }


        if (empty($marriage_book_file)) {
            $marriage_book_upload = null;
        } elseif ($marriage_book_file->getClientMimeType() == 'application/pdf') {
            $file_name = 'Buku Nikah' . '_' . $nik . '.' . $marriage_book_file->extension();
            $destination = public_path('/uploads/marriage_book');
            $marriage_book_file->move($destination, $file_name);
            $marriage_book_upload = $file_name;
        } else {
            $input['imagename'] = 'Buku Nikah' . '_' . $nik . '.' . $marriage_book_file->extension();
            $destinationPath = public_path('/uploads/marriage_book');
            $img = Image::make($marriage_book_file->path());
            $img->resize(700, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $marriage_book_upload = $input['imagename'];
        }

        $employee = Employee::create([
            'nik' => $nik,
            'name' => $name,
            'phone' => $mobile_phone,
            'other_phone' => $other_phone,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'religion' => $religion,
            'citizen_id' => $citizen_id,
            'marital_status' => $marital_status,
            'status_ptkp' => $status_ptkp,
            'npwp' => $npwp,
            'kk' => $kk,
            'mother_name' => $mother_name,
        ]);


        $addresses = [];
        $addresses = [
            'citizen' => [
                'id_employee' => $id_user,
                'address' => $citizen_address,
                'rt' => $citizen_rt,
                'rw' => $citizen_rw,
                'kelurahan' => $citizen_kelurahan,
                'kecamatan' => $citizen_kecamatan,
                'kabupaten' => $citizen_kabupaten,
                'provinsi' => $citizen_provinsi,
                'type' => 'citizen'
            ],
            'domisili' => [
                'id_employee' => $id_user,
                'address' => $domisili_address,
                'rt' => $domisili_rt,
                'rw' => $domisili_rw,
                'kelurahan' => $domisili_kelurahan,
                'kecamatan' => $domisili_kecamatan,
                'kabupaten' => $domisili_kabupaten,
                'provinsi' => $domisili_provinsi,
                'type' => 'domisili'
            ],
        ];
        Address::insert($addresses);


        if (empty($other_bank_account)) {
            $bank_name = 'BCA';
        } else {
            $bank_name = $other_bank_account;
        }

        $account_bank = BankAccount::create([
            'id_employee' => $id_user,
            'account_number' => $bank_account,
            'bank_name' => $bank_name,
            'user_account_bank' => $user_account_bank,
        ]);

        $file_upload = [];
        $file_upload = [
            'book_account' => [
                'id_employee' => $id_user,
                'type' => 'book_account',
                'file_name' => $book_account_upload

            ],
            'ktp' => [
                'id_employee' => $id_user,
                'type' => 'ktp',
                'file_name' => $ktp_upload

            ],
            'npwp' => [
                'id_employee' => $id_user,
                'type' => 'npwp',
                'file_name' => $npwp_upload

            ],
            'kk' => [
                'id_employee' => $id_user,
                'type' => 'kartu_keluarga',
                'file_name' => $kk_upload

            ],
            'marriage_book' => [
                'id_employee' => $id_user,
                'type' => 'marriage_book',
                'file_name' => $marriage_book_upload

            ],

        ];

        FileUploadEmployee::insert($file_upload);

        return view('user_update.finish');
    }

}
