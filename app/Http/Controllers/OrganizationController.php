<?php

namespace App\Http\Controllers;

use App\Helpers\ImageIntervention;
use App\Imports\OrganizationImport;
use App\Models\Department;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OrganizationController extends Controller
{
    public function index()
    {
        $data = Organization::get();
        return view('organization.index', ['data' => $data]);
    }

    public function show($id)
    {
        $data = Organization::with('user')->findOrFail($id);
        $y = User::get();
        $y =  ImageIntervention::userFormat($y);
        $user = $y->where('organization_id', $id);
        $whereNotIn = 0;
        // $whereNotIn = $y->whereNotIn('organization_id', [$id])->where('active', 1);
        return view('organization.show', ['data' => $data,'user'=>  $user, 'all' => $whereNotIn,]);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        Organization::create($request);
        return redirect(route('organization.index'));
    }

    public function update(Request $request, $id)
    {
        $location = Organization::findOrFail($id);
        $location->update($request->all());
        return redirect(route('organization.index'));
    }

    public function edit_organization($id, Request $request)
    {
        $user = $request->user_id;
        foreach ($user as $key => $value) {
            $data =  User::findOrFail($value);
            $data->update([
                $data->organization_id = $id
            ]);
        }
        return redirect(route('organization.show', $id));
    }



}
