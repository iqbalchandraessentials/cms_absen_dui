<?php

namespace App\Http\Controllers;

use App\Helpers\ImageIntervention;
use App\Imports\LocationImport;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{

    public function index()
    {
        $data = Location::get();
        return view('location.index', ['data' => $data]);
    }

    public function show($id)
    {
        $data = Location::findOrFail($id);
        $y = User::get();
        $count = $y->where('location_id', $id)->count();
        $y =  ImageIntervention::userFormat($y);
        $user = $y->where('location_id', $id);
        // $whereNotIn = $y->where('active', 1)->whereNotIn('location_id', [$id]);
        $whereNotIn = 0;

        return view('location.show', ['data' => $data, 'user' => $user, 'total' => $count, 'all' => $whereNotIn, 'id' => $id]);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        Location::create($request);
        return redirect(route('location.index'));
    }

        public function update(Request $request, $id)
        {
            $location = Location::findOrFail($id);
            $location->update($request->all());
            return redirect(route('location.show', $id));
        }

    public function edit_location($id, Request $request)
    {
        $user = $request->user_id;
        foreach ($user as $key => $value) {
            $data =  User::find($value);
            $data->update([
                $data->location_id = $id
            ]);
        }
        return redirect(route('location.show', $id));
    }



    public function import_excel(Request $request)
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

        Excel::import(new LocationImport, request()->file('file'));

		// notifikasi dengan session
		Session::flash('sukses','Location has successfully import');

		// alihkan halaman kembali
        return redirect(route('location.index'));
	}

}
