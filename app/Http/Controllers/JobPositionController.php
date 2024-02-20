<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function index()
    {
        $data = JobPosition::get();
        return view('job_position.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request = $request->all();
        $job_posisi = JobPosition::create($request);
        return redirect(route('job-position.index'));
    }


    public function edit_job_posisi($id, Request $request)
    {
        $user = $request->user_id;
        foreach ($user as $value) {
            $data =  User::find($value);
            $data->update([
                $data->job_position = $id
            ]);
        }
        return redirect(route('job-position.show', $id));
    }


    public function show($id)
    {
        $data = JobPosition::with('user')->findOrFail($id);
        $user = 0;
        // $user = User::whereNot('job_position', $id)->where('active', 1)->get();
        return view('job_position.show', ['data' => $data, 'user' => $user, 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $location = JobPosition::findOrFail($id);
        $location->update($request->all());
        return redirect(route('job-position.index'));
    }

}
